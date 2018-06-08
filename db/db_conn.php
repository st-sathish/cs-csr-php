<?php
date_default_timezone_set("Asia/Kolkata");
#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
#error_reporting(E_ALL);

define('TITLE', 'CSR');

if($_SERVER['HTTP_HOST'] == "localhost"){
    define('SITEURL', 'https://' . $_SERVER['HTTP_HOST'].'/csr/');
    define('SITEPATH', $_SERVER['DOCUMENT_ROOT']);
    define('CSS', $_SERVER['DOCUMENT_ROOT'] . '/css/');
    define('IMAGES', $_SERVER['DOCUMENT_ROOT'] . '/images/');
    define('DBHOST', 'localhost');
    define('DBNAME', 'csr');
    define('DBUSER', 'root');
    define('DBPASS', 'root');
}
else{
    define('SITEURL', 'https://' . $_SERVER['HTTP_HOST'].'/csr/');
    define('SITEPATH', $_SERVER['DOCUMENT_ROOT']);
    define('CSS', $_SERVER['DOCUMENT_ROOT'] . '/css/');
    define('IMAGES', $_SERVER['DOCUMENT_ROOT'] . '/images/');
    define('DBHOST', 'localhost');
    define('DBNAME', 'csr');
    define('DBUSER', 'root');
    define('DBPASS', 'root');
}
$conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
function fromsqldmy($input){
  $y=substr($input,0,4);
  $m=substr($input,5,2);
  $d=substr($input,8,2);
  return($d."/".$m."/".$y);
}

function php_date($input){
  $y=substr($input,0,4);
  $m=substr($input,4,2);
  $d=substr($input,6,2);
  return($y."-".$m."-".$d);
}