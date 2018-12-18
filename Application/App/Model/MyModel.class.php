<?php
namespace App\Model;
use Think\Model;

class MyModel extends Model
{
	protected $domain_url;
    protected function initialize(){
        parent::initialize();
        $this->domain_url = C('IMG_PREFIX');
    }

    protected function domain($url){
        if(strpos($url,'http://') !== false){
            return $url;
        }else{
            return $this->domain_url.$url;
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
}