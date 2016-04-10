<?php
header("Content-Type:text/html;charset=utf-8");
$activityname=$_POST['activityname'];
$activitytime=$_POST['activitytime'];
$address=$_POST['address'];
$starttime=$_POST['starttime'];
$endtime=$_POST['endtime'];
$information=$_POST['information'];


 $link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
        if($link){
               mysql_select_db(SAE_MYSQL_DB,$link);
                        
               mysql_query("set names utf8");
               //清除表的记录
              $query="TRUNCATE TABLE evestu ";
              $result = mysql_query($query, $link);
            if  ($result) {
              $query="TRUNCATE TABLE  event ";
              $result = mysql_query($query, $link);
                if  ($result) {
                    $query=" insert into event values('$activityname','$activitytime','$address','$starttime','$endtime','$information') ";
                    $result = mysql_query($query, $link);
                    if($result){
                    echo"请核对录入的活动信息：<br>活动名称：$activityname<br>活动开始时间：$activitytime<br>活动举办地点：$address<br>开始抢票时间：$starttime<br>抢票结束时间：$endtime<br>活动具体信息：$information<br>
                     已成功录入数据库，若信息录错可回到前一页面重新录入";                  
                    }
                    else echo "录入数据库不成功";
                
                
                }
                else echo "清除event不成功，请联系开发者！！";
            
            
            }
            else echo"清除evestu不成功，请联系开发者！！";
         }

else {
		 
		 echo"连接数据库不成功！";
         exit;
		 }
			  mysql_close($link);



    
?>