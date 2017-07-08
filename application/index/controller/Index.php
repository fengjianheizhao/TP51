<?php
namespace app\index\controller;

use think\View;
use think\Loader;
use think\Controller;
use think\Db;
use think\Session;
class Index  extends controller
{
    public function index()
    {
        $allimage=Db::name('image')->select();

        for ($i=0; $i <count($allimage) ; $i++) {
            $allimage[$i]['path']=str_replace('\\','/', $allimage[$i]['path']) ;
        }
         $this->view->assign('allimage',$allimage);
        return $this->view->fetch('index');
    }
}
