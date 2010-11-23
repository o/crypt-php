Introduction
------------
cryptPHP is class for encrypting and decrypting any data type in PHP. It uses libmcrypt and rjindael-192 (also known as AES192) algorithm. It tested on Mac OS X server and some (Ubuntu and Centos) Linux distributions.

How to use
----------
Include cryptPHP.php to your PHP project and call cryptPHP class with new operator. It checks your environment is mcrypt installed correctly.

Encryption
==========

<pre>$crypt = new cryptPHP;</pre>
Now provide a secret key for encrypting and decrypting given data. This secret key must 8 character at least.

<pre>$crypt->setKey('eff99cfe6876008c6a6e080e4a382be1');</pre>
Ok, if you think encrypt a complex data type like an array or object we must declare this. (This parameter is not required for scalar data types like string and numbers)

<pre>$crypt->setComplexTypes(TRUE);</pre>
Now, we give data for encrypting.

<pre>$crypt->setData(array('username' => 'osmanungur', 'realname' => 'Osman Üngür', 'password' => 12345, 'groups' => array(18, 34)));</pre>
And finally we will encrypt it !

<pre>$encrypted = $crypt->encrypt();
// It gives you like cryptPHP#GjHTQ1SU+WWKb/CYhjyQrKOlXvsyIkqP#xuA6
S6NIQegeZtPjuuS9m3iy4F6yGw9cFBYIcYddJ7Y4g3lmFUObfRH3glx0Jv9ruOA9ZFx
4p4V1Lyyb+ikmEK84z8AEFPqaRhavJ7TUACAyVRfP6mcRbnKNW8awYoaHBD23q6/jCS
AvHXGAGBbXuVTk7yCIz3m9YnFzq3TG36edwIzDlG7L#9dbbfefa3e85c28c4b434505
7e472a6325ccfe02
</pre>

This cipher is change on every request.

Decryption
==========

<pre>$crypt = new cryptPHP;</pre>
Do you remember ? We encrypted a complex data type.

<pre>$crypt->setComplexTypes(TRUE);</pre>
We set key for decryption. Dont forgot your key !

<pre>$crypt->setKey('eff99cfe6876008c6a6e080e4a382be1');</pre>
Now we will call encrypted data. Maybe it living in SQL or cookie.

<pre>$crypt->setData('cryptPHP#GjHTQ1SU+WWKb/CYhjyQrKOlXvsyIkqP#xuA6S6NI
QegeZtPjuuS9m3iy4F6yGw9cFBYIcYddJ7Y4g3lmFUObfRH3glx0Jv9ruOA9ZFx4p4V
1Lyyb+ikmEK84z8AEFPqaRhavJ7TUACAyVRfP6mcRbnKNW8awYoaHBD23q6/jCSAvHX
GAGBbXuVTk7yCIz3m9YnFzq3TG36edwIzDlG7L#9dbbfefa3e85c28c4b4345057e47
2a6325ccfe02');
</pre>

Decrypting...

<pre>$decrypted = $crypt->decrypt();</pre>

Ok, now we discovering on our decrypted data.

<pre>var_dump($decrypted);
array
  'username' => string 'osmanungur' (length=10)
  'realname' => string 'Osman Üngür' (length=13)
  'password' => int 12345
  'groups' => 
    array
      0 => int 18
      1 => int 34
</pre>

Everything is ok ? If something went wrong please tell me whats going on from Issues page.