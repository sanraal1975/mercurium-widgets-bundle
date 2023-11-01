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
    private $ajaxAction;

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
    private $callParameters;

    /**
     * @var array
     */
    private $widgetParametersMapping;

    /**
     * @param string $service
     * @param string $ajaxEntryPoint
     * @param string $ajaxAction
     * @param string $widgetClass
     * @param array $widgetParameters
     * @param array $callParameters
     * @param array $widgetParametersMapping
     * @throws Exception
     */
    public function __construct(
        string $service,
        string $ajaxEntryPoint,
        string $ajaxAction,
        string $widgetClass,
        array  $widgetParameters,
        array  $callParameters,
        array  $widgetParametersMapping
    )
    {
        $this->service = $service;
        $this->ajaxEntryPoint = $ajaxEntryPoint;
        $this->ajaxAction = $ajaxAction;
        $this->widgetClass = $widgetClass;
        $this->widgetParameters = $widgetParameters;
        $this->callParameters = $callParameters;
        $this->widgetParametersMapping = $widgetParametersMapping;

        $this->validate();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function validate()
    {
        if(empty($this->service)) {
            throw new Exception(__METHOD__ . ": service can't be empty");
        }

        if(empty($this->ajaxEntryPoint)) {
            throw new Exception(__METHOD__ . ": ajax entry point can't be empty");
        }

        if(empty($this->ajaxAction)) {
            throw new Exception(__METHOD__ . ": ajax action can't be empty");
        }

        if(empty($this->widgetClass)) {
            throw new Exception(__METHOD__ . ": widget class can't be empty");
        }

        if(empty($this->widgetParameters)) {
            throw new Exception(__METHOD__ . ": widget parameters can't be empty");
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
     * @return string
     */
    public function getAjaxEntryPoint(): string
    {
        return $this->ajaxEntryPoint;
    }

    /**
     * @return string
     */
    public function getAjaxAction(): string
    {
        return $this->ajaxAction;
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
    public function getCallParameters(): array
    {
        return $this->callParameters;
    }

    /**
     * @return array
     */
    public function getWidgetParametersMapping(): array
    {
        return $this->widgetParametersMapping;
    }
}