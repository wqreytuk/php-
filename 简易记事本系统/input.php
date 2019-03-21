<html>
<head>
<title>简易记事本（信息输入）</title>
<base target="_parent" />
</head>
<body>
<!-- 提交给save来进行保存文件的操作 -->
<form method="POST" action="save.php">
<?php
require_once 'common.php';
switch($_POST['proc']){
	case '读入' :
	    //拼接路径，读取文件
		$tmp = r(ROOT.$_POST['doc']);
		if(isValid($tmp)){
		    //在textarea标签中存放文件内容
			print('<textarea name="memo" cols="80" rows="20">');
			//gzopen() can be used to read a file which is not in gzip format; in this case gzread() will directly read from the file without decompression.
			$fl = gzopen($tmp, 'r');
			//只要还没有读取到文件结尾，就一直打印输出
			//gzgets的第二个参数规定一次读取多少个字节，读完第4999字节后停止
			while(!gzeof($fl)){print(gzgets($fl, 5000));}
			//读取完毕，关闭文件
			gzclose($fl);
			print('</textarea>');
		}else{
			exit(1);
		}
		break;
	case '删除' :
		$tmp = r(ROOT.$_POST['doc']);
		//删除文件
		if(isValid($tmp)){unlink($tmp);} else {exit(1);}
		print('<script type="text/javascript">');
		//parent.location.href表示iframe的上一层级别
		//list.php是嵌套在index.php中的一个frame
		//使用原来的frame而不是再创建一个frame
		print('parent.location.href = "index.php";');
		print('</script>');
		break;
	case '作成' :
		$tmp = r(ROOT.$_POST['newDoc']);
		//如果文件不存在，则使用a9模式，a表示追加模式，9表示最大压缩率
		if(!file_exists($tmp)){
		    //此处创建了一个空文件
			$fl = gzopen($tmp, 'a9');
			gzclose($fl);
			//生成一个textarea供用户进行输入
			print('<textarea name="memo" cols="80" rows="20">');
			print('</textarea>');
		}else{
		    //给div标签设置一个样式表
			print('<div style="color:#FF0000">');
			print('！！警告！！同名的文件已经存在</div>');
			exit();
		}
		break;
}
?>
<br />
<!-- 隐藏标签，提交后doc值为刚才创建的文件名 -->
<input type="hidden" name="doc"
	value="<?php print(c($tmp)); ?>" />
<input type="submit" value="保存" />
</form>
</body>
</html>
