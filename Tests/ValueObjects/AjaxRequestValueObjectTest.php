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
     * @return void
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
     * @param $ajaxAction
     * @param $widgetClass
     * @param $widgetParameters
     * @param $callParameters
     * @param $widgetParametersMapping
     *
     * @return void
     * @throws Exception
     */
    public function testConstructThrowsTypeErrorException(
        $service,
        $ajaxEntryPoint,
        $ajaxAction,
        $widgetClass,
        $widgetParameters,
        $callParameters,
        $widgetParametersMapping

    )
    {
        $this->expectException(TypeError::class);

        $valueObject = new AjaxRequestValueObject($service, $ajaxEntryPoint, $ajaxAction, $widgetClass, $widgetParameters, $callParameters, $widgetParametersMapping);
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
                "ajaxAction" => "",
                "widgetClass" => "",
                "widgetParameters" => [EntityConstants::ID_FIELD_KEY => 1],
                "callParameters" => [],
                "widgetParametersMapping" => []
            ],
            [
                "service" => "comitium5_common_widgets_self_call",
                "ajaxEntryPoint" => null,
                "ajaxAction" => "",
                "widgetClass" => "",
                "widgetParameters" => [EntityConstants::ID_FIELD_KEY => 1],
                "callParameters" => [],
                "widgetParametersMapping" => []
            ],
            [
                "service" => "comitium5_common_widgets_self_call",
                "ajaxEntryPoint" => "resolveAjaxAction",
                "ajaxAction" => null,
                "widgetClass" => "",
                "widgetParameters" => [EntityConstants::ID_FIELD_KEY => 1],
                "callParameters" => [],
                "widgetParametersMapping" => []
            ],
            [
                "service" => "comitium5_common_widgets_self_call",
                "ajaxEntryPoint" => "resolveAjaxAction",
                "ajaxAction" => "renderArticlesAction",
                "widgetClass" => null,
                "widgetParameters" => [EntityConstants::ID_FIELD_KEY => 1],
                "callParameters" => [],
                "widgetParametersMapping" => []
            ],
            [
                "service" => "comitium5_common_widgets_self_call",
                "ajaxEntryPoint" => "resolveAjaxAction",
                "ajaxAction" => "renderArticlesAction",
                "widgetClass" => "dummy_widget_class",
                "widgetParameters" => null,
                "callParameters" => [],
                "widgetParametersMapping" => []
            ]
        ];
    }


}