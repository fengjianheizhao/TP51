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
use think\Session;
use think\Config;
//use think\cache\driver\Redis;

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
    	// $time=time();
    	// $data=['username'=>'6666','password'=>'4561236544','logtime'=>"$time"];
    	// Db::name('user')->insert($data);
    	$username='123';
    	$tpwd=Db::name('user')->where('username',"$username")->find();
    	print_r($tpwd);
    	echo'<br/>';
	echo'<br/>';
	echo'<br/>';
	echo'<br/>';
    	$username=Session::get('user.name');
    	print_r($username);
    	echo'<br/>';
	echo'<br/>';
	echo'<br/>';
	echo'<br/>';
    	print_r($_SESSION);


	$uid=Session::get('user.id');
	// $sql="select role,action from lcz_group where id in (select gid from lcz_usergroup where uid = $uid )";
		$prefix = Config::get("database.prefix");
    	$sql="select role,action from ". "{$prefix}group where id in (select gid from"." {$prefix}usergroup where uid = $uid )";
	$nodes = Db::query($sql);
	print_r($nodes);
	$menu=Db::name("system")->where('level=0')->select();
	echo'<br/>';
	echo'<br/>';
	echo'<br/>';
	echo'<br/>';
	print_r($menu);
	$menu2=Db::name("system")->where('level>0')->select();
	echo'<br/>';
	echo'<br/>';
	echo'<br/>';
	echo'<br/>';
	print_r($menu2);
	echo'<br/>';
	echo'<br/>';
	echo'<br/>';
	echo'<br/>';

		$allmenu=array();
		foreach($menu as $k=>$v){
			foreach($menu2 as $k1=>$v2){
				if($v['id']==$v2['fid']){
					$v['child']=$v2;
					$allmenu[]=$v;
					// unset($menu2[$k1]);
					// $menu2[$v]=$v2;
				}
			}
		}
	print_r($allmenu);

	echo'<br/>';
	echo'<br/>';
	echo'<br/>';
	echo'<br/>';
		$allmenu1=array();
	foreach ($allmenu as $key => $value) {
		$name1=$value['name'];

		$allmenu1[$name1][]=$value['child'];
	}
	print_r($allmenu1);


	foreach ($allmenu1 as $key => $value) {
		echo'<br/>';
			
	echo'<br/>';
		print_r($key);
		foreach ($value as $k => $v) {
			echo'<br/>';
			print_r($v['name']);
	echo'<br/>';
		print_r($v['controller']);
		echo'<br/>';
	echo'<br/>';
		}
		
	}

	}

	public function menu(){
		$uid=2;
		// $menu=Loader::model('AdminNode','model')->getMenu($uid);
		// print_r($menu);
		$prefix = Config::get("database.prefix");
    	$sql="select role,action from ". "{$prefix}group where id in (select gid from"." {$prefix}usergroup where uid = $uid )";
	$nodes = Db::query($sql);
	$rolename=$nodes[0]['role'];
		$role=$nodes[0]['action'];
		$action=explode(',', $role);

		//取出一级菜单
		$res['level']=['=',0];
		$res['id']=['in',$action];
		$menu=Db::name("system")->where($res)->select();
        //取出2级菜单
        $res1['level']=['>',0];
		$res1['id']=['in',$action];
		$menu2=Db::name("system")->where($res1)->select();

		$allmenu=array();
				foreach($menu as $k=>$v){
					foreach($menu2 as $k1=>$v2){
						if($v['id']==$v2['fid']){
							$v['child']=$v2;
							$allmenu[]=$v;
						}
					}
				}

				$allmenu1=array();
				foreach ($allmenu as $key => $value) {
				$name1=$value['name'];

				$allmenu1[$name1][]=$value['child'];
			}



		
		echo'<br/>';
		print_r($allmenu1);
	}

	public function image(){
        
        // $images=Db::name('image')->field('path')->select();
         $allimage=Loader::model('ImageNode','model')->getallimage();
        print_r($allimage);
         $this ->view ->assign('images',$allimage);
         return $this->view->fetch('');
    }

    public function upload(){
                //获取表单上传文件
        $files = request()->file('image');
        print_r($files);

        //把文件移动到应用根目录下载文件夹中/public/upload/
        $info = $files->move(ROOT_PATH.'public'.DS.'upload');
        if($info){
            $image=array();
            //上传成功后，获得上传信息
            //输出jpg
            echo $info->getExtension();
            //输出路径
            echo $image['path']=$info->getSaveName();
            //输出文件名
            echo  $image['name']=$info->getFilename();
           

           $addimage=Loader::model('ImageNode','model')->addimage($image);

        }else{
            //上传失败获取错误信息
            echo $files->getError();
        }

    }


    public function text()
    {
        $text = Loader::model('ImageNode','model')->getimage(15);

        $text_path='http://www.tp5.com/upload/'.$text['path'];
        $str = file_get_contents($text_path);//将整个文件内容读入到一个字符串中
//        $str = str_replace("\r\n","<br />",$str);
        print_r($str) ;

    }

    public function new_redis()
    {
        $redis =new \Redis;
//        $redis->set('test','hello 1is');
//        echo $redis->get('test');
        $redis->connect('127.0.0.1', 6379);
        $res=$redis->llen('goods_store');
        echo $res;
        $store=1000;
        $count=$store-$res;
        for($i=0;$i<$count;$i++){
            $redis->lpush('goods_store',1);
        }
        echo $redis->llen('goods_store');

    }

    public function group(){

        $sql='select username,d.role,d.id,d.action from lcz_user  as c, (select b.uid,a.id,a.role,a.action from lcz_usergroup as b,lcz_group as a  where b.gid=a.id) d where c.id = d.uid';
        $role=Db::query($sql);

       $this->view->assign('role',$role);
        print_r($role);
    }
}