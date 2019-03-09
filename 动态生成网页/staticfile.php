<?php
ob_start();
$qstring = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING']:'';
$str=$_SERVER['SCRIPT_FILENAME'];
$path=substr($str,0,strpos($str,'staticfile'));
define('HTML_FILE', $path.'/post/'.$qstring);
if (file_exists(HTML_FILE)){
    $lcft = filemtime(HTML_FILE);
    if (($lcft + 3600) > time()) //判断上次生成HTML文件是否超过1小时，若没有才直接输出文件内容
    {
        echo(file_get_contents(HTML_FILE));
        exit(0);
    }
}
$htmlstr="<html>
<head>
<title>动态生成静态HTML文件</title>
</head>
<body>
动态生成静态HTML文件。<br/>
生成时间：".date('Y-m-d H:i:s')."
</body>
</html>";
echo $htmlstr;
$buffer = ob_get_flush();
$fp = fopen(HTML_FILE, 'w');
if ($fp){
    fwrite($fp, $buffer);
    fclose($fp);
}
?>
