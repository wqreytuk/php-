<html>
<head>
<title>文档公开</title>
</head>
<body>
<h1 style="color:white;background-color:#525D76;font-size:22px;">
	文档公开</h1>
<table border="0">
<tr><td>
<?php
error_reporting(0);
require_once 'common.php';
if(isset($_POST['dir'])){
	$current = $_POST['dir'];
	if($current != ROOT){ ?>
		<div align="right">
		<form name="fm" method="POST" action="index.php">
			<input type="hidden" name="dir"
			//dirname会返回字符串中的目录部分，比如字符串为.aa/bb/cc/1..，那么dirname的返回值就是.aa/bb/cc
			//如果是./bb/cc，就会返回.bb，其实可以直接理解为返回参数的父目录，或者说参数所在目录的名称
				value="<?php $ttt = dirname($current); print(dirname($current)); ?>" />
<!-- 				点击表单 ,fm为表单的名称，表单的隐藏框dir的值就是当前目录的值-->
			[<a href="JavaScript:document.fm.submit();">上一级目录</a>]
		</form>
		</div>
<?php
	}
}else{
	$current = ROOT;
}
$temp = isValid($current);
//用于防治目录穿越，判断目录是否是程序规定的目录或者其子目录，
//下面还有一个判断代码就是保证目录中不存在..和.
//如果没有了这两个判断的话，那这个php程序就存在任意代码读取漏洞
//if(!$temp){exit(1);}
?>
</td></tr>
<tr><td>
<table border="1">
<tr>
	<th>文件名</th><th>类型</th><th>文件大小</th>
	<th>最新访问时间</th><th>最终更新日</th>
</tr>
<?php
//返回一个directory类的实例
/**
 * 利用dir便利目录，使用read方法结合while循环
<?php
$d = dir(".");
echo "Handle: " . $d->handle . "<br />";
echo "Path: " . $d->path . "<br />";
while (false !== ($entry = $d->read())) {
   echo $entry."<br />";
}
$d->close();
?>
 */
$d = dir($current);
while($entry = $d->read()){
    //计算当期目录下的子项数量
    //在下面和fm拼接作为表单的name属性值
	$cnt++;
	if( true /*$entry != '.' && $entry != '..'*/){
		$tmp = $current.'/'.$entry;
		/**pathinfo方法的例子
		 * <?php
$path_parts = pathinfo('1.php');

echo $path_parts['dirname'], "<br />";
echo $path_parts['basename'], "<br />";
echo $path_parts['extension'], "<br />";
echo $path_parts['filename'], "<br />";  
?>

结果： 
    .
    1.php
    php
    1
		 */
		$info = pathinfo(c($tmp));
		if(is_dir($tmp)){
?>
		<form name="fm<?php print($cnt);?>" method="POST" action="index.php">
		<tr>
		<td>
			<input type="hidden" name="dir"
				value="<?php print($current.'/'.$entry); ?>" />
			<a href="JavaScript:document.fm<?php print($cnt);?>.submit();">
				<?php print($info['basename']); ?></a>
		</td>
		<td>目录</td>
		<td><br /></td>
<?php }else{ ?>		<form name="fm<?php print($cnt);?>" method="POST" action="disp.php">
		<tr>
		<td>
			<input type="hidden" name="dir"
				value="<?php print($current.'/'.$entry); ?>" />
			<a href="JavaScript:document.fm<?php print($cnt);?>.submit();">
				<?php print(str_replace('.'.$info['extension'], 
					'', $info['basename']));?>
			</a>
		</td>
		<td><?php print(strtoupper($info['extension']));?>文件</td>
		<td align="right"><?php print(round(filesize($tmp)/1024));?>KB</td>
<?php
		}
		print('<td>'.date('Y/m/d H:i:s',fileatime($tmp)).'</td>');
		print('<td>'.date('Y/m/d H:i:s',filemtime($tmp)).'</td>');
		print('</tr></form>');
	}
}
$d->close();
?>
</table>
</td></tr></table>
</body>
</html>
