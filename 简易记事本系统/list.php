<?php
//强制浏览器不进行缓存
//因为我们把页面的过期时间设置为了过去的时间，这样无用论如何页面都是过期的
header('Expires: Tue, 1 Jun 1980 00:00:00 GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
?>
<html>
<head>
<title>简易记事本（文档一览）</title>
//这里的base标签，保证了表单提交后不会打开新的窗口，而是在我们在index.php中创建的名为down的frame中
<base target="down" />
</head>
<body>
<h1 style="color:white;background-color:#525D76;font-size:22px;">
	简易记事本</h1>
<!-- 	由于input.php负责处理主要的文件操作-->
<form method="POST" action="input.php">
<table border="1">
<tr>
	<th align="left">读入文件名：</th>
	<td>
<!-- 	创建下拉框选择要读取的文件 -->
	<select name="doc">
		<?php
		require_once 'common.php';
		//创建一个dir对象
		$d = dir(ROOT);
		//使用循环的方式遍历该目录下的所有目录和文件
		while($path = $d->read()){ 
			$path = c($path);
			if($path != '.' && $path != '..'){
				print('<option value="'.$path.'">'.$path.'</option>');
			}
		}
		$d->close();
		?>
		</select>
	</td>
	<td>
		<input type="submit" name="proc" value="读入" />
		<input type="submit" name="proc" value="删除" />
	</td>
</tr>
<tr>
	<th align="right">新作成文件：</th>
	<td><input type="text" name="newDoc" size="20" /></td>
	<td><input type="submit" name="proc" value="作成" /></td>
</tr>
</table>
</form>
</body>
</html>
