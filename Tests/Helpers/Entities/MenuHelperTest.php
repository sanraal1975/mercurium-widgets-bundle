<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\Helpers\Entities;

use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\ApiClientBundle\Client\Services\MenuApiService;
use Comitium5\MercuriumWidgetsBundle\Helpers\Entities\MenuHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\Helpers\TestHelper;
use Comitium5\MercuriumWidgetsBundle\Tests\MocksStubs\ClientMock;
use Exception;
use PHPUnit\Framework\TestCase;

class MenuHelperTest extends TestCase
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
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->testHelper = new TestHelper();

        $this->api = $this->testHelper->getApi();
    }

    /**
     * @return void
     */
    public function testGetService()
    {
        $helper = new MenuHelper($this->api);

        $service = $helper->getService();

        $this->assertInstanceOf(MenuApiService::class, $service);
    }

    /**
     * @dataProvider getMenu
     *
     * @return void
     * @throws Exception
     */
    public function testGet($id, $result)
    {
        $helper = new MenuHelper($this->api);

        $menu = $helper->get($id);

        $this->assertEquals($result, $menu);
    }

    /**
     * @return array[]
     */
    public function getMenu(): array
    {
        return [
            [
                "id" => $this->testHelper::ENTITY_ID_TO_RETURN_EMPTY,
                "result" => []
            ],
            [
                "id" => $this->testHelper::MENU_WITH_ITEMS,
                "result" => [
                    "items" => [
                        [
                            "title" => "foo",
                            "permalink" => "/bar"
                        ]
                    ],
                    EntityConstants::SEARCHABLE_FIELD_KEY => true
                ]
            ],
        ];
    }
}