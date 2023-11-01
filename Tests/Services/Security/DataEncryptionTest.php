<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Services\Security;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Services\Security\DataEncryption;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class DataEncryptionTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Services\Security
 */
class DataEncryptionTest extends TestCase
{
    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $encryptor = new DataEncryption();
    }

    /**
     * @return void
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $encryptor = new DataEncryption(null);
    }

    /**
     * @return void
     */
    public function testConstructThrowsExceptionMessageEmptyData()
    {
        $this->expectExceptionMessage(DataEncryption::EMPTY_DATA);

        $encryptor = new DataEncryption("");
    }

    /**
     * @return void
     */
    public function testEncrypt()
    {
        $expected = "2mmj%2BovbVxCHsRd97LZcYg%3D%3D";

        $encryptor = new DataEncryption("foobar");

        $result = $encryptor->encrypt();

        $this->assertEquals($expected,$result);
    }

    /**
     * @return void
     */
    public function testDecrypt()
    {
        $expected = "foobar";

        $encryptor = new DataEncryption("2mmj%2BovbVxCHsRd97LZcYg%3D%3D");

        $result = $encryptor->decrypt();

        $this->assertEquals($expected,$result);
    }
}