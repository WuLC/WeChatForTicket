<?php
//define your token
define("TOKEN", "XXXX");       // 将XXXX改成自己的TOKEN
define('APP_ID', 'XXXX');      // 将XXXX改成自己的APPID
define('APP_SECRET', 'XXXX');  //将XXXX改成自己的APPSECRET

$wechatObj = new wechatCallbackapiTest(APP_ID,APP_SECRET);
$wechatObj->Run();

class wechatCallbackapiTest
{
    private $fromUsername;
    private $toUsername;
    private $times;
    private $keyword;
    private $app_id;
    private $app_secret;
    
    
    public function __construct($appid,$appsecret)
    {
        # code...
        $this->app_id = $appid;
        $this->app_secret = $appsecret;
    }
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }
    /**
     * 运行程序
     * @param string $value [description]
     */
    public function Run()
    {
        $this->responseMsg();
        //   $arr[]= "您好，这是自动回复，我现在不在，有事请留言，我会尽快回复你的[愉快]";  //输入任意字符时的回复
        // echo $this->make_xml("text",$arr);
    }
    public function responseMsg()
    {   
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//返回回复数据
        if (!empty($postStr)){
                $access_token = $this->get_access_token();//获取access_token
                $this->createmenu($access_token);//创建菜单
                //$this->delmenu($access_token);//删除菜单
                $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $this->fromUsername = $postObj->FromUserName;
                $fromUsername = $postObj->FromUserName;//发送消息方ID
                $this->toUsername = $postObj->ToUserName;//接收消息方ID
                $toUsername = $postObj->ToUserName;
                $this->keyword = trim($postObj->Content);//用户发送的消息
                $keyword=trim($postObj->Content);
                $this->times = time();//发送时间
                $MsgType = $postObj->MsgType;//消息类型
                
                if($MsgType=='event'){
                    $MsgEvent = $postObj->Event;//获取事件类型
                    if ($MsgEvent=='subscribe') {//订阅事件
                        $arr[] = "你好，我是xxx，现在我们是好友咯![愉快][玫瑰]";  //关注时自动回复
                        echo $this->make_xml("text",$arr);
                        exit;
                    }
                    elseif ($MsgEvent=='CLICK') {//点击事件
                        $EventKey = $postObj->EventKey;//菜单的自定义的key值，可以根据此值判断用户点击了什么内容，从而推送不同信息
                        
                       
      if ( $EventKey == "0")       
                            {
                        
                         //列出现有的活动
                  $ctime=date("Y-m-d H:i:s",time());   //获取当前时间
            
                     //连接数据库
                $link = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                if($link){
                        mysql_select_db(SAE_MYSQL_DB,$link);
                        //your code goes here
                        mysql_query("set names utf8");
                  
                 $query="select * from  event where  eqtime > '$ctime' ";
                 $result = mysql_query($query, $link);
                 $num = mysql_num_rows($result);          //统计近期可抢票的活动数  
                 $arrt="近期可抢票的活动共有 $num 个,可通过“我要抢票”进行抢票！"; 
                 while( $row = mysql_fetch_row($result) ){     
                 $arrt="$arrt"."\n\n\n活动名称:$row[0]\n活动开始时间:$row[1]\n活动举办地点:$row[2]\n抢票时间段:\n$row[3]到\n$row[4]\n详细信息访问:$row[5]";
                            }
                    $arr[]=$arrt;
                       } 
               else{   
                        $arr[] = "执行语句发生错误，抢票失败";
                        die('Error: ' . mysql_error());
                        }
              mysql_close($link);
                        
                    }
          elseif ( $EventKey == "1")   
                {
              
                $link = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                  if($link){
                        mysql_select_db(SAE_MYSQL_DB,$link);
                        //your code goes here
                        mysql_query("set names utf8");
                      //检查账号是否已经绑定了，还没绑定不准抢票
                       $query="select * from student where wid = '$fromUsername' ";
                       $result= mysql_query($query, $link);
                       $row = mysql_fetch_array($result);
                       if ($row[0] > 0) {       //微信号已经绑定了
                             //检查微信绑定后再检查是否有活动可抢
                             
                             $query="select * from event";
                             $result= mysql_query($query, $link);  //没有时$result为空字符串
                            if( $result ) {       
                                
                                //检查活动编号正确时再检查现在是否抢票时间
                                 $ctime=date("Y-m-d H:i:s",time()); 
                                //获取抢票时间
                                //$query="select * from event where eventid = '$info[1]' ";
                                //$result= mysql_query($query, $link);
                                 $row = mysql_fetch_row($result);
                                 $ename=$row[0]; 
                                if ($ctime > $row[3] && $ctime < $row[4]) {        //现在为抢票时间段   
                                     //判断该学生是否已经抢了票
                                     $query="select * from  evestu where wid = '$fromUsername' ";
                                     $result= mysql_query($query, $link);
                                     $row = mysql_fetch_row($result);
                                    if ($row)   $arr[] = " 亲，\"$ename\"活动你已经参加抢票了，抢票结果可以通过“查票”来获取";
                                    else{
                                        //获取学生姓名
                                        $query="select * from  student where wid = '$fromUsername' ";
                                        $result= mysql_query($query, $link);
                                        $row = mysql_fetch_row($result);
                                        $sname= $row[1];
                                        //将学生信息插入某一活动数据库
                                        $query="insert into evestu(name,wid,sid) values( '$sname','$fromUsername','$row[0]')";
                                        if(mysql_query($query,$link))  $arr[] =" 你已成功参加活动\"$ename\"的抢票环节,抢票结果可以通过“查票”来获取";  
                                        else  $arr[] ="抢票不成功，请重新尝试";
                                    }
                                    
                                }
                                elseif ($ctime< $row[3]) {
                                         $arr[] ="你要抢票的活动为“$row[0]”\n抢票时间段为：\n$row[3]到$row[4]\n现在还没到抢票时间呢";
                                       }         
                                elseif ($ctime> $row[4]) {
                                         $arr[] = "你要抢票的活动为“$row[0]”\n抢票时间段为：\n$row[3]到$row[4]\n抢票已经结束了";
                                       }          
                                 
                                }
                            else{ 
                               $arr[] ="当前没有可以抢票的活动哦！";
                                }  
                           
                       
                           }   
                  else  {   //还没绑定
                     
                      $arr[] ="先绑定才能抢票哦！按照格式“姓名+学号”回复进行账号的绑定【如“张三+201236545152”】 ！";
                     
                     }
                       }                  
               else{   
                       $arr[] = "执行语句发生错误，抢票失败";
                        die('Error: ' . mysql_error());
                        }
              mysql_close($link);
              
              
                        }
                       elseif ( $EventKey == "2") {
                        
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
                        
                     // if( $result){

                         //获取活动名称、地点、时间
                             $query="select * from event ";
                             $result= mysql_query($query, $link);
                             $row = mysql_fetch_row($result);
                             $ename=$row[0];
                             $etime=$row[1];
                             $eaddr=$row[2];
                         //查询抢票是否成功
                             $query="select * from evestu where wid = '$fromUsername'";
                             $result= mysql_query($query, $link);
                             $row = mysql_fetch_row($result);
                             if ($row){    
                                 if ($row[3]=='1')         $arr[]="恭喜你已成功抢到活动\"$ename\"的入场券，请于活动开始前1小时凭微信和学生证到活动现场领票。\n\n活动举办的时间：$etime \n\n地点：$eaddr";
                                elseif($row[3]=='0')        $arr[]="很遗憾告诉你，你没有抢到活动\"$ename\"的入场券，关注我们下一次的抢票活动吧";                                
                                else    $arr[]="抢票结果还没产生，请耐心等候";
                                }
                               else   $arr[]="你还没参加活动\"$ename\"的抢票，请通过“我要抢票”进行抢票";      

                           }        
                       else   $arr[] ="还没绑定，请照格式“姓名+学号”回复进行账号的绑定【如“张三+201236545152”】";//还没绑定
                     }
        else  $contentStr = "连接数据库不成功，查票失败";
           mysql_close($link);  
                        
                        
                        
                        }
                        
                        
                        elseif ( $EventKey == "3")   $arr[]="请输入“姓名+学号”进行账号的绑定【如“张三+201236545152”】！";
                        
                        else  $arr[]="default";
                        
                        echo $this->make_xml("text",$arr);
                        exit;
                    }
                   }
        elseif( $MsgType == 'text') {
               //$arr[]= $keyword;
               //把学号和姓名拆开,检查中英两个
                $info=explode("+",$keyword);
                if(empty($info[1]))   $info=explode("+",$keyword);     
                if(empty($info[1])){
                    //回复其他关键字时的回复
               $arr[]= "欢迎关注华工青年，\n请输入“姓名+学号”进行账号的绑定\n（如“张三+201236545152”）!";
                }
             
             else{
                    //连接数据库并将联系人插进数据库student
                 $link = mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
                 if($link){
                        mysql_select_db(SAE_MYSQL_DB,$link);
                        //your code goes here
                        mysql_query("set names utf8");
              
                 $query="select * from student where wid = '$fromUsername' ";
                 $result = mysql_query($query, $link);
                 $row = mysql_fetch_array($result);
                 if ($row[0] > 0) {
                        $arr[]  = "你的微信id已经绑定了账号";
                             }
                   
                 elseif(is_numeric($info[1])&&strlen($info[1])==12){  
                        $sql="INSERT INTO student(sid,name,wid) SELECT '$info[1]','$info[0]','$fromUsername' FROM DUAL WHERE  '$fromUsername' NOT IN (SELECT wid FROM student)";
                        if(mysql_query($sql,$link)){
                        //$sql="INSERT INTO student(sid,name,wid) VALUES('$info[1]','$info[0]','$toUsername')";
                        $arr[] = "你的姓名是$info[0],学号是$info[1]，绑定成功";
                         }
                       else{   
                        $arr[]  = "执行语句发生错误";
                        die('Error: ' . mysql_error());
                        }
           
                 }
                 else  $arr[]  = "绑定不成功，检查姓名或学号是否正确";
               
                    mysql_close($link);
                 }
   
                    
                    
         else{   
                   $arr[]  = "连接数据库失败！！";
   
               }
               
             
 }

               echo $this->make_xml("text",$arr);
                exit;
            }
        }else {
            echo "this a file for weixin API!";
            exit;
        }
    }
    /**
     * 获取access_token
     */
    private function get_access_token()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->app_id."&secret=".$this->app_secret;
        $data = json_decode(file_get_contents($url),true);
        if($data['access_token']){
            return $data['access_token'];
        }else{
            return "获取access_token错误";
        }
    }
    /**
     * 创建菜单
     * @param $access_token 已获取的ACCESS_TOKEN
     */
    public function createmenu($access_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$access_token;
        $arr = array( 
            'button' =>array(
                array(
                    'name'=>urlencode("生活查询"),
                    'sub_button'=>array(
                        array(
                            'name'=>urlencode("天气查询"),
                            'type'=>'click',
                            'key'=>'VCX_WEATHER'
                        ),
                        
                        array(
                            'name'=>urlencode("性别查询"),
                            'type'=>'click',
                            'key'=>'VCX_WEATHER'
                        ),
                        
                        array(
                            'name'=>urlencode("身份证查询"),
                            'type'=>'click',
                            'key'=>'VCX_IDENT'
                        )    
                    )
                ),

                array(
                    'name'=>urlencode("轻松娱乐"),
                    'sub_button'=>array(
                        array(
                            'name'=>urlencode("刮刮乐"),
                            'type'=>'click',
                            'key'=>'VCX_GUAHAPPY'
                        ),
                        array(
                            'name'=>urlencode("啦啦啦"),
                            'type'=>'click',
                            'key'=>'VCX_GUAHAPPY'
                        ),
                        array(
                            'name'=>urlencode("幸运大转盘"),
                            'type'=>'click',
                            'key'=>'VCX_LUCKPAN'
                        )
                    )
                ),
                array(
                    'name'=>urlencode("活动抢票"),
                    'sub_button'=>array(
                        array(
                            'name'=>urlencode("近期活动"),
                            'type'=>'click',
                            'key'=>'活动'
                        ),
                        array(
                            'name'=>urlencode("我要抢票"),
                            'type'=>'click',
                            'key'=>'抢票'
                        ),
                        array(
                            'name'=>urlencode("查票"),
                            'type'=>'click',
                            'key'=>'查票'
                        ),
                        array(
                            'name'=>urlencode("绑定"),
                            'type'=>'click',
                            'key'=>'绑定'
                        ),
                        array(
                            'name'=>urlencode("解除绑定"),
                            'type'=>'click',
                            'key'=>'解绑'
                        )
                        
                    )
                )
       
            )
        );
        $jsondata = urldecode(json_encode($arr));
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$jsondata);
        curl_exec($ch);
        curl_close($ch);
    }
    /**
     * 查询菜单
     * @param $access_token 已获取的ACCESS_TOKEN
     */
    
    private function getmenu($access_token)
    {
        # code...
        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=".$access_token;
        $data = file_get_contents($url);
        return $data;
    }
    /**
     * 删除菜单
     * @param $access_token 已获取的ACCESS_TOKEN
     */
    
    private function delmenu($access_token)
    {
        # code...
        $url = "https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=".$access_token;
        $data = json_decode(file_get_contents($url),true);
        if ($data['errcode']==0) {
            # code...
            return true;
        }else{
            return false;
        }
    }
        
    /**
     *@param type: text 文本类型, news 图文类型
     *@param value_arr array(内容),array(ID)
     *@param o_arr array(array(标题,介绍,图片,超链接),...小于10条),array(条数,ID)
     */
    
    private function make_xml($type,$value_arr,$o_arr=array(0)){
        //=================xml header============
        $con="<xml>
                    <ToUserName><![CDATA[{$this->fromUsername}]]></ToUserName>
                    <FromUserName><![CDATA[{$this->toUsername}]]></FromUserName>
                    <CreateTime>{$this->times}</CreateTime>
                    <MsgType><![CDATA[{$type}]]></MsgType>";
                    
          //=================type content============
        switch($type){
          
            case "text" : 
                $con.="<Content><![CDATA[{$value_arr[0]}]]></Content>
                    <FuncFlag>{$o_arr}</FuncFlag>";  
            break;
            
            case "news" : 
                $con.="<ArticleCount>{$o_arr[0]}</ArticleCount>
                     <Articles>";
                foreach($value_arr as $id=>$v){
                    if($id>=$o_arr[0]) break; else null; //判断数组数不超过设置数
                    $con.="<item>
                         <Title><![CDATA[{$v[0]}]]></Title> 
                         <Description><![CDATA[{$v[1]}]]></Description>
                         <PicUrl><![CDATA[{$v[2]}]]></PicUrl>
                         <Url><![CDATA[{$v[3]}]]></Url>
                         </item>";
                }
                $con.="</Articles>
                     <FuncFlag>{$o_arr[1]}</FuncFlag>";  
            break;
            
        } //end switch
          
         //=================end return============
        $con.="</xml>";
         
        return $con;
    }
 
 
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];    
                
        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
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