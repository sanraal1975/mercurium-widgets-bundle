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
    private TestHelper $helper;

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
    public function testSetReturnFalse()
    {
        $service = new CacheService(new MemoryCacheInterfaceMock(), $this->helper::API_SUBSITE);

        $this->assertFalse($service->set("", "", 0));
    }
}