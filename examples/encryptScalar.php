<?php
require_once('../cryptPHP.php');
$crypt = new cryptPHP;
$crypt->setKey('YOUR CYPHER KEY');
$crypt->setData('the answer to life the universe and everything = 42');
echo $crypt->encrypt();