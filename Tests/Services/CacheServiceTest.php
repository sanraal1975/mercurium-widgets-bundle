<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Services;

use ArgumentCountError;
use Comitium5\MercuriumWidgetsBundle\Services\CacheService;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\Services\MemoryCacheInterfaceMock;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class CacheServiceTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Services
 */
class CacheServiceTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $helper;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);
        $this->helper = new TestHelper();
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $encryptor = new CacheService();
    }

    /**
     * @return void
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $encryptor = new CacheService(null);
    }

    /**
     * @return void
     */
    public function testSetReturnFalseForEmptyKey()
    {
        $service = new CacheService(new MemoryCacheInterfaceMock(), $this->helper::API_SUBSITE);

        $this->assertFalse($service->set("", "", 0));
    }

    /**
     * @dataProvider setReturnResult
     *
     * @return void
     */
    public function testSetReturnResult($key, $value)
    {
        $service = new CacheService(new MemoryCacheInterfaceMock(), $this->helper::API_SUBSITE);

        $result = $service->set($key, "testValue", 10);

        $this->assertEquals($value, $result);
    }

    /**
     * @return array[]
     */
    public function setReturnResult(): array
    {
        return [
            [
                "key" => "testKeyReturnFalse",
                "value" => false
            ],
            [
                "key" => "testKeyReturnTrue",
                "value" => true
            ]
        ];
    }

    /**
     * @return void
     */
    public function testGetReturnsEmptyForEmptyKey()
    {
        $service = new CacheService(new MemoryCacheInterfaceMock(), $this->helper::API_SUBSITE);

        $result = $service->get("");

        $this->assertEquals("", $result);
    }

    /**
     * @dataProvider getReturnsValue
     *
     * @return void
     */
    public function testGetReturnsValue($key, $value)
    {
        $service = new CacheService(new MemoryCacheInterfaceMock(), $this->helper::API_SUBSITE);

        $result = $service->get($key);

        $this->assertEquals($value, $result);
    }

    /**
     * @return array[]
     */
    public function getReturnsValue()
    {
        return [
            [
                "key" => "testKeyReturnValue",
                "value" => "foo"
            ],
            [
                "key" => "testKeyReturnEmpty",
                "value" => ""
            ],
        ];
    }

    /**
     * @return void
     */
    public function testDeleteReturnFalseForEmptyKey()
    {
        $service = new CacheService(new MemoryCacheInterfaceMock(), $this->helper::API_SUBSITE);

        $this->assertFalse($service->delete(""));
    }

    /**
     * @dataProvider deleteReturnValue
     *
     * @return void
     */
    public function testDeleteReturnValue($key, $value)
    {
        $service = new CacheService(new MemoryCacheInterfaceMock(), $this->helper::API_SUBSITE);

        $result = $service->delete($key);

        $this->assertEquals($value, $result);
    }

    /**
     * @return array[]
     */
    public function deleteReturnValue(): array
    {
        return [
            [
                "key" => "testKeyReturnFalse",
                "value" => false
            ],
            [
                "key" => "testKeyReturnTrue",
                "value" => true
            ]
        ];
    }

}