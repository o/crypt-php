<?php
require_once('../Crypt.php');
$crypt = new Crypt();
$crypt->setKey('YOUR CYPHER KEY');
$crypt->setComplexTypes(TRUE);
$crypt->setData('cryptPHP#bWOXEusBnyDHRuNY+zAyqOWpYLPkmSMJ#tdcvQqIxylC3bNuxFQ1GUIyKN0eO8HF/2JsQJG2GhkovgNEmQDTYLELIwNwoK5vmgaErww4CGslPDx1F2ZS7uVqMJcNnD4tp7XAKzCCqmWZNw+1mWRuf#3089b5eda40c7a40171666c6fb2694077b03de2d');
var_dump($crypt->decrypt());