<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AssetApiService;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\AssetHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class AssetHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class AssetHelperTest extends TestCase
{
    /**
     * @var ClientMock
     */
    private ClientMock $api;

    /**
     * @var TestHelper
     */
    private TestHelper $testHelper;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $testHelper = new TestHelper();
        $this->testHelper = $testHelper;
        $this->api = $testHelper->getApi();
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new AssetHelper();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @return void
     */
    public function testConstructThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new AssetHelper($parameter);
    }

    /**
     * @return array
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "parameter" => $this->testHelper->getPositiveValue(),
            ],
            [
                "parameter" => null,
            ],
        ];
    }

    /**
     *
     * @return void
     */
    public function testGetService()
    {
        $helper = new AssetHelper($this->api);

        $service = $helper->getService();

        $this->assertInstanceOf(AssetApiService::class, $service);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new AssetHelper($this->api);
        $result = $helper->get();
    }

    /**
     * @dataProvider getThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testGetThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new AssetHelper($this->api);
        $result = $helper->get($parameter);
    }

    /**
     * @return array
     */
    public function getThrowsTypeErrorException(): array
    {
        return [
            [
                "parameter" => "",
            ],
            [
                "parameter" => null,
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetThrowsExceptionMessageEntityIdGreaterThanZero()
    {
        $this->expectExceptionMessage(AssetHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new AssetHelper($this->api);
        $helper->get($this->testHelper->getZeroOrNegativeValue());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGet()
    {
        $helper = new AssetHelper($this->api);
        $result = $helper->get(1);

        $expected = [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => true];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetBy()
    {
        $helper = new AssetHelper($this->api);

        $result = $helper->getBy(
            [
                EntityConstants::LIMIT_FIELD_KEY => 1
            ]
        );

        $expected = [
            "total" => 1,
            EntityConstants::LIMIT_FIELD_KEY => 1,
            "pages" => 1,
            "page" => 1,
            "results" => [
                [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::SEARCHABLE_FIELD_KEY => 1
                ]
            ]
        ];

        $this->assertEquals($expected, $result);
    }
}