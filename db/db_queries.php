<?php
function encode_pass($str)
{
    for ($i = 0; $i < 5; $i++) {
        $str = strrev(base64_encode($str)); //apply base64 first and then reverse the string
    }
    return $str;
}

//function to decrypt the string
function decode_pass($str)
{
    for ($i = 0; $i < 5; $i++) {
        $str = base64_decode(strrev($str)); //apply base64 first and then reverse the string}
    }
    return $str;
}
function gen_pass()
{
    $pass = mt_rand(100000, 999999);
    return $pass;
}
