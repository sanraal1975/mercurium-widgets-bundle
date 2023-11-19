<?php

namespace Comitium5\MercuriumWidgetsBundle\ValueObjects;

use Exception;

/**
 * Class AjaxRequestValueObject
 *
 * @package ComitiumSuite\Bundle\CSBundle\Widgets\Core\ValueObjects
 */
class AjaxRequestValueObject
{
    /**
     * @var string
     */
    private $service;

    /**
     * @var string
     */
    private $ajaxEntryPoint;

    /**
     * @var string
     */
    private $widgetClass;

    /**
     * @var array
     */
    private $widgetParameters;

    /**
     * @var array
     */
    private $widgetParametersMapping;

    /**
     * @param string $service
     * @param string $ajaxEntryPoint
     * @param string $widgetClass
     * @param array $widgetParameters
     * @param array $widgetParametersMapping
     */
    public function __construct(
        string $service,
        string $ajaxEntryPoint,
        string $widgetClass,
        array  $widgetParameters,
        array  $widgetParametersMapping
    )
    {
        $this->service = $service;
        $this->ajaxEntryPoint = $ajaxEntryPoint;
        $this->widgetClass = $widgetClass;
        $this->widgetParameters = $widgetParameters;
        $this->widgetParametersMapping = $widgetParametersMapping;
    }

    /**
     * @return true
     * @throws Exception
     */
    public function validate(): bool
    {
        if (empty($this->service)) {
            throw new Exception(__METHOD__ . ": comitium service can't be empty");
        }

        if (empty($this->ajaxEntryPoint)) {
            throw new Exception(__METHOD__ . ": ajax entry point can't be empty");
        }

        if (empty($this->widgetClass)) {
            throw new Exception(__METHOD__ . ": widget class can't be empty");
        }

        if (empty($this->widgetParameters)) {
            throw new Exception(__METHOD__ . ": widget parameters can't be empty");
        }

        return true;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @return string
     */
    public function getAjaxEntryPoint(): string
    {
        return $this->ajaxEntryPoint;
    }

    /**
     * @return string
     */
    public function getWidgetClass(): string
    {
        return $this->widgetClass;
    }

    /**
     * @return array
     */
    public function getWidgetParameters(): array
    {
        return $this->widgetParameters;
    }

    /**
     * @return array
     */
    public function getWidgetParametersMapping(): array
    {
        return $this->widgetParametersMapping;
    }
}