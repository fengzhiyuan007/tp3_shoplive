<?php
namespace Admin\Model;
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
}