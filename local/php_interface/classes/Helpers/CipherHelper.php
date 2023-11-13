<?php 

class Cipher {
    private $key;
    private $cipher;

    public function __construct($key, $cipher = 'AES-128-CBC') {
        $this->key = hash('sha256', $key, true);
        $this->cipher = $cipher;
    }

    public function encrypt($plaintext) {
        $ivlen = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext = openssl_encrypt($plaintext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv.$ciphertext);
    }

    public function decrypt($ciphertext) {
        $ciphertext = base64_decode($ciphertext);
        $ivlen = openssl_cipher_iv_length($this->cipher);
        $iv = substr($ciphertext, 0, $ivlen);
        $ciphertext = substr($ciphertext, $ivlen);
        $plaintext = openssl_decrypt($ciphertext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        return $plaintext;
    }
}