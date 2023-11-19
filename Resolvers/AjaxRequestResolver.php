<?php

namespace Comitium5\MercuriumWidgetsBundle\Resolvers;

use Comitium5\MercuriumWidgetsBundle\Services\Security\DataEncryption;
use Comitium5\MercuriumWidgetsBundle\ValueObjects\AjaxRequestValueObject;
use Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AjaxRequestResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Resolvers
 */
class AjaxRequestResolver
{
    /**
     * @param AjaxRequestValueObject $valueObject
     * @param string $method
     * @param array $extraParameters
     *
     * @return string
     * @throws Exception
     */
    public function resolveEncodedParameters(AjaxRequestValueObject $valueObject, string $method, array $extraParameters): string
    {
        $widgetParameters = $valueObject->getWidgetParameters();

        $widgetParameters = $this->unsetNotNecessaryValues($widgetParameters);

        $widgetParameters = $this->addCallParameters($widgetParameters, $method, $extraParameters);

        $parametersMapping = $this->updateGenerateCallMapping($valueObject);

        $shortenedParameters = $this->shortenParameters($widgetParameters, $parametersMapping);

        $jsonParameters = json_encode($shortenedParameters);

        $encryptor = new DataEncryption($jsonParameters);

        return $encryptor->encrypt();
    }

    /**
     * @param array $widgetParameters
     *
     * @return array
     */
    private function unsetNotNecessaryValues(array $widgetParameters): array
    {
        unset($widgetParameters['_site']);
        unset($widgetParameters['_fields']);
        unset($widgetParameters['_editor']);
        unset($widgetParameters['_parameters']['webpack']);
        unset($widgetParameters['pepito']);

        return $widgetParameters;
    }

    /**
     * @param array $widgetParameters
     * @param string $method
     * @param array $callParameters
     *
     * @return array
     */
    private function addCallParameters(array $widgetParameters, string $method, array $callParameters): array
    {
        $widgetParameters['_parameters']['_method']['value'] = $method;
        $widgetParameters['_parameters']['_extraParameters']['value'] = $callParameters;

        return $widgetParameters;
    }

    /**
     * @param AjaxRequestValueObject $ajaxRequestValueObject
     *
     * @return array
     */
    private function updateGenerateCallMapping(AjaxRequestValueObject $ajaxRequestValueObject): array
    {
        $extraValues = [
            "_method" => "r1",
            "_extraParameters" => "r2"
        ];

        $mapping = $ajaxRequestValueObject->getWidgetParametersMapping();
        return array_merge($mapping, $extraValues);
    }

    /**
     * @param array $widgetParameters
     * @param array $parametersMapping
     *
     * @return array
     */
    private function shortenParameters(array $widgetParameters, array $parametersMapping): array
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
     * @param Request $request
     * @param array $mapping
     *
     * @return array
     * @throws Exception
     */
    public function resolveDecodedParameters(Request $request, array $mapping): array
    {
        $parameters = $request->get('_parameters');
        if (empty($parameters)) {
            throw new Exception(__METHOD__ . ": parameters can't be empty");
        }

        $mapping = $this->updateResolveCallMapping($mapping);

        $parameters = $this->decodeParameters($parameters);

        $parameters['_editor'] = false;

        return $this->lengthenParameters($parameters, $mapping);
    }

    /**
     * @param array $mapping
     *
     * @return array
     */
    private function updateResolveCallMapping(array $mapping): array
    {
        return array_merge(
            $mapping,
            [
                "r1" => "_method",
                "r2" => "_extraParameters",
            ]
        );
    }

    /**
     * @param string $parameters
     *
     * @return mixed
     * @throws Exception
     */
    private function decodeParameters(string $parameters)
    {
        $encryptor = new DataEncryption($parameters);
        $parameters = $encryptor->decrypt();

        return json_decode($parameters, true);
    }

    /**
     * @param array $parameters
     * @param array $mapping
     *
     * @return array
     */
    private function lengthenParameters(array $parameters, array $mapping): array
    {
        if (empty($mapping)) {
            return $parameters;
        }

        foreach ($parameters['_parameters'] as $key => $value) {
            if (!empty($mapping[$key])) {
                $parameters['_parameters'][$mapping[$key]]['value'] = $value;
                unset($parameters['_parameters'][$key]);
            }
        }

        return $parameters;
    }
}