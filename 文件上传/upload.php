<html>
<head>
<title>上传结果</title>
</head>
<body>
<h1 style="color:red;background-color:#000000;font-size:22px;">
	上传结果</h1>
<table border="1" width="350">
<tr>
<!-- th标签定义表头，字体以粗体显示 -->
<th>文件名</th><th>大小</th><th>MIME类型</th>
</tr>
<?php
error_reporting(0);
mkdir('./doc/');
$path = './doc/';
$num = 0;

for($i=0; $i<sizeof($_FILES['fl']['name']); $i++){
    //对文件进行转码，从SJIS转成UTF-8
	$name = mb_convert_encoding($_FILES['fl']['name'][$i], 'SJIS', 'UTF-8');
	if($_FILES['fl']['name'][$i] == ''){continue;}
	if(file_exists($path.$name) == TRUE && $_POST['forbid'] == 'true'){
		$num++;
	}
	 
	elseif(!is_uploaded_file($_FILES['fl']['tmp_name'][$i])){
		$num++;
	}else{
?>
		<tr>
			<td align="right"><?php print($_FILES['fl']['name'][$i]); ?></td>
			<td align="right"><?php print($_FILES['fl']['size'][$i]); ?>Byte</td>
			<td align="right"><?php print($_FILES['fl']['type'][$i]); ?></td>
		</tr>
<?php
		move_uploaded_file($_FILES['fl']['tmp_name'][$i], $path.$name);
	}
}
if($num > 0){
	print('<div style="color:red">'.$num.'件上传失败。</div>');
}
?>
</table>
</body>
</html>
