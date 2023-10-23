<?php

namespace Comitium5\MercuriumWidgetsBundle\Services\Security;

use Exception;

/**
 * Class DataEncryption
 *
 * @package Comitium5\MercuriumWidgetsBundle\Services\Security
 */
class DataEncryption
{
    /**
     *  string
     */
    const SECRET_KEY = "7=dUK8IRC0?:^1~PC}Sh>rTK=o[zx3]8'l<|2ATb";

    /**
     * string
     */
    const SECRET_IV = "n|0ny/Z7uNpb&{!_";

    /**
     * string
     */
    const ENCRYPT_METHOD = "AES-256-CBC";

    /**
     * @var string
     */
    protected $data;

    /**
     * @param $data
     * @throws Exception
     */
    public function __construct($data)
    {
        if (!is_string($data) || empty(trim($data))) {
            throw new Exception("Data argument must be a non empty string");
        }

        $this->data = trim($data);
    }

    /**
     * @return string
     */
    public function encrypt(): string
    {
        $result = openssl_encrypt(
            $this->data,
            self::ENCRYPT_METHOD,
            $this->generateKey(),
            0,
            $this->generateIv()
        );

        return rawurlencode(strval($result));
    }

    /**
     * @return string
     */
    public function decrypt(): string
    {
        $result = openssl_decrypt(
            rawurldecode($this->data),
            self::ENCRYPT_METHOD,
            $this->generateKey(),
            0,
            $this->generateIv()
        );

        return strval($result);
    }

    /**
     * @return string
     */
    private function generateKey(): string
    {
        return hash('sha256', self::SECRET_KEY);
    }

    /**
     * @return string
     */
    private function generateIv(): string
    {
        return substr(hash('sha256', self::SECRET_IV), 0, 16);
    }
}