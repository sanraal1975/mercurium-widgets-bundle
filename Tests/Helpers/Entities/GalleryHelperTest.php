<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Services\GalleryApiService;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\GalleryHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class GalleryHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class GalleryHelperTest extends TestCase
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

        $helper = new GalleryHelper();
    }

    /**
     * @return void
     */
    public function testConstructThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new GalleryHelper(null);
    }

    /**
     * @return void
     */
    public function testGetService()
    {
        $helper = new GalleryHelper($this->api);

        $service = $helper->getService();

        $this->assertInstanceOf(GalleryApiService::class, $service);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new GalleryHelper($this->api);
        $result = $helper->get();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new GalleryHelper($this->api);
        $result = $helper->get(null);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetThrowsExceptionMessageEntityIdGreaterThanZero()
    {
        $this->expectExceptionMessage(GalleryHelper::ENTITY_ID_MUST_BE_GREATER_THAN_ZERO);

        $helper = new GalleryHelper($this->api);
        $result = $helper->get($this->testHelper->getZeroOrNegativeValue());
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGet()
    {
        $helper = new GalleryHelper($this->api);
        $result = $helper->get(1);

        $expected = [EntityConstants::ID_FIELD_KEY => 1, EntityConstants::SEARCHABLE_FIELD_KEY => true];

        $this->assertEquals($expected, $result);
    }

    /**
     *
     * @return void
     * @throws Exception
     */
    public function testGetByThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new GalleryHelper($this->api);
        $result = $helper->getBy();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByThrowsTypeErrorException()
    {
        $this->expectException(TypeError::class);

        $helper = new GalleryHelper($this->api);
        $result = $helper->getBy(null);
    }


    /**
     * @return void
     * @throws Exception
     */
    public function testGetByReturnsEntities()
    {
        $helper = new GalleryHelper($this->api);

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
        $helper = new GalleryHelper($this->api);

        $result = $helper->getLast();

        $expected = [
            EntityConstants::ID_FIELD_KEY => 1,
            EntityConstants::SEARCHABLE_FIELD_KEY => true
        ];

        $this->assertEquals($expected, $result);
    }
}