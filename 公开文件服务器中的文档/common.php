<?php
define('ROOT', './doc');

function c($str){ return mb_convert_encoding($str, 'UTF-8', 'SJIS'); }
function r($str){ return mb_convert_encoding($str, 'SJIS', 'UTF-8'); }
function isValid($path) {
    //realpath方法返回绝对路径（物理磁盘上的绝对路径）
	$root = realpath(ROOT);
	//mb_strlen获取字符串的长度，比较这个目录究竟是不是root目录
	$temp  =realpath($path);
	return (strncmp($root, $temp, mb_strlen($root)) === 0);
}
