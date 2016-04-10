<?php
/**
  * wechat php test
  */

//define your token
define("TOKEN", "改成你的微信公众号的token");
$wechatObj = new wechatCallbackapiTest();
if(isset($_GET["echostr"])){        
  $wechatObj->responseMsg();
  $wechatObj->valid();
  }else{
  $wechatObj->responseMsg();
}




class wechatCallbackapiTest
{
    
public function valid(){
        $echoStr = $_GET["echostr"];
        //valid signature , option
    if($this->checkSignature()){
        echo $echoStr;
        exit;
      }
    }

public function responseMsg(){
      //get post data, May be due to the different environments
     $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
      //extract post data
if (!empty($postStr)){                
    $postObj=simplexml_load_string($postStr,'SimpleXMLElement',LIBXML_NOCDATA); //XML 字符串载入对象中
     $fromUsername = $postObj->FromUserName;
     $toUsername = $postObj->ToUserName;
     $keyword = trim($postObj->Content);
     $msgType = $postObj->MsgType;
     $time = time();

//根据不同类型进行回复
switch( $msgType ){
    
//关注时自动回复
   case "event":  
    $textTpl = "<xml>
          <ToUserName><![CDATA[%s]]></ToUserName>
          <FromUserName><![CDATA[%s]]></FromUserName>
          <CreateTime>%s</CreateTime>
          <MsgType><![CDATA[%s]]></MsgType>
          <Content><![CDATA[%s]]></Content>
          <FuncFlag>0</FuncFlag>
          </xml>";
    $event = $postObj->Event;
    $msgType = "text";
    if( $event =='subscribe'){
    $contentStr = "欢迎关注华工青年\n请输入“姓名+账号”进行账号的绑定（如“张三+201236545152”）!\n\n回复“解除绑定”可重新绑定账号\n\n 回复“活动”查看近期可抢票的活动\n\n回复“抢票+活动编号”即可参与抢票（如“抢票+2”）\n\n回复“查票+活动编号”即可查看是否已抢到票\n\n
      (注：活动编号通过回复“活动”查看)";
}
    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    echo $resultStr;
    break;
    
    
//文本类型
    case "text": //这个xml格式的数据是你服务器上的数据，是要传回公众平台的
    $textTpl = "<xml>
          <ToUserName><![CDATA[%s]]></ToUserName>
          <FromUserName><![CDATA[%s]]></FromUserName>
          <CreateTime>%s</CreateTime>
          <MsgType><![CDATA[%s]]></MsgType>
          <Content><![CDATA[%s]]></Content>
          <FuncFlag>0</FuncFlag>
          </xml>";         
   
        if( $keyword =='时间' || $keyword =='time' || $keyword =="shijian"){
        $contentStr = date("Y-m-d H:i:s",time());
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;
        }
       
       elseif($keyword == '解除绑定'){
       $link = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
              if($link){
                        mysql_select_db(SAE_MYSQL_DB,$link);
                        //your code goes here
                        mysql_query("set names utf8");
                       $query="select * from student where wid = '$fromUsername' ";
                       $result= mysql_query($query, $link);
                       $row = mysql_fetch_array($result);
                       if ($row[0] > 0) {            //微信号已经绑定了
                       $query=" delete from student where wid = '$fromUsername' ";  
                       $result= mysql_query($query, $link);
                       if($result)   $contentStr = "解除绑定成功，请按格式“姓名+学号”回复进行绑定（如“张三+20156589788”）";
                       else          $contentStr = "解除绑定失败，请重新尝试";
                       $query=" delete from e2 where wid = '$fromUsername' ";  
                       $result= mysql_query($query, $link);
                        }
                else{   
                        $contentStr = "请先按格式“姓名+学号”回复进行绑定（如“张三+20156589784”）";
                        }
              $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
              echo $resultStr;
              mysql_close($link);
            }
        }



        elseif ( $keyword == "活动" ){
      
          //列出现有的活动
            $ctime=date("Y-m-d H:i:s",time()); //获取当前时间
            
             //连接数据库
            $link = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
              if($link){
                        mysql_select_db(SAE_MYSQL_DB,$link);
                        //your code goes here
                        mysql_query("set names utf8");
                  
                 $query="select * from  event where  eqtime > '$ctime' ";
                 $result = mysql_query($query, $link);
                 $num=mysql_num_rows($result);       //统计近期可抢票的活动数  
                 $contentStr="近期可抢票的活动共有 $num 个,回复“抢票+活动编号”即可进行抢票"; 
                 while( $row = mysql_fetch_row($result) ){     
                 $contentStr="$contentStr"."\n\n\n活动编号:$row[0]\n活动名称:$row[1]\n活动开始时间:$row[2]\n活动举办地点:$row[3]\n抢票时间段:\n$row[5]到$row[6]\n详细信息请访问:$row[7]";
                            }$msgType = "text";
                        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                echo $resultStr;
                     
                       }          
              
               else{   
                        $contentStr = "执行语句发生错误，抢票失败";
                        die('Error: ' . mysql_error());
                        }
              mysql_close($link);
                    }
    
      
             else{
        $msgType = "text";
                //把学号和姓名拆开,检查中英两个
                $info=explode("+",$keyword);
                if(empty($info[1]))   $info=explode("+",$keyword);     
                if(empty($info[1])){
                    //回复其他关键字时的回复
         $contentStr = "欢迎关注华工青年，\n请输入“姓名+账号”进行账号的绑定（如“张三+201236545152”）!\n\n回复“解除绑定”可重新绑定账号\n\n 回复“活动”查看近期可抢票的活动\n\n回复“抢票+活动编号”即可参与抢票(如“抢票+2”)\n\n回复“查票+活动编号”即可查看是否已抢到票\n\n(注：活动编号通过回复“活动”查看)";
                }
                 
                 
                 
             elseif($info[0] == "查票"){
                     
                      //连接数据库
                  $link = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                  if($link){
                        mysql_select_db(SAE_MYSQL_DB,$link);
                        //your code goes here
                        mysql_query("set names utf8");
                      //检查账号是否已经绑定了，还没绑定不能查票
                       $query="select * from student where wid = '$fromUsername' ";
                       $result= mysql_query($query, $link);
                       $row = mysql_fetch_array($result);
                      if ($row[0] > 0) {      //微信号已经绑定了
                           //检查微信绑定后再检查活动编号是否正确
                             $tab="e".$info[1];
                             $query="select * from $tab";
                             $result= mysql_query($query, $link);  //没有时$result为空字符串
                      if( $result){
                         //获取活动名称、地点、时间
                             $query="select * from event where eventid = '$info[1]' ";
                             $result= mysql_query($query, $link);
                             $row = mysql_fetch_row($result);
                             $ename=$row[1];
                             $etime=$row[2];
                             $eaddr=$row[3];
                         //查询抢票是否成功
                             $query="select * from $tab where wid = '$fromUsername'";
                             $result= mysql_query($query, $link);
                             $row = mysql_fetch_row($result);
                             if ($row){    
                                 if ($row[3]=='1')  $contentStr="恭喜你已成功抢到活动\"$ename\"的入场券，请于18:00凭微信和学生证到活动现场领票。\n\n活动举办的时间：$etime \n\n地点：$eaddr";
                               elseif($row[3]=='0')        $contentStr="很遗憾告诉你，你没有抢到活动\"$ename\"的入场券，关注我们下一次的抢票活动吧";                                
                               else    $contentStr="抢票结果会在抢票结束后产生，请耐心等候";
                                }
                               else   $contentStr="你还没参加活动\"$ename\"的抢票，请回复“抢票+活动编号”进行抢票";      
                             }
                         else  $contentStr ="没有该活动";
                           }        
                       else   $contentStr ="还没绑定，请照格式“姓名+学号”回复进行账号的绑定（如“张三+201236545152”）";//还没绑定
                     }
        else  $contentStr = "连接数据库不成功，查票失败";
           mysql_close($link);
                }
                 
                 
                 
                 
           
                 
                elseif ($info[0] == "抢票"){
        
                  //将抢票的学生录入数据库
                  $link = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                  if($link){
                        mysql_select_db(SAE_MYSQL_DB,$link);
                        //your code goes here
                        mysql_query("set names utf8");
                      //检查账号是否已经绑定了，还没绑定不准抢票
                       $query="select * from student where wid = '$fromUsername' ";
                       $result= mysql_query($query, $link);
                       $row = mysql_fetch_array($result);
                       if ($row[0] > 0) {      //微信号已经绑定了
                           //检查微信绑定后再检查活动编号是否正确
                             $tab="e".$info[1];
                             $query="select * from $tab";
                             $result= mysql_query($query, $link);  //没有时$result为空字符串
                            if( $result){       
                                
                                //检查活动编号正确时再检查现在是否抢票时间
                                 $ctime=date("Y-m-d H:i:s",time()); 
                                //获取抢票时间
                                 $query="select * from event where eventid = '$info[1]' ";
                                 $result= mysql_query($query, $link);
                                 $row = mysql_fetch_row($result);
                                 $ename=$row[1]; 
                                if ($ctime > $row[5] && $ctime < $row[6]) {        //现在为抢票时间段   
                                     //判断该学生是否已经抢了票
                                     $query="select * from  $tab where wid = '$fromUsername' ";
                                     $result= mysql_query($query, $link);
                                     $row = mysql_fetch_row($result);
                                    if ($row)   $contentStr = " 亲，\"$ename\"活动你参加了抢票了，具体结果我们会尽快通知你";
                                    else{
                                        //获取学生姓名
                                        $query="select * from  student where wid = '$fromUsername' ";
                                        $result= mysql_query($query, $link);
                                        $row = mysql_fetch_row($result);
                                        $sname= $row[1];
                                        //将学生信息插入某一活动数据库
                                        $query="insert into $tab(name,wid,sid) values( '$sname','$fromUsername','$row[0]')";
                                        if(mysql_query($query,$link)) $contentStr =" 你已成功参加活动\"$ename\"的抢票环节,抢票结果我们会在抢票结束后尽快通知你，可以通过回复“查票+活动编号”来获取";  
                                        else  $contentStr ="抢票不成功，请重新尝试";
                                    }
                                    
                                }
                                elseif ($ctime< $row[5]) {
                                         $contentStr ="你要抢票的活动为“$row[1]”\n抢票时间段为：\n$row[5]到$row[6]\n现在还没到抢票时间呢";
                                       }         
                                elseif ($ctime> $row[6]) {
                                         $contentStr ="你要抢票的活动为“$row[1]”\n抢票时间段为：\n$row[5]到$row[6]\n抢票已经结束了";
                                       }          
                                 
                                }
                            else{ 
                               $contentStr ="没有$info[1]这个活动哦，检查活动编号是否写错了 ";
                                }  
                           
                       
                           }   
                  else  {   //还没绑定
                     
                      $contentStr ="先绑定才能抢票哦！按照格式“姓名+学号”回复进行账号的绑定（如“张三+201236545152”） ！";
                     
                     }

                       }          
              
               else{   
                        $contentStr = "执行语句发生错误，抢票失败";
                        die('Error: ' . mysql_error());
                        }
              mysql_close($link);
              }
                else{
                    //连接数据库并将联系人插进数据库student
                 $link = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                 if($link){
                        mysql_select_db(SAE_MYSQL_DB,$link);
                        //your code goes here
                        mysql_query("set names utf8");
              
                 //设置一个微信账号只能绑定一个学生id
                 /*一个微信id只能绑定一个账号,下面这句可以做到，但是在绑定多个时不会报错
                 $sql="INSERT INTO student(sid,name,wid) SELECT '$info[1]','$info[0]','$toUsername' FROM DUAL WHERE  '$toUsername'  NOT IN (SELECT wid FROM student)"; 
                 */  
                 $query="select * from student where wid = '$fromUsername' ";
                 $result = mysql_query($query, $link);
                 $row = mysql_fetch_array($result);
                 if ($row[0] > 0) {
                        $contentStr = "你的微信id已经绑定了账号";
                             }
                   
                 elseif(is_numeric($info[1])&&strlen($info[1])==12){  
                        $sql="INSERT INTO student(sid,name,wid) SELECT '$info[1]','$info[0]','$fromUsername' FROM DUAL WHERE  '$fromUsername' NOT IN (SELECT wid FROM student)";
                        if(mysql_query($sql,$link)){
                        //$sql="INSERT INTO student(sid,name,wid) VALUES('$info[1]','$info[0]','$toUsername')";
                        $contentStr = "你的姓名是$info[0],学号是$info[1]，绑定成功";
                         }
                       else{   
                        $contentStr = "执行语句发生错误";
                        die('Error: ' . mysql_error());
                        }
           
                 }
                 else  $contentStr = "绑定不成功，检查姓名或学号是否正确";
               
                    mysql_close($link);
                 }
   
                    
                    
         else{   
                   $contentStr = "连接数据库失败！！";
   
               }
               
             
 }
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
        echo $resultStr;
}

      break;
    //非文本类型时的回复  

    
 //在这里添加自动回复的其他类型

}
              
}
else {
        echo "";
        exit;
        }
    }


}


?> 