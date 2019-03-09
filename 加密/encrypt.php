<?php
function passport_encrypt($txt, $key) {
    srand((double)microtime() * 1000000);
    $encrypt_key = md5(rand(0, 32000));
    $ctr = 0;
    $tmp = '';
    //这个变量用于产看中间结果，来更清楚地明白加密原理
    $test = '';
    //循环异或并拼接随机字符串
    for($i = 0;$i < strlen($txt); $i++) {
        //这个判断就是为了进行循环操作，因为待混淆的文本长度可能比32大，这样就能循环进行异或运算了
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr]);
        $test .= $encrypt_key[$ctr].".".$txt[$i]."^".$encrypt_key[$ctr++].".";
    }
    echo "<hr><br />";
    echo $test;
    echo "<hr><br />";
    return base64_encode(passport_key($tmp, $key));
}

//使用秘钥对加密文本进行解密
function passport_decrypt($txt, $key) {
    //因为加密完成之后将文本编码成了base64的形式，因此需要先进性base64  decode
    //根据异或的性质，a^b=c <==> a^c=b <==> b^c=a
    //我们再调用一次passport_key就可以获得加密步骤中的经过一次混淆的文本
    $txt = passport_key(base64_decode($txt), $key);
    $tmp = '';
/*
 * 根据上面的第一阶段的混淆过程，我们可以看出混淆后的字符串是这样的：
 *  比如encrypt_key为0123456789
 *  txt为thisisatest
 * 则tmp应该是这样的，我们用.表示连接符：
 *  0.t^0.1.h^1.2.i^2.3.3^s.......
 * 这样我们在解密的时候，直接两两异或即可还原
 * */
    for($i = 0;$i < strlen($txt); $i++) {
        $md5 = $txt[$i];
        $tmp .= $txt[++$i] ^ $md5;
    }
    return $tmp;
}

//结合加密秘钥对已经进行过混淆处理的文本进行加密
function passport_key($txt, $encrypt_key) {
    //将加密秘钥转换成32位的md5值
    $encrypt_key = md5($encrypt_key);
    $ctr = 0;
    $tmp = '';
    //对混效果的暗文再进行循环异或操作
    for($i = 0; $i < strlen($txt); $i++) {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
    }
    return $tmp;
}
?>
