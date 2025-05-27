<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/3/22
 * Time: 14:27
 */

namespace tools;


class Seg
{
    //字典
    private $dict = [];

    public function __construct($dict = null)
    {
        $dict && $this->dict = $dict;
    }

    //获取keyword结果
    public function getKeywords($str)
    {
        $chinese = $this->getChinese($str);

        $int = $this->getInt($str);

        $return = implode(' ',array_values(array_unique(array_merge($chinese,$int))));

        return trim($return);
    }



    //获取中文分词
    public function getChinese($vStr = '')
    {
        $encode = mb_detect_encoding($vStr, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5','LATIN1'));
        if($encode != 'UTF-8'){
            $vStr = mb_convert_encoding($vStr, 'UTF-8', $encode);
        }
//        $current_encode = mb_detect_encoding($vStr, array("ASCII","GB2312","GBK",'BIG5','UTF-8'));
//
//        $vStr = mb_convert_encoding($vStr, 'UTF-8', $current_encode);

        $strDict = implode('|',$this->dict);
        preg_match_all('/('.$strDict.')?+/', $vStr,$res);

        $return = array_unique($res[0]);


        return $return;
    }

    //获取获取数字分词
    public function getInt($vStr = '')
    {

        preg_match_all( '/\d+/' , $vStr , $res );

        $return = array_unique($res[0]);

        return $return;
    }


}