<?php
/*
session_start();
if(!isset($_SESSION['username']))
{
	echo '你无权访问该文件';
}
else
{
*/
echo'

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>华工团委微信后台</title>





<!-- 主脚本文件 --> 
<!--时间文件-->
<link rel="stylesheet" type="text/css" href="jquery.datetimepicker.css"/>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<style type="text/css"> 

</style>

<!-- Your Custom Stylesheet --> 

<link rel="stylesheet" href="css/custom.css" type="text/css" />


<!--swfobject - needed only if you require <video> tag support for older browsers -->

<script type="text/javascript" SRC="js/swfobject.js"></script>
<!-- jQuery with plugins -->
<script type="text/javascript" SRC="js/jquery-1.4.2.min.js"></script>
<!-- Could be loaded remotely from Google CDN : <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> -->
<script type="text/javascript" SRC="js/jquery.ui.core.min.js"></script>
<script type="text/javascript" SRC="js/jquery.ui.widget.min.js"></script>
<script type="text/javascript" SRC="js/jquery.ui.tabs.min.js"></script>
<!-- jQuery tooltips -->
<script type="text/javascript" SRC="js/jquery.tipTip.min.js"></script>
<!-- Superfish navigation -->
<script type="text/javascript" SRC="js/jquery.superfish.min.js"></script>
<script type="text/javascript" SRC="js/jquery.supersubs.min.js"></script>
<!-- jQuery popup box -->
<script type="text/javascript" SRC="js/jquery.nyroModal.pack.js"></script>
<!-- jQuery form validation -->
<script type="text/javascript" SRC="js/jquery.validate_pack.js"></script>


<!--时间文件-->
<script src="jquery.js"></script>
<script src="jquery.datetimepicker.js"></script>
<!-- Internet Explorer Fixes --> 
<!--[if IE]>
<link rel="stylesheet" type="text/css" media="all" href="css/ie.css"/>
<script src="js/html5.js"></script>
<![endif]-->
<!--Upgrade MSIE5.5-7 to be compatible with MSIE8: http://ie7-js.googlecode.com/svn/version/2.1(beta3)/IE8.js -->
<!--[if lt IE 8]>
<script src="js/IE8.js"></script>
<![endif]-->
<script type="text/javascript">
$(document).ready(function(){
	
	/* setup navigation, content boxes, etc... */
	Administry.setup();
	
	/* progress bar animations - setting initial values */
	Administry.progress("#progress1", 1, 6);
	
	// validate form on keyup and submit
	var validator = $("#sampleform").validate({
		rules: {
			activityname: "required",
			host: "required",
			starttime: {
				required: true,
				minlength: 2
			},
			endtime: {
				required: true,
				minlength: 2
			},
			
			dateformat: "required",
			terms: "required"
		},
		messages: {
			activityname: "请输入活动名称",
			host: "请输入主办方",
			starttime: {
				required: "请输入开始时间",
				
			},
			endtime: {
				required: "请输入结束时间",
				
			},
			
			
			
			
		},
		// the errorPlacement has to take the layout into account
		errorPlacement: function(error, element) {
			error.insertAfter(element.parent().find(\'label:first\'));
		},
		// specifying a submitHandler prevents the default submit, good for the demo
		submitHandler: function() {
			alert("Data submitted!");
		},
		// set new class to error-labels to indicate valid fields
		success: function(label) {
			// set &nbsp; as text for IE
			label.html("&nbsp;").addClass("ok");
		}
	});
	
	$("#username").focus(function() {
		var activityname = $("#activityname").val();
		var host = $("#host").val();
		if(activityname && host && !this.value) {
			this.value = activityname + "." + host;
		}
	});

});
	

});
</script>
</head>
<body>
	<!-- 头部 -->
	<header id="top">
		<div class="wrapper">
			<!--在这里文字或者是图像代替-->
			<div id="title">
			<!--img SRC="img/logo.png" alt="管理员" /-->
