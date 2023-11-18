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
        array $widgetParameters,
        array $widgetParametersMapping
    )
    {
        $this->service = $service;
        $this->ajaxEntryPoint = $ajaxEntryPoint;
        $this->widgetClass = $widgetClass;
        $this->widgetParameters = $widgetParameters;
        $this->widgetParametersMapping = $widgetParametersMapping;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function validate()
    {
        if (empty($this->service)) {
            throw new Exception(__METHOD__.": comitium service can't be empty");
        }

        if (empty($this->ajaxEntryPoint)) {
            throw new Exception(__METHOD__.": ajax entry point can't be empty");
        }

        if (empty($this->widgetClass)) {
            throw new Exception(__METHOD__.": widget class can't be empty");
        }

        if (empty($this->widgetParameters)) {
            throw new Exception(__METHOD__.": widget parameters can't be empty");
        }
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }

    /**
     * @param string $service
     *
     * @return void
     */
    public function setService(string $service): void
    {
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getAjaxEntryPoint(): string
    {
        return $this->ajaxEntryPoint;
    }

    /**
     * @param string $ajaxEntryPoint
     *
     * @return void
     */
    public function setAjaxEntryPoint(string $ajaxEntryPoint): void
    {
        $this->ajaxEntryPoint = $ajaxEntryPoint;
    }

    /**
     * @return string
     */
    public function getWidgetClass(): string
    {
        return $this->widgetClass;
    }

    /**
     * @param string $widgetClass
     *
     * @return void
     */
    public function setWidgetClass(string $widgetClass): void
    {
        $this->widgetClass = $widgetClass;
    }

    /**
     * @return array
     */
    public function getWidgetParameters(): array
    {
        return $this->widgetParameters;
    }

    /**
     * @param array $widgetParameters
     *
     * @return void
     */
    public function setWidgetParameters(array $widgetParameters): void
    {
        $this->widgetParameters = $widgetParameters;
    }

    /**
     * @return array
     */
    public function getWidgetParametersMapping(): array
    {
        return $this->widgetParametersMapping;
    }

    /**
     * @param array $widgetParametersMapping
     *
     * @return void
     */
    public function setWidgetParametersMapping(array $widgetParametersMapping): void
    {
        $this->widgetParametersMapping = $widgetParametersMapping;
    }
}