<?php

namespace Comitium5\MercuriumWidgetsBundle\Controller;

use Comitium5\MercuriumWidgetsBundle\Services\Security\DataEncryption;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\AjaxRequestValueObject;
use ComitiumSuite\Bundle\CSBundle\Controller\Abstracts\AbstractWidgetController;
use Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AjaxController
 *
 * @package Comitium5\MercuriumWidgetsBundle\Controller
 */
class AjaxController
{
    /**
     * @param AjaxRequestValueObject $ajaxRequestValueObject
     *
     * @return string
     * @throws Exception
     */
    public function getAjaxCall(AjaxRequestValueObject $ajaxRequestValueObject): string
    {
        $widgetParameters = $ajaxRequestValueObject->getWidgetParameters();
        $widgetParameters = $this->unsetNotNecessaryValues($widgetParameters);
        $widgetParameters = $this->addCallParameters($ajaxRequestValueObject, $widgetParameters);

        $parametersMapping = $this->prepareMapping($ajaxRequestValueObject);

        $shortenedParameters = $this->shortenParameters($widgetParameters, $parametersMapping);

        $jsonParameters = json_encode($shortenedParameters);

        $encryptor = new DataEncryption($jsonParameters);
        $encodedParameters = $encryptor->encrypt();

        $service = $ajaxRequestValueObject->getService();

        $callParameters = [
            "controller" => $ajaxRequestValueObject->getWidgetClass(),
            "action" => $ajaxRequestValueObject->getAjaxEntryPoint(),
            "method" => $ajaxRequestValueObject->getAjaxAction(),
            "_parameters" => $encodedParameters
        ];

        $url = $this->generateUrl($service, $callParameters);

        return $url;
    }

    /**
     * @param array $widgetParameters
     *
     * @return array
     */
    private function unsetNotNecessaryValues(array $widgetParameters)
    {
        unset($widgetParameters['_site']);
        unset($widgetParameters['_fields']);
        unset($widgetParameters['_editor']);
        unset($widgetParameters['_parameters']['webpack']);

        return $widgetParameters;
    }

    /**
     * @param AjaxRequestValueObject $ajaxRequestValueObject
     * @param array $widgetParameters
     *
     * @return array
     */
    private function addCallParameters(AjaxRequestValueObject $ajaxRequestValueObject, array $widgetParameters)
    {
        $method = $ajaxRequestValueObject->getAjaxAction();
        $callParameters = $ajaxRequestValueObject->getCallParameters();

        $widgetParameters['_parameters']['_method']['value'] = $method;
        $widgetParameters['_parameters']['_extraParameters']['value'] = $callParameters;

        return $widgetParameters;
    }

    /**
     * @param $ajaxRequestValueObject
     *
     * @return mixed
     */
    private function prepareMapping($ajaxRequestValueObject)
    {
        $extraValues = [
            "_method" => "r1",
            "_extraParameters" => "r2"
        ];

        $mapping = $ajaxRequestValueObject->getWidgetParametersMapping();
        $mapping = array_merge($mapping, $extraValues);

        return $mapping;
    }

    /**
     * @param array $widgetParameters
     * @param array $parametersMapping
     *
     * @return array|void
     */
    private function shortenParameters(array $widgetParameters, array $parametersMapping)
    {
        if (empty($parametersMapping)) {
            return $widgetParameters;
        }

        foreach ($widgetParameters['_parameters'] as $key => $value) {
            if (!empty($parametersMapping[$key])) {
                $widgetParameters['_parameters'][$parametersMapping[$key]] = $value['value'];
            }
            unset($widgetParameters['_parameters'][$key]);
        }

        return $widgetParameters;
    }

    /**
     * @param array $parameters
     *
     * @return void
     */
    public function renderAction(array $parameters = [])
    {
        // TODO: Implement renderAction() method.
    }

}