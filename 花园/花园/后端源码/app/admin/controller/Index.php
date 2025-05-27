<?php
namespace app\admin\controller;
use app\admin\model\Community\CommunityArticle;
use app\admin\model\Discover\DiscoverArticle;
use app\admin\model\Member;
use app\admin\model\QA\Question;
use utils\Auth;

class Index extends Admin
{
	
	//框架主体
    public function index(){
		$menu = $this->getSubMenu(0);
		$cmsMenu = include app()->getRootPath().'/app/admin/controller/Cms/config.php';	//cms菜单配置
		if($cmsMenu){
			$menu = array_merge($cmsMenu,$menu);
		}
		$this->view->assign('menus',$menu);
		return view('index');
    }

	
	//生成左侧菜单栏
	private function getSubMenu($pid){
		$list = db("menu")->where(['status'=>1,'app_id'=>1,'pid'=>$pid])->order('sortid asc')->select();
		if($list){
			foreach($list as $key=>$val){
				$sublist = db("menu")->where(['status'=>1,'app_id'=>1,'pid'=>$val['menu_id']])->order('sortid asc')->select();
				if($sublist){
					$menus[$key]['sub'] = $this->getSubMenu($val['menu_id']);
				}
				$menus[$key]['title'] = $val['title'];
				$menus[$key]['icon'] = !empty($val['menu_icon']) ? $val['menu_icon'] : 'fa fa-clone';
				$menus[$key]['url'] = !empty($val['url']) ? (strpos($val['url'], '://') ? $val['url'] : url($val['url'])) :  url('admin/'.str_replace('/','.',$val['controller_name']).'/index');
				$menus[$key]['access_url'] = !empty($val['url']) ? $val['url'] :  'admin/'.str_replace('/','.',$val['controller_name']);
			}
			return $menus;
		}
	}
	
	
	//后台首页框架内容
	public function main(){

        $dis['d'] = DiscoverArticle::whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')")->count();
        $dis['m'] = DiscoverArticle::whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m')")->count();
        $dis['count'] = DiscoverArticle::count();

        $comm['d'] = CommunityArticle::whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')")->count();
        $comm['m'] = CommunityArticle::whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m')")->count();
        $comm['count'] = CommunityArticle::count();

        $qa['d'] = Question::whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')")->count();
        $qa['m'] = Question::whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m')")->count();
        $qa['count'] = Question::count();

        $member['d'] = Member::whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')")->count();
        $member['m'] = Member::whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time),'%Y-%m') = DATE_FORMAT(NOW(),'%Y-%m')")->count();
        $member['count'] = Member::count();

        //送
        $m = db('integer_log')->field("DATE_FORMAT(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'),'%d') as m,sum(`integer`) as num")
            ->whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'),'%Y%m')=DATE_FORMAT(CURDATE(),'%Y%m')")
            ->where('type',2)->group('m')->select()->toArray();
        $m_s_data = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        foreach($m as $v){
            $m_s_data[(int)$v['m']-1] = $v['num'];
        }
        
        //当月天查询数量
        $m = db('integer_log')->field("DATE_FORMAT(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'),'%m') as m,sum(`integer`) as num")
            ->whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'),'%Y')=DATE_FORMAT(CURDATE(),'%Y')")
            ->where('type',2)->group('m')->order('m desc')->limit(12)->select()->toArray();

        $y_s_data = [1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
        foreach($m as $v){
            $y_s_data[(int)$v['m']] = $v['num'];
        }
        ksort($y_s_data);


        //消耗
        $m = db('integer_log')->field("DATE_FORMAT(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'),'%d') as m,sum(`integer`) as num")
            ->whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'),'%Y%m')=DATE_FORMAT(CURDATE(),'%Y%m')")
            ->where('type',1)->group('m')->select()->toArray();
        $m_x_data = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
        foreach($m as $v){
            $m_x_data[(int)$v['m']-1] = $v['num'];
        }

        //当月天查询数量
        $m = db('integer_log')->field("DATE_FORMAT(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'),'%m') as m,sum(`integer`) as num")
            ->whereRaw("DATE_FORMAT(FROM_UNIXTIME(create_time,'%Y-%m-%d %H:%i:%s'),'%Y')=DATE_FORMAT(CURDATE(),'%Y')")
            ->where('type',1)->group('m')->order('m desc')->limit(12)->select()->toArray();
            
        $y_x_data = [1=>0,2=>0,3=>0,4=>0,5=>0,6=>0,7=>0,8=>0,9=>0,10=>0,11=>0,12=>0];
        foreach($m as $v){
            $y_x_data[(int)$v['m']] = $v['num'];
        }
        ksort($y_x_data);
        

        $this->view->assign('dis',$dis);
        $this->view->assign('comm',$comm);
        $this->view->assign('member',$member);
        $this->view->assign('m_s_data',$m_s_data);
        $this->view->assign('y_s_data',$y_s_data);
        $this->view->assign('m_x_data',$m_x_data);
        $this->view->assign('y_x_data',$y_x_data);
        $this->view->assign('qa',$qa);
		return view('main');
	}
	
}
