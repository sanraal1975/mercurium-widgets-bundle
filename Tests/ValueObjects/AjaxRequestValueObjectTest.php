<?php

namespace Comitium5\MercuriumWidgetsBundle\Tests\ValueObjects;

use ArgumentCountError;
use Comitium5\ApiClientBundle\Tests\TestCase;
use Comitium5\MercuriumWidgetsBundle\Constants\EntityConstants;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\AjaxRequestValueObject;
use Exception;
use TypeError;

/**
 * Class AjaxRequestValueObjectTest
 *
 * @package Comitium5\MercuriumWidgetsBundle\Tests\ValueObjects
 */
class AjaxRequestValueObjectTest extends TestCase
{
    /**
     * @var AjaxRequestValueObject
     */
    private $ajaxRequestValueObject;

    /**
     * @param $name
     * @param array $data
     * @param $dataName
     * @throws Exception
     */
    public function __construct($name = null, array $data = [], $dataName = "")
    {
        parent::__construct($name, $data, $dataName);

        $this->ajaxRequestValueObject = new AjaxRequestValueObject(
            "comitium5_common_widgets_self_call",
            "resolveAjaxAction",
            "dummy_widget_class",
            [EntityConstants::ID_FIELD_KEY => 1],
            []
        );
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsArgumentCountErrorException()
    {
        $this->expectException(ArgumentCountError::class);

        $valueObject = new AjaxRequestValueObject();
    }

    /**
     * @dataProvider constructThrowsTypeErrorException
     *
     * @param $service
     * @param $ajaxEntryPoint
     * @param $widgetClass
     * @param $widgetParameters
     * @param $widgetParametersMapping
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException(
        $service,
        $ajaxEntryPoint,
        $widgetClass,
        $widgetParameters,
        $widgetParametersMapping
    )
    {
        $this->expectException(TypeError::class);

        $valueObject = new AjaxRequestValueObject($service, $ajaxEntryPoint, $widgetClass, $widgetParameters, $widgetParametersMapping);
    }

    /**
     * @return array[]
     */
    public function constructThrowsTypeErrorException(): array
    {
        return [
            [
                "service" => null,
                "ajaxEntryPoint" => "",
                "widgetClass" => "",
                "widgetParameters" => [EntityConstants::ID_FIELD_KEY => 1],
                "widgetParametersMapping" => []
            ],
            [
                "service" => "comitium5_common_widgets_self_call",
                "ajaxEntryPoint" => null,
                "widgetClass" => "",
                "widgetParameters" => [EntityConstants::ID_FIELD_KEY => 1],
                "widgetParametersMapping" => []
            ],
            [
                "service" => "comitium5_common_widgets_self_call",
                "ajaxEntryPoint" => "resolveAjaxAction",
                "widgetClass" => null,
                "widgetParameters" => [EntityConstants::ID_FIELD_KEY => 1],
                "widgetParametersMapping" => []
            ],
            [
                "service" => "comitium5_common_widgets_self_call",
                "ajaxEntryPoint" => "resolveAjaxAction",
                "widgetClass" => 'dummy_widget_class',
                "widgetParameters" => null,
                "widgetParametersMapping" => []
            ],
            [
                "service" => "comitium5_common_widgets_self_call",
                "ajaxEntryPoint" => "resolveAjaxAction",
                "widgetClass" => "dummy_widget_class",
                "widgetParameters" => [EntityConstants::ID_FIELD_KEY => 1],
                "widgetParametersMapping" => null
            ],
        ];
    }

    /**
     * @dataProvider validateThrowsException
     *
     * @param $service
     * @param $ajaxEntryPoint
     * @param $widgetClass
     * @param $widgetParameters
     * @param $widgetParametersMapping
     *
     * @return void
     * @throws Exception
     */
    public function testValidateThrowsException(
        $service,
        $ajaxEntryPoint,
        $widgetClass,
        $widgetParameters,
        $widgetParametersMapping
    )
    {
        $this->expectException(Exception::class);

        $valueObject = new AjaxRequestValueObject($service, $ajaxEntryPoint, $widgetClass, $widgetParameters, $widgetParametersMapping);
        $valueObject->validate();
    }

    /**
     * @return array[]
     */
    public function validateThrowsException(): array
    {
        return [
            [
                "service" => "",
                "ajaxEntryPoint" => "resolveAjaxAction",
                "widgetClass" => "dummy_widget_class",
                "widgetParameters" => [EntityConstants::ID_FIELD_KEY => 1],
                "widgetParametersMapping" => []
            ],
            [
                "service" => "comitium5_common_widgets_self_call",
                "ajaxEntryPoint" => "",
                "widgetClass" => "dummy_widget_class",
                "widgetParameters" => [EntityConstants::ID_FIELD_KEY => 1],
                "widgetParametersMapping" => []
            ],
            [
                "service" => "comitium5_common_widgets_self_call",
                "ajaxEntryPoint" => "resolveAjaxAction",
                "widgetClass" => "",
                "widgetParameters" => [EntityConstants::ID_FIELD_KEY => 1],
                "widgetParametersMapping" => []
            ],
            [
                "service" => "comitium5_common_widgets_self_call",
                "ajaxEntryPoint" => "resolveAjaxAction",
                "widgetClass" => "dummy_widget_class",
                "widgetParameters" => [],
                "widgetParametersMapping" => []
            ],
        ];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidate()
    {
        $result = $this->ajaxRequestValueObject->validate();
        $this->assertTrue($result);
    }

    /**
     * @return void
     */
    public function testGetService()
    {
        $result = $this->ajaxRequestValueObject->getService();

        $this->assertEquals("comitium5_common_widgets_self_call", $result);
    }

    /**
     * @return void
     */
    public function testGetAjaxEntryPoint()
    {
        $result = $this->ajaxRequestValueObject->getAjaxEntryPoint();

        $this->assertEquals("resolveAjaxAction", $result);
    }

    /**
     * @return void
     */
    public function testGetWidgetClass()
    {
        $result = $this->ajaxRequestValueObject->getWidgetClass();

        $this->assertEquals("dummy_widget_class", $result);
    }

    /**
     * @return void
     */
    public function testGetWidgetParameters()
    {
        $result = $this->ajaxRequestValueObject->getWidgetParameters();

        $this->assertEquals([EntityConstants::ID_FIELD_KEY => 1], $result);
    }

    /**
     * @return void
     */
    public function testGetWidgetParametersMapping()
    {
        $result = $this->ajaxRequestValueObject->getWidgetParametersMapping();

        $this->assertEquals([], $result);
    }
}