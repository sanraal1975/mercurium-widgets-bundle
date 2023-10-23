<?php

namespace Comitium5\MercuriumWidgetsBundle\Factories;

use Comitium5\MercuriumWidgetsBundle\ValueObjects\AjaxRequestValueObject;
use Exception;

/**
 * Class AjaxRequestFactory
 *
 * @package Comitium5\MercuriumWidgetsBundle\Factories
 */
class AjaxRequestFactory
{
    /**
     * @param string $ajaxAction
     * @param string $widgetClass
     * @param array $widgetParameters
     * @param array $widgetParametersMapping
     * @param string $service
     * @param string $ajaxEntryPoint
     * @param array $callParameters
     *
     * @return AjaxRequestValueObject
     * @throws Exception
     */
    public function create(
        string $ajaxAction,
        string $widgetClass,
        array  $widgetParameters,
        array  $widgetParametersMapping = [],
        string $service = "comitium5_common_widgets_self_call",
        string $ajaxEntryPoint = "ajaxAction",
        array  $callParameters = []
    ): AjaxRequestValueObject
    {
        return new AjaxRequestValueObject(
            $service,
            $ajaxEntryPoint,
            $ajaxAction,
            $widgetClass,
            $widgetParameters,
            $callParameters,
            $widgetParametersMapping
        );
    }
}