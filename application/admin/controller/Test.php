<?php
/**
 * 
 * @authors lcz (lu935923945@hotmail.com)
 * @date    2017-05-27 11:50:20
 * @version $Id$
 */

namespace app\admin\controller;

use app\admin\BaseController;
use think\Loader;
use think\Db;
use think\View;

class Test extends BaseController{
    public function test()
    {
    	// $view = new View();
       return $this->view->fetch('');
    }

     public function hui()
    {
    	// $view = new View();
       return $this->view->fetch('demo');
    }

    public function user()

    {
    	$time=time();
    	$data=['username'=>'6666','password'=>'4561236544','logtime'=>"$time"];
    	Db::name('user')->insert($data);
    }
}
