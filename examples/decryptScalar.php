<?php
require_once('../Crypt.php');
$crypt = new Crypt();
$crypt->setKey('YOUR CYPHER KEY');
$crypt->setData('Crypt#7AUoWBXJhDav7RPwzRC29b+aRW1imIqQ#qvVLn/zy2nYHVeZvOPJuvvmyomeyT2gyFcqQTbT2SWWACBhqREJyvBc98KMiKeKqctyS#06a5246dde311b1ec8b5332e4949c5a482d96ee3');
echo $crypt->decrypt();
