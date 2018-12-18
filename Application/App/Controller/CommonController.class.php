<?php

namespace App\Controller;

use Think\Controller;

class CommonController extends Controller {
	public function two_sort($list,$field,$direction){
		$sort = array(    
	            'direction' => $direction, //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序    
	            'field'     => $field,       //排序字段    
	    );    
	    $arrSort = array();    
	    foreach($list AS $uniqid => $row){    
	        foreach($row AS $key=>$value){    
	            $arrSort[$key][$uniqid] = $value;    
	        }    
	    }    
	    if($sort['direction']){    
	        array_multisort($arrSort[$sort['field']], constant($sort['direction']), $list);    
	    } 
	    return $list;   

	}

/********************************************百台云********************************************/
	protected $member;
    public $url='';
    public function _initialize(){
        header('Content-Type: application/json');
        header("Content-type:text/html;charset=utf-8");
        header("Access-Control-Allow-Origin:*");
        // define('CONTROLLER_NAME',Request::instance()->controller());
        // define('MODULE_NAME',Request::instance()->module());
        // define('ACTION_NAME',Request::instance()->action());

        $this->url = C('IMG_PREFIX');
        $text="\n\n".date("y-m-d H:i:s",time())."\n".$_SERVER["QUERY_STRING"]."\rpost:\r".var_export($_POST,true)."\rget:\r".var_export($_GET,true)."\rfile:\r".var_export($_FILES,true);
        file_put_contents("logo.txt", $text, FILE_APPEND);
    }
    public function get_guid(){
        mt_srand((double)microtime()*10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);
        $uuid =  substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12) ;
        return strtolower($uuid);
    }
    public function api_return($code,$msg,$data=''){
        header('Content-Type: application/json');
        echo json_encode(array('code'=>$code?:'999','msg'=>$msg?:'未知错误','data'=>$data));
        exit();
    }

    public function _empty(){
        return error("操作失败");
    }

    protected function set_pages($page_data,$pageurl) {
        $this->assign('page_vars', $page_data);
        $this->assign('page_url', $pageurl);
        $pagehtml = $this->display('public:page');
        $this->assign('page', $pagehtml);
    }

    
    //判断是否正正数
    protected function isSignlessInteger($string){
        if ((floor($string) - $string) !==0){
            return true;
        }else{
            return false;
        }
    }
    //根据地址获取经纬度
    protected function getLonLat($address){
        $ak =M('system')->where(['id'=>'1'])->getField('baidu_apikey');
        $api = 'http://api.map.baidu.com/geocoder/v2/?ak='.$ak.'&output=json&address='.$address;

        $position = file_get_contents($api);
        $position = json_decode($position, true);
        $array = $position['result']['location'];
        $position = array($array['lng'],$array['lat']);//经度，纬度
        return $position;
    }

    protected function time2Units ($time) //计算时间
    {
        $year   = floor($time / 60 / 60 / 24 / 365);
        $time  -= $year * 60 * 60 * 24 * 365;
        $month  = floor($time / 60 / 60 / 24 / 30);
        $time  -= $month * 60 * 60 * 24 * 30;
        $week   = floor($time / 60 / 60 / 24 / 7);
        $time  -= $week * 60 * 60 * 24 * 7;
        $day    = floor($time / 60 / 60 / 24);
        $time  -= $day * 60 * 60 * 24;
        $hour   = floor($time / 60 / 60);
        $time  -= $hour * 60 * 60;
        $minute = floor($time / 60);
        $time  -= $minute * 60;
        $second = $time;
        $elapse = '';

        $unitArr = array('年'  =>'year', '个月'=>'month',  '周'=>'week', '天'=>'day',
            '小时'=>'hour', '分钟'=>'minute', '秒'=>'second'
        );

        foreach ( $unitArr as $cn => $u )
        {
            if ( $$u > 0 )
            {
                $elapse = $$u . $cn;
                break;
            }
        }

        return $elapse;
    }

    protected function timediff($begin_time,$end_time)
    {
        if($begin_time < $end_time){
            $starttime = $begin_time;
            $endtime = $end_time;
        }else{
            $starttime = $end_time;
            $endtime = $begin_time;
        }

        //计算天数
        $timediff = $endtime-$starttime;
        $days = intval($timediff/86400);
        //计算小时数
        $remain = $timediff%86400;//取消注释后下一行的变量改为$remain，则是去掉天数后剩余的小时数，分钟及描述同理
        $hours = intval($timediff/3600);
        //计算分钟数
        $mins = intval(($timediff-$days*86400-$hours*3600)/60);
        //$mins = intval($timediff/60);
        //计算秒数
        //$secs = $timediff-$days*86400-$hours*3600-$remain*60;
        $days   ?   $days = $days.'天'   :   $days = '';
        $hours  ?   $hours = $hours.'小时'    :   $hours = '';
        $mins   ?   $mins = $mins.'分'   :   $mins = '';
        return $days.$hours.$mins;
    }
    /**
     *@写入用户余额记录
     */
    protected function set_amount($member_id,$amount,$type,$content){
        $data['member_id'] = $member_id;
        $data['amount'] =   $amount;
        $data['type']   =   $type;
        $data['content']    = $content;
        $data['intime'] =   date("Y-m-d H:i:s",time());
        $result = M('shop_amount_record')->add($data);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    /**
     *写入用户钻石记录
     * @param $member_id用户id
     * @param $type 1加2减
     * @param $content 内容备注
     * @param $diamond 钻石
     * @param $zeng 赠送的钻石
     */
    // protected function insertDiamondRecord($member_id,$type,$content='',$diamond=0,$zeng=0){
    //     $data['member_id'] = $member_id;
    //     $data['type']   =   $type;
    //     $data['content']    = $content;
    //     $data['diamond'] =   $diamond;
    //     $data['zeng'] =   $zeng;
    //     $data['intime'] =   date("Y-m-d H:i:s",time());
    //     $result = Db::name('diamond_record')->insert($data);
    //     if($result){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }


    /**
     * Strong Blur
     *
     * @param  $gdImageResource  图片资源
     * @param  $blurFactor          可选择的模糊程度
     *  可选择的模糊程度  0使用   3默认   超过5时 极其模糊
     * @return GD image 图片资源类型
     * @author Martijn Frazer, idea based on http://stackoverflow.com/a/20264482
     */
    function blur($gdImageResource, $blurFactor = 3)
    {
        // blurFactor has to be an integer
        $blurFactor = round($blurFactor);

        $originalWidth = imagesx($gdImageResource);
        $originalHeight = imagesy($gdImageResource);

        $smallestWidth = ceil($originalWidth * pow(0.5, $blurFactor));
        $smallestHeight = ceil($originalHeight * pow(0.5, $blurFactor));

        // for the first run, the previous image is the original input
        $prevImage = $gdImageResource;
        $prevWidth = $originalWidth;
        $prevHeight = $originalHeight;

        // scale way down and gradually scale back up, blurring all the way
        for($i = 0; $i < $blurFactor; $i += 1)
        {
            // determine dimensions of next image
            $nextWidth = $smallestWidth * pow(2, $i);
            $nextHeight = $smallestHeight * pow(2, $i);

            // resize previous image to next size
            $nextImage = imagecreatetruecolor($nextWidth, $nextHeight);
            imagecopyresized($nextImage, $prevImage, 0, 0, 0, 0,
                $nextWidth, $nextHeight, $prevWidth, $prevHeight);

            // apply blur filter
            imagefilter($nextImage, IMG_FILTER_GAUSSIAN_BLUR);

            // now the new image becomes the previous image for the next step
            $prevImage = $nextImage;
            $prevWidth = $nextWidth;
            $prevHeight = $nextHeight;
        }

        // scale back to original size and blur one more time
        imagecopyresized($gdImageResource, $nextImage,
            0, 0, 0, 0, $originalWidth, $originalHeight, $nextWidth, $nextHeight);
        imagefilter($gdImageResource, IMG_FILTER_GAUSSIAN_BLUR);

        // clean up
        imagedestroy($prevImage);

        // return result
        return $gdImageResource;
    }

    


    
    

    
    
/********************************************百台云********************************************/

}