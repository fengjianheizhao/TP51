<?php
/**
 * 
 * @authors lcz (lu935923945@hotmail.com)
 * @date    2017-05-30 15:22:23
 * @version $Id$
 */

namespace app\admin\controller;

use app\admin\BaseController;
use think\View;
use think\Loader;
use think\Controller;
use think\Db;


class Login extends Controller {
    
    // function __construct(){
        
    // }

   public function index() {

    	return $this->view->fetch('login');
    }


     public function test() {
     	//获取登录ajax传过来的值
     	$username=json_decode($_POST['name']);
     	$pwd=json_decode($_POST['pwd']);
     	$data=$_POST['captcha'];

     	$mpwd=md5($pwd);
     	$time=time();
     	$data1=['username'=>"$username",'password'=>"$mpwd",'logtime'=>"$time"];
     	Db::name('user')->insert($data1);

     	
     	if(!captcha_check($data)){
     		echo '2';
     	}
     	elseif($username=='123'&$pwd=='123456')
     	{
     		echo'1';
     	}else{
     		echo'0';
     	}
     	

//     if(!captcha_check($data)){
//      echo'<script type="text/javascript">
//   alert("888888");
// </script>';
// }else{
// 	echo'77777';  	
//     }
	}
}