<?php
header("Content-Type:text/html;charset=utf-8");
$pnumber=$_POST['pnumber'];




if ($pnumber=='')
{
	echo "抢票数目输入不能为空,请重新输入";
	exit;
}

 $link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
        if($link){
               mysql_select_db(SAE_MYSQL_DB,$link);
                        
               mysql_query("set names utf8");
            
            //先清空flag
              $query="update  evestu set flag='' ";
              $result = mysql_query($query, $link);
             if ($result) {                 
              $query="select *  from   evestu  order by rand() limit 0,$pnumber ";
              $result = mysql_query($query, $link);
                if (!$result){
				 echo"该活动不存在！";
                    exit;
				 }
            else  echo "成功抢到票的人有（可通过刷新重新生成抢票结果）:<br>" ;
                       while( $row = mysql_fetch_row($result) ){                        
                       
                        echo "$row[0]    $row[2]<br>"; 
                        //将flag置为1
                        $sql="update evestu  set flag='1' where name = '$row[0]'";
                        if(mysql_query($sql, $link)) ; 
                        else echo"flag 置位不成功 <br>";
                      }
            //其余没抢到票的人flag置为0
                 $query="select * from evestu ";
                 $result = mysql_query($query, $link);
                 while( $row = mysql_fetch_row($result) ){
                     if($row[3] != '1') {
                     $sql="update evestu  set flag='0'  where name = '$row[0]'";
                     if(mysql_query($sql, $link)) ; 
                     else echo"flag 置位不成功 <br>";   
                     }              
		}
                 }
            
             else echo"flag清空不成功";
    }
   
else {
		 
		 echo"连接数据库不成功！";
         exit;
		 }
			  mysql_close($link);

?>