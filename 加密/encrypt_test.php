<?php
include "encrypt.php";

$txt = "I will be back!";
$key = "justfortest";
$encrypt = passport_encrypt($txt,$key);
$decrypt = passport_decrypt($encrypt,$key);
echo "加密前的字符串:".$txt."<br>";
echo "加密后的字符串:".$encrypt."<br>";
echo "解密后的字符串:".$decrypt."<br>";

$array = array(
    "php" => "Zend Framework",
    "Java" => "Spring",
    "C#" => "Framework 1.1"
);
//对数组对象进行序列化，就是将其变成一串字符串
$txt = serialize($array);
$key = "justfortest";
$encrypt = passport_encrypt($txt,$key);
$decrypt = passport_decrypt($encrypt,$key);
$decryptArray = unserialize($decrypt);
echo "原数组：";
print("<pre>");
print_r($array);
print("<pre>");
echo "系列化后的字符串:".$txt."<br>";
echo "加密后的字符串:".$encrypt."<br>";
echo "解密后的字符串:".$decrypt."<br>";
echo "反系列化还原后的数组：";
print("<pre>");
print_r($decryptArray);
print("<pre>");

