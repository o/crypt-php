<?php
require_once('../Crypt.php');
$crypt = new Crypt();
$crypt->setKey('YOUR CYPHER KEY');
$crypt->setData('cryptPHP#YvpAQTL4Xdj7LKZTRfvxkBdYbQ2s+1Kv#xKLBMfkIjDdSGsBPc1OK0RvLUxX5HdAaaW14UrItULIKMpKCm84a4An6szpFrDkj3gfK#66a6b892f47ca5481af41620520b182d3a7fbf87');
echo $crypt->decrypt();