<?php

/**
 * cryptPHP
 *
 * Copyright (c) 2010, Osman Ungur <osmanungur@gmail.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Osman Ungur nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Provides cryptography functionality, including hashing and symmetric-key encryption
 * @package    cryptPHP
 * @author     Osman Ungur <osmanungur@gmail.com>
 * @copyright  2010 Osman Ungur <osmanungur@gmail.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       https://github.com/osmanungur/crypt-php
 */

class cryptPHP {

    private $data;
    private $key;
    private $module;
    private $complexTypes = false;
    const HMAC_ALGORITHM = 'sha1';
    const DELIMITER = '#';
    const MCRYPT_MODULE = 'rijndael-192';
    const MCRYPT_MOD = 'cfb';
    const PREFIX = 'cryptPHP';
    const MINIMUM_KEY_LENGTH = 8;

    function __construct() {
        $this->checkEnvironment();
        $this->setModule(mcrypt_module_open(self::MCRYPT_MODULE, '', self::MCRYPT_MOD, ''));
    }

    /**
     * Checks the environment for mcrypt and mcrypt module
     *
     * @return void
     * @author Osman Üngür
     */
    private function checkEnvironment() {
        if ((!extension_loaded('mcrypt')) || (!function_exists('mcrypt_module_open'))) {
            throw new Exception('The PHP mcrypt extension must be installed for encryption', 1);
        }
        if (!in_array(self::MCRYPT_MODULE, mcrypt_list_algorithms())) {
            throw new Exception("The cipher used self::MCRYPT_MODULE does not appear to be supported by the installed version of libmcrypt", 1);
        }
    }

    /**
     * Sets the data for encryption or decryption
     *
     * @param mixed $data
     * @return void
     * @author Osman Üngür
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * Sets the secret key for encryption or decryption, at least 8 character long
     *
     * @param string $key
     * @return void
     * @author Osman Üngür
     */
    public function setKey($key) {
        if (strlen($key) < self::MINIMUM_KEY_LENGTH) {
            $message = sprintf('The secret key must be a minimum %s character long', self::MINIMUM_KEY_LENGTH);
            throw new Exception($message, 1);
        }
        $this->key = $key;
    }

    /**
     * Sets the mcrypt module
     *
     * @param resource $module
     * @return void
     * @author Osman Üngür
     */
    private function setModule($module) {
        $this->module = $module;
    }

    /**
     * Sets using complex data types like arrays and objects for serialization
     *
     * @param bool $complexTypes
     * @return void
     * @author Osman Üngür
     */
    public function setComplexTypes($complexTypes) {
        $this->complexTypes = $complexTypes;
    }

    /**
     * Returns the encrypted or decrypted data
     *
     * @return mixed
     * @author Osman Üngür
     */
    private function getData() {
        return $this->data;
    }

    /**
     * Returns the secret key for encryption
     *
     * @return string
     * @author Osman Üngür
     */
    private function getKey() {
        return $this->key;
    }

    /**
     * Returns the mcrypt module resource
     *
     * @return resource
     * @author Osman Üngür
     */
    private function getModule() {
        return $this->module;
    }

    /**
     * Returns true if using complex data types like arrays and objects declared
     *
     * @return bool
     * @author Osman Üngür
     */
    private function getComplexTypes() {
        return $this->complexTypes;
    }

    /**
     * Encrypts the given data using symmetric-key encryption
     *
     * @return string
     * @author Osman Üngür
     */
    public function encrypt() {
        mt_srand();
        $init_vector = mcrypt_create_iv(mcrypt_enc_get_iv_size($this->getModule()), MCRYPT_RAND);
        $key = substr(sha1($this->getKey()), 0, mcrypt_enc_get_key_size($this->getModule()));
        mcrypt_generic_init($this->getModule(), $key, $init_vector);
        if ($this->getComplexTypes()) {
            $this->setData(serialize($this->getData()));
        }
        $cipher = mcrypt_generic($this->getModule(), $this->getData());
        $hmac = hash_hmac(self::HMAC_ALGORITHM, $init_vector . self::DELIMITER . $cipher, $this->getKey());
        $encoded_init_vector = base64_encode($init_vector);
        $encoded_cipher = base64_encode($cipher);
        return self::PREFIX . self::DELIMITER . $encoded_init_vector . self::DELIMITER . $encoded_cipher . self::DELIMITER . $hmac;
    }

    /**
     * Decrypts encrypted cipher using symmetric-key encryption
     *
     * @return mixed
     * @author Osman Üngür
     */
    public function decrypt() {
        $elements = explode(self::DELIMITER, $this->getData());
        if (count($elements) != 4 || $elements[0] != self::PREFIX) {
            $message = sprintf('The given data does not appear to be encrypted with %s', __CLASS__);
            throw new Exception($message, 1);
        }
        $init_vector = base64_decode($elements[1]);
        $cipher = base64_decode($elements[2]);
        $given_hmac = $elements[3];
        $hmac = hash_hmac(self::HMAC_ALGORITHM, $init_vector . self::DELIMITER . $cipher, $this->getKey());
        if ($given_hmac != $hmac) {
            throw new Exception('The given data appears tampered or corrupted', 1);
        }
        $key = substr(sha1($this->getKey()), 0, mcrypt_enc_get_key_size($this->getModule()));
        mcrypt_generic_init($this->getModule(), $key, $init_vector);
        $result = mdecrypt_generic($this->getModule(), $cipher);
        if ($this->getComplexTypes()) {
            return unserialize($result);
        }
        return $result;
    }

    public function __destruct() {
        @mcrypt_generic_deinit($this->getModule());
        mcrypt_module_close($this->getModule());
    }

}

?>