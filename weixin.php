<?php
/**
  * wechat php test
  */

require('mysql.php');

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET["echostr"])){
  $wechatObj->valid();
}else{
  $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
  public function valid()
  {
    $echoStr = $_GET["echostr"];

    //valid signature , option
    if($this->checkSignature()){
      echo $echoStr;
      exit;
    }
  }

  public function responseMsg()
  {
    //get post data, May be due to the different environments
    $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      //extract post data
    if (!empty($postStr)){
        libxml_disable_entity_loader(true);
          $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
              <ToUserName><![CDATA[%s]]></ToUserName>
              <FromUserName><![CDATA[%s]]></FromUserName>
              <CreateTime>%s</CreateTime>
              <MsgType><![CDATA[%s]]></MsgType>
              <Content><![CDATA[%s]]></Content>
              <FuncFlag>0</FuncFlag>
              </xml>";       
        if(!empty( $keyword ))
        {
          $mysql = new MySQL();
          $mysql->connect_mysql();
          $ret = $mysql->wid_person($name, $fromUsername);
          $strArr = explode(" ", $keyword);
          if ($strArr[0] == 'bind'){
            $res = $mysql->has_person($strArr[1], $strArr[2]);
            $contentStr="Failed!";
            if ($res == true){
              $mysql->info_person($strArr[1], $email, $info, $strArr[2], $wid);
              $mysql->update_person($strArr[1], $strArr[1], $email, $info, $strArr[2], $fromUsername);
              $contentStr="Success!";
            }
          }
          else if ($strArr[0] == 'list' && $ret == 0){
            $contentStr="\n";
            $pojs = $mysql->show_projects($name);
            foreach($pojs as $project_id){
              $mysql->info_project($project_id, $project, $info);
              $contentStr=$contentStr.$project."\n";
              $mysql->flush_project($project);
              $data = $mysql->show_events_person($name, $project_id);
              if (sizeof($data) != 0){
                foreach ($data as $dt){
                  $contentStr=$contentStr."\t".$dt['name']."\n";
                }
              }
              $contentStr=$contentStr."\n";
            }
          }
          else if ($strArr[0] == 'push' && $ret == 0){
            $mysql->info_event($strArr[2], $start, $end, $strArr[1], $status, $info, $id);
            $mysql->change_status($id);
            $contentStr="Success!";
          }
          $msgType = "text";
          $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
          echo $resultStr;
          $mysql->close_mysql();

        }else{
          echo "Input something...";
        }

    }else {
      echo "";
      exit;
    }
  }
    
  private function checkSignature()
  {
    // you must define TOKEN by yourself
    if (!defined("TOKEN")) {
      throw new Exception('TOKEN is not defined!');
    }
    
    $signature = $_GET["signature"];
    $timestamp = $_GET["timestamp"];
    $nonce = $_GET["nonce"];
        
    $token = TOKEN;
    $tmpArr = array($token, $timestamp, $nonce);
    // use SORT_STRING rule
    sort($tmpArr, SORT_STRING);
    $tmpStr = implode( $tmpArr );
    $tmpStr = sha1( $tmpStr );
    
    if( $tmpStr == $signature ){
      return true;
    }else{
      return false;
    }
  }
}


?>
