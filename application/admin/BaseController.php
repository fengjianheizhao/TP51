<?php
/**
 * 
 * @authors lcz (lu935923945@hotmail.com)
 * @date    2017-05-27 15:32:46
 * @version $Id$
 */

namespace app\admin;

use think\Model;
use think\View;
use think\Request;
use think\Session;
use think\Db;
use think\Config;
use think\Loader;
use think\Exception;
use think\exception\HttpException;
use think\Controller;


class BaseController extends Controller  {


	/**
	 * @var  View 视图类实例
	 */
	protected $view;
	/**
	 * @var  Request  Request实例
	 */
	protected $request;
    
    function __construct(){

        parent::__construct();

        if (null === $this->view) {
            $this->view = View::instance(Config::get('template'), Config::get('view_replace_str'));
        }

        if (null === $this->request) {
            $this->request = Request::instance();
        }


        // if(session('admin_id')>0){
        // 	$this->view->fetch()

        // }

    }


    /*
     * 初始化操作
     */
    public function _initialize() 
    {
       
         $username = session('user');
         if($username==''){
            $this->error("请先登录","admin\Login\index");
         }
       
    }
}