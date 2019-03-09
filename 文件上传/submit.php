<html>
<head>
<title>文件上传</title>
</head>
<body>
<h1 style="color:red;background-color:#000000;font-size:22px;">
	文件上传</h1>
<!-- 	//下面的表单中的input指定了type=file，因此需要将此处的enctype设置为multipart/form-data -->
<form method="post" action="upload.php" enctype="multipart/form-data">
<!-- 设定最大文件限制，100万字节，大约为7.6MB，在真正的项目中，如果想设置上传文件限制，应该在php.ini的upload_max_filesize处进行设置 -->
	<input type="hidden" name="max_file_size" value="1000000" />
	<table border="0">
	<tr>
		<th align="right" valign="top">文件上传：</th>
		<td>
<!-- 		//名字为数组形式，这样传上去的文件在表单中的名字依次就为fl[0~2] -->
			<input name="fl[]" type="file" size="60"><br />
			<input name="fl[]" type="file" size="60"><br />
			<input name="fl[]" type="file" size="60"><br />
			
<!-- 			//这一行保证了服务器上原先存在的同名文件不会被覆盖 -->
			（不可覆盖）<input type="checkbox" name="forbid" value="true" checked />
			
			<input type="submit" value="上传" />
		</td>
	</tr>
	</table>
</form>
</body>
</html>
