<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Services\CategoryApiService;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\CategoryHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class CategoryHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class CategoryHelperTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->testHelper = new TestHelper();
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCounterErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new CategoryHelper();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     * @return void
     */
    public function testConstructThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new CategoryHelper($parameter);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "parameter" => 1,
            ],
            [
                "parameter" => null,
            ],
        ];
    }

    /**
     * @return void
     */
    public function testGetService()
    {
        $helper = new CategoryHelper($this->testHelper->getApi());
        $service = $helper->getService();

        $this->assertInstanceOf(CategoryApiService::class, $service);
    }

}