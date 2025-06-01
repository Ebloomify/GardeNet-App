<?php
declare (strict_types=1);

namespace app\command;

use app\api\service\RedisService;
use app\api\service\V1\GardenService;
use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;

class Task extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('task')
            ->addArgument('action', Argument::OPTIONAL, "action", '')
            ->addArgument('force', Argument::OPTIONAL, "force", '')
            ->setDescription('the task command');
    }

    protected function execute(Input $input, Output $output)
    {

        //获取输入参数
        $action = trim($input->getArgument('action'));
        $force = trim($input->getArgument('force'));

        // 配置任务，每隔20秒访问2次网站
        $task = new \EasyTask\Task();
        $task->setRunTimePath('./runtime/');
        $task->addFunc(function () {
            //查找redis中小于当前的时间戳
            $member = RedisService::connect()->zrevrangebyscore('Garden:remind',time(),0);
            foreach($member as $v){
                $remind_id = explode('.',$v);
                if($remind = db('remind')->where('id',$remind_id[1])->find()){
                    //创建API，APPID等配置参考 环境要求 进行获取
                    \utils\uniapp\GeTui::getObject();
                    $data = [
                        'urlStr'=>'/pages/center/garden/info?id='.$remind['garden_id'],
                        'title'=>$remind['garden_name'],
                        'body'=>$remind['remind_name'],
                        'intent_arr'=> ['title'=>$remind['garden_name'],'body'=>$remind['remind_name']],  //普通消息和透传需要
                    ];
                    \utils\uniapp\GeTui::setMessageData($data);
                    \utils\uniapp\GeTui::pushOneMessage($remind['client_id']);
                    try{
                        db('remind')->where('id',$remind['id'])->inc('remind_num',1)->update();
                        RedisService::connect()->zrem('Garden:remind',$v);
                    }catch (\Exception $e){
                        Log::error($e->getMessage());
                    }
                }
            }
        }, 'request', 1, 1);

        // 根据命令执行
        if ($action == 'start') {
            $task->start();
        } elseif ($action == 'status') {
            $task->status();
        } elseif ($action == 'stop') {
            $force = ($force == 'force'); //是否强制停止
            $task->stop($force);
        } else {
            exit('Command is not exist');
        }

        // 指令输出
//        $output->writeln('task');
    }
}