<span>华工团委微信后台</span> 
			</div>

			<!-- 导航栏尾部 -->
			<!-- 主导航栏 -->
			<nav id="menu">
				<ul class="sf-menu">
					
					<li class="current">
						<a HREF="#">活动</a>
						<ul>
							<li>
								<a HREF="activity.php">添加活动</a>
							</li>
						
						</ul>
					</li>
						
				</ul>
			</nav>
		
			
		</div>
	</header>
	<!-- header的尾部 -->
	<!-- Page 的标题 -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>活动</h1>
			<!-- 快速搜素栏，现在还没有开发出功能，以后再开发 -->
			
		</div>
	</div>
	<!--  Page title尾部 -->
	
	<!-- Page 内容 -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper">
				<!-- 左边的栏目部分  -->
				<section class="column width6 first">					

					<h3>添加活动信息</h3>
					<div class="box box-info">带星号区域必填</div>
					
					<form id="sampleform" name="sampleform" method="post" action="newevent.php" enctype="multipart/form-data">

						<fieldset>
							<legend>基本信息</legend>

							<p>
								<label class="required" for="activityname1">活动名称:</label><br/>
								<input type="text" id="activityname1" class="half" value="" name="activityname"/>
							</p>
                             
                            <p>
						   <label class="required" for="activitytime1">活动开始时间</label><br/>
                              <input type="text" id="activitytime"class="half" value="" name="activitytime"//>
						   </p>

						    <p>
						    <label class="required" for="address1">活动举办地点</label><br/>
                           <input type="text" id="address"class="half" value="" name="address"/>
						   </p>
							<p>
								<label class="required" for="starttime1">抢票开始时间</label><br/>
                           <input type="text" id="starttime"class="half" value="" name="starttime"//>
						   </p>
						   <p>
								<label class="required" for="endtime1">抢票结束时间</label><br/>
                           <input type="text" id="endtime"class="half" value="" name="endtime"/>
						   </p>
                           
                           <p>
							 <label class="required" for="endtime1">详细信息url</label><br/>
                           <input type="text" id="endtime"class="half" value="" name="information"/>
						   </p>
						  
                         
							
</fieldset>

<p class=""><input type="submit" class="btn btn-red" value="提交"/> </p>
						
</form>
				
				</section>
				<!-- 左边的尾部 -->
				
				<!-- 右边部分 -->
				
				<!-- 右边部分暂时没有设置 -->
				
		</div>
		<!--  Wrapper结束部分 -->
	</div>
	<!-- Page 结束部分 -->
	
	<footer id="bottom">
		<div class="wrapper">
			<nav>
			
				<!--底部导航栏可以动态添加-->
			</nav>
			<p>Copyright &copy; 2014 华工创维工作室</p>
		</div>
	</footer>



<!-- 用户接口的js接口-->
<script type="text/javascript" SRC="js/administry.js">
</script>
';
echo'


<style type="text/css">
input.file{
    vertical-align:middle;
    position:relative;
    left:-218px;
    filter:alpha(opacity=0);
    opacity:0;
	z-index:1;
	*width:223px;
}


form input.viewfile {
	z-index:99;
	border:1px solid #ccc;
	padding:2px;
	width:150px;
	vertical-align:middle;
	color:#999;

	}
	form input.viewfile1 {
	z-index:99;
	border:1px solid #ccc;
	padding:2px;
	width:150px;
	vertical-align:middle;
	color:#999;
}
form input.viewfile2 {
	z-index:99;
	border:1px solid #ccc;
	padding:2px;
	width:150px;
	vertical-align:middle;
	color:#999;
}
form input.viewfile3 {
	z-index:99;
	border:1px solid #ccc;
	padding:2px;
	width:150px;
	vertical-align:middle;
	color:#999;
}
form p span {
	float:left;
}
form label.bottom {
	border:1px solid #38597a;
	background:#4e7ba9;
	color:#fff;
	height:19px;
	line-height:19px;
	display:block;
	width:60px;
	text-align:center;
	cursor:pointer;
	float:left;
	position:relative;
	*top:1px;
}


form input.submit {
	border:0;
	background:#380;
	width:70px;
	height:22px;
	line-height:22px;
	color:#fff;
	cursor:pointer;
}

p.clear {
	clear:left;
	margin-top:12px;
}

</style>
<script>
';
echo '

var logic = function( currentDateTime ){
	if( currentDateTime.getDay()==6 ){
		this.setOptions({
			minTime:\'11:00\'
		});
	}else
		this.setOptions({
			minTime:\'8:00\'
		});
};
$(\'#starttime\').datetimepicker({
	onChangeDateTime:logic,
	onShow:logic
});
$(\'#endtime\').datetimepicker({
	onChangeDateTime:logic,
	onShow:logic
});
$(\'#activitytime\').datetimepicker({
	onChangeDateTime:logic,
	onShow:logic
});


</script>

</body>
</html>
';

?>

