<?php
namespace app\admin\controller;
 

use app\admin\BaseController;
use think\Loader;
use think\Db;
use think\View;

class Index  extends BaseController
{
    public function index()
    {
        return $this->view->fetch('');
    }


    public function welcome()
    {
        return $this->view->fetch('');
    }

}
