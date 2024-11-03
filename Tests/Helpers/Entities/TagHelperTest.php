<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Services\TagApiService;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\TagHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class TagHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class TagHelperTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private TestHelper $testHelper;

    /**
     * @var ClientMock
     */
    private ClientMock $api;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);
        $this->testHelper = new TestHelper();

        $this->api = $this->testHelper->getApi();
    }

    /**
     * @return void
     */
    public function testConstructThrowsArgumentCounterErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new TagHelper();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     * @return void
     */
    public function testConstructThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new TagHelper($parameter);
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
        $helper = new TagHelper($this->api);
        $service = $helper->getService();

        $this->assertInstanceOf(TagApiService::class, $service);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new TagHelper($this->api);
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

        $helper = new TagHelper($this->api);
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
    public function testGetThrowsCustomExceptionEntityIdGreaterThanZero()
    {
        $this->expectExceptionMessage(TagHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new TagHelper($this->api);
        $result = $helper->get($this->testHelper->getZeroOrNegativeValue());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGet()
    {
        $helper = new TagHelper($this->api);
        $result = $helper->get(1);

        $expected = [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => true];

        $this->assertEquals($expected, $result);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByThrowArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new TagHelper($this->api);
        $result = $helper->getBy();
    }

    /**
     * @dataProvider getByThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testGetByThrowsTypeErrorException($parameters)
    {
        $this->expectException(TypeError::class);

        $helper = new TagHelper($this->api);
        $result = $helper->getBy($parameters);
    }

    /**
     * @return array
     */
    public function getByThrowsTypeErrorException(): array
    {
        return [
            [
                "parameters" => 1
            ],
            [
                "parameters" => null
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetBy()
    {
        $helper = new TagHelper($this->api);

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
    /**
     * @return void
     * @throws Exception
     */
    public function testGetLastReturnsEntity()
    {
        $helper = new TagHelper($this->api);

        $result = $helper->getLast();

        $expected = [
            EntityConstants::ID_FIELD_KEY => 1,
            EntityConstants::SEARCHABLE_FIELD_KEY => true
        ];

        $this->assertEquals($expected, $result);
    }
}