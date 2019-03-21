<?php
define('ROOT', './doc/');

function c($str){ return mb_convert_encoding($str, 'UTF-8', 'SJIS'); }
function r($str){ return mb_convert_encoding($str, 'SJIS', 'UTF-8'); }
function isValid($path) {
	$root = c(realpath(ROOT));
	//由于根目录root的mb_strlne()的返回值更小，所以我们只需要比较长度为mb_strlen($root)的部分即可判断$path是否为非法目录
	return (strncmp($root, realpath($path), mb_strlen($root)) === 0);
}
