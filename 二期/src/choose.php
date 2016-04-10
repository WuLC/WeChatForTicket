
<html>
<meta http-equiv="Content-Type" content="text/html;charset=utf8" />
    
    
<?php
$link=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
        if($link){
               mysql_select_db(SAE_MYSQL_DB,$link);       
               mysql_query("set names utf8");
               $query="select * from event";
               $result= mysql_query($query, $link);
               $row = mysql_fetch_row($result);
            echo "<center><h7><b>自动生成选票结果</b></h7></br>当前操作的活动为【$row[0]】</center>";
           
           }
    else  echo"连接数据库不成功";

    ?>

    
  <form action="result.php" method="post">
    <center>
        
    票&nbsp;数&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="pnumber"></br>
<input type="submit"></br>
</center>
</form>
</html>