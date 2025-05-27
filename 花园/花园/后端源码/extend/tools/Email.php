<?php

namespace tools;


use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    private $debug = 0;     //1 开启 0 关闭

    private $mailObject;  //对象

    public function __construct($toAddress)
    {
        $field = [
            'email_stmp_address',
            'email_stmp_port',
            'email_username',
            'email_nickname',
            'email_stmp_code',
        ];
        //获取配置项
        $config = db('config')->whereIn('name',$field)->column('data','name');

        // 实例化PHPMailer核心类
        $mail = new PHPMailer();
        // 是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug = $this->debug;
        // 使用smtp鉴权方式发送邮件
        $mail->isSMTP();
        // smtp需要鉴权 这个必须是true
        $mail->SMTPAuth = true;
// 链接qq域名邮箱的服务器地址
        $mail->Host = $config['email_stmp_address'];
// 设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';
// 设置ssl连接smtp服务器的远程服务器端口号
        $mail->Port = $config['email_stmp_port'];
// 设置发送的邮件的编码
        $mail->CharSet = 'UTF-8';
// 设置发件人昵称 显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = $config['email_nickname'];
// smtp登录的账号 QQ邮箱即可
        $mail->Username =  $config['email_username'];
// smtp登录的密码 使用生成的授权码
        $mail->Password =  $config['email_stmp_code'];

// 设置发件人邮箱地址 同登录账号
        $mail->From = $config['email_username'];
// 邮件正文是否为html编码 注意此处是一个方法
        $mail->isHTML(true);
    // 设置收件人邮箱地址

        if (is_array($toAddress)){
            foreach ($toAddress as $k => $v){
                $mail->addAddress($v);
            }
        }else{
            $mail->addAddress($toAddress);
        }

        $this->mailObject = $mail;

    }



    public function send($subject,$code){
        $time = strtotime("Y-m-d");
        $body = '<table cellpadding="0" cellspacing="0" bgcolor="#f7f7f7" width="100%" style="" class="baidu_pass">
        <tbody>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td style="width: 60px;">
                                    &nbsp;
                                </td>
                              
                                <td style="">
                                    &nbsp;
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" width="96%" style="background: #ffffff; border: 1px solid rgb(204,204,204);
                        margin: 2%;">
                        <tbody>
                            <tr>
                                <td width="30px;">
                                    &nbsp;
                                </td>
                                <td align="">
                                    <div style="line-height: 40px; height: 40px;">
                                        &nbsp;</div>
                                    <p style="margin: 0px; padding: 0px;">
                                        <strong style="font-size: 14px; line-height: 30px; color: #333333; font-family: arial,sans-serif;">
                                            亲爱的用户：</strong></p>
                                    <div style="line-height: 20px; height: 20px;">
                                        &nbsp;</div>
                                    <p style="margin: 0px; padding: 0px; line-height: 30px; font-size: 14px; color: #333333;
                                        font-family: \'宋体\',arial,sans-serif;">
                                        您好！感谢您使用万博服务，您正在进行邮箱验证，本次请求的验证码为：</p>
                                    <p style="margin: 0px; padding: 0px; line-height: 30px; font-size: 14px; color: #333333;
                                        font-family: \'宋体\',arial,sans-serif;">
                                        <b style="font-size: 18px; color: #ff9900"><span style="border-bottom: 1px dashed #ccc;
                                            z-index: 1" t="7" data="123877">'.$code.'</span></b><span style="margin: 0px;
                                                padding: 0px; margin-left: 10px; line-height: 30px; font-size: 14px; color: #979797;
                                                font-family: \'宋体\',arial,sans-serif;">(为了保障您帐号的安全性，请尽快完成验证。)</span></p>
                                    <div style="line-height: 80px; height: 80px;">
                                        &nbsp;</div>
                                    <p style="margin: 0px; padding: 0px; line-height: 30px; font-size: 14px; color: #333333;
                                        font-family: \'宋体\',arial,sans-serif;">
                                        万博帐号团队</p>
                                    <p style="margin: 0px; padding: 0px; line-height: 30px; font-size: 14px; color: #333333;
                                        font-family: \'宋体\',arial,sans-serif;">
                                        <span style="border-bottom: 1px dashed #ccc;" t="5" times=""><span style="border-bottom:1px dashed #ccc;" t="5" times="">'.$time.'</span></span></p>
                                    <div style="line-height: 20px; height: 20px;">
                                        &nbsp;</div>
                                </td>
                                <td width="30px;">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td width="30px;">
                                    &nbsp;
                                </td>
                           
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>';
// 添加该邮件的主题
        $this->mailObject->Subject = $subject;
// 添加邮件正文
        $this->mailObject->Body = $body;
//// 为该邮件添加附件
//        $mail->addAttachment('./example.pdf');
// 发送邮件 返回状态
        $status = $this->mailObject->send();
    }

}

