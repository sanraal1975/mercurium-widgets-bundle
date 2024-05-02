<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Client\Services\ContactApiService;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\ContactHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;
use TypeError;

/**
 * Class ContactHelperTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities
 */
class ContactHelperTest extends TestCase
{
    /**
     * @var TestHelper
     */
    private $testHelper;

    /**
     * @var ClientMock
     */
    private $api;

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

        $helper = new ContactHelper();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     * @return void
     */
    public function testConstructThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new ContactHelper($parameter);
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
        $helper = new ContactHelper($this->api);
        $service = $helper->getService();

        $this->assertInstanceOf(ContactApiService::class, $service);
    }

    /**
     * @dataProvider getByThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testGetByThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new ContactHelper($this->api);
        $result = $helper->getBy($parameter);
    }

    /**
     * @return array
     */
    public function getByThrowsTypeErrorException(): array
    {
        return [
            [
                "parameter" => 1,
            ],
            [
                "parameter" => "1",
            ],
            [
                "parameter" => null,
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByEmailThrowsArgumentCounterErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $helper = new ContactHelper($this->api);
        $result = $helper->getByEmail();
    }

    /**
     * @dataProvider getByEmailThrowsTypeErrorException
     *
     * @return void
     * @throws Exception
     */
    public function testGetByEmailThrowsTypeErrorException($parameter)
    {
        $this->expectException(TypeError::class);

        $helper = new ContactHelper($this->api);
        $result = $helper->getByEmail($parameter);
    }

    /**
     * @return array
     */
    public function getByEmailThrowsTypeErrorException(): array
    {
        return [
            [
                "parameter" => null,
            ]
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testGetByEmailThrowsCustomExceptionEmptyEmail()
    {
        $this->expectExceptionMessage(ContactHelper::EMPTY_EMAIL);

        $helper = new ContactHelper($this->api);
        $result = $helper->getByEmail("");
    }

    /**
     * @dataProvider getByEmail
     *
     * @return void
     * @throws Exception
     */
    public function testGetByEmail($email, $expected)
    {
        $helper = new ContactHelper($this->api);
        $result = $helper->getByEmail($email);

        $this->assertEquals($expected, $result);
    }

    /**
     * @return array[]
     */
    public function getByEmail(): array
    {
        return [
            [
                "email" => TestHelper::EMAIL_CONTACT_NOT_FOUND,
                "expected" => []
            ],
            [
                "email" => "test@test.com",
                "expected" => [
                    EntityConstants::ID_FIELD_KEY => 1,
                    EntityConstants::SEARCHABLE_FIELD_KEY => true,
                    EntityConstants::EMAIL_FIELD_KEY => "test@test.com"
                ]
            ]
        ];
    }
}