<?php  


//获取微信token验证
 define("TOKEN","luchenzhi");

 $wechatObj = new wechatCallbackapiTest();
 if(isset($_GET['echostr'])){
 	 $wechatObj->vaild();

 	}else{
 		$wechatObj->handleText($postObj);
 	}

 class wechatCallbackapiTest
 {
 	private function checkSignature()
 	{
 		$signature 	= $_GET["signature"];
 		$timestamp 	= $_GET['timestamp'];
 		$nonce 		= $_GET['nonce'];

 		$token 		= TOKEN;
 		$tmpArr 	= array($token,$timestamp,$nonce);
 		sort($tmpArr);
 		$tmpstr		=implode($tmpArr);
 		$tmpstr		=sha1($tmpstr);

 		if($tmpstr == $signature)
 		{
 			return true;
 		}else
 		{
 			return false;
 		}
 	}


 	public function Vaild()
 	{
 		$echostr	= $_GET['echostr'];

 		//验证signature
 		if($this -> checkSignature())
 		{
 			echo $echostr;
 			exit;
 		}
 	}

 	//文本回复格式
 	public function _response_text($object,$content)
 	{
 		$textTpl 	= "<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>%d</FuncFlag>
                </xml>";
        $resultStr	= sprintf($textTpl,$object->FromUserName,$object->ToUserName,time(),$content,$flag) ;
        return $resultStr;     
 	}


 	//文本回复方法
 	public function handleText($postObj)
 	{
 		$keyword  	= trim ($postObj->Content);

 		if(!empty($keyword))
 		{
 			$contentStr ="欢迎来到瞳狱";
 			$resultStr	=_response_text($postObj,$contentStr);
 			echo $resultStr;
 		}else{
 			echo "input something...";
 		}
 	}
 }