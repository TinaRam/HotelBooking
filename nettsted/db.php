<?php

$host="localhost";
$user="web-prg2-2018-04";
$password="26737";
$database="web-prg2-2018-04";


/* AMPPS Hodepina*/
// $host="127.0.0.1";
// $user="root";
// $password="mysql";
// $database="hotell";

$db=mysqli_connect($host,$user,$password,$database);
if (!$db)
{
  exit('Ikke kontakt med database');
}

mysqli_set_charset($db, 'utf-8'); // Setter char-set utf8 //
 
?>
