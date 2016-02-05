<?php
require_once('../Crypt.php');
$crypt = new Crypt();
$crypt->setKey('YOUR CYPHER KEY');
$crypt->setComplexTypes(TRUE);
$crypt->setData('Crypt#1NWchpTyOm16Dp9xJX+hVVccxC1euPCp#YZJwDMvoUoS4EO7R4QNzT8ouY9l6Hboy8vgTlXxQbza7/A5+cOyX5kjxd+R9HZT5eYgZnVHiu2EYOuj4KELfn8HSYYKUaStUNFj3+KPmvj/ab/FDVa4G#ddcccd4ff034de689274e21e3e7762a1eca89b80');
var_dump($crypt->decrypt());
