<?php
require_once 'common.php';
$tmp = r($_POST['doc']);
if(isValid($tmp)){
	$fl = gzopen($tmp, 'w9');
	//向文件中写入内容，然后关闭文件
	gzwrite($fl, $_POST['memo']);
	gzclose($fl);
	//定位到index.php页面
	header('Location: index.php');
}
