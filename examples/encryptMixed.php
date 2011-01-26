<?php
require_once('../Crypt.php');
$crypt = new Crypt();
$crypt->setKey('YOUR CYPHER KEY');
$crypt->setComplexTypes(TRUE);
$data = new ArrayObject();
$data->append('foo');
$data->append('bar');
$data->append('baz');
$crypt->setData($data);
echo $crypt->encrypt();