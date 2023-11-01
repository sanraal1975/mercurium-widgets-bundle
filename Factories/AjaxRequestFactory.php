<?php

namespace Comitium5\MercuriumWidgetsBundle\Factories;

use Comitium5\MercuriumWidgetsBundle\ValueObjects\AjaxRequestValueObject;
use Exception;

/**
 * Class AjaxRequestFactory
 *
 * @package ComitiumSuite\Bundle\CSBundle\Widgets\Core\Factory
 */
class AjaxRequestFactory
{
    /**
     * @param string $ajaxAction
     * @param string $widgetClass
     * @param array $widgetParameters
     * @param array $widgetParametersMapping
     * @param array $callParameters
     * @param string $service
     * @param string $ajaxEntryPoint
     *
     * @return AjaxRequestValueObject
     * @throws Exception
     */
    public function create(
        string $ajaxAction,
        string $widgetClass,
        array  $widgetParameters,
        array  $widgetParametersMapping = [],
        array  $callParameters = [],
        string $service = "comitium5_common_widgets_self_call",
        string $ajaxEntryPoint = "resolveAjaxAction"
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