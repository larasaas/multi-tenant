<?php

namespace Larasaas\Tenant\Support;

class Serializer
{
    private $key;

    protected $initVectorSize;
    protected $initVector;

    public function __construct($key)
    {
        $this->key = $key;
        $this->initVectorSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $this->initVector = mcrypt_create_iv($this->initVectorSize, MCRYPT_RAND);
    }

    public function serialize($object)
    {
        return serialize($object);
    }

    public function unserialize($string)
    {
        return unserialize($string);
    }

    public function encryptedSerialize($object)
    {
        $serializedString = $this->serialize($object);

        $encryptedString = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key, $serializedString, MCRYPT_MODE_CBC, $this->initVector);

        $encryptedString = $this->initVector . $encryptedString;

        return base64_encode($encryptedString);
    }

    public function encryptedUnserialize($string)
    {

        $decodedBase64 = base64_decode($string);

        $initVectorDecoded = substr($decodedBase64, 0, $this->initVectorSize);

        $decryptedSerializedString = substr($decodedBase64, $this->initVectorSize);

        $decryptedSerializedString = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, $decryptedSerializedString, MCRYPT_MODE_CBC, $initVectorDecoded);

        return $this->unserialize($decryptedSerializedString);
    }

}