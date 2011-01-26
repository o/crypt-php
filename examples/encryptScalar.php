<?php
require_once('../Crypt.php');
$crypt = new Crypt();
$crypt->setKey('YOUR CYPHER KEY');
$crypt->setData('the answer to life the universe and everything = 42');
echo $crypt->encrypt();