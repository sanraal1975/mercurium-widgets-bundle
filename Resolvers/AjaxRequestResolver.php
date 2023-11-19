<?php

namespace Comitium5\MercuriumWidgetsBundle\Resolvers;

use Comitium5\MercuriumWidgetsBundle\Constants\AjaxRequestConstants;
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
        unset($widgetParameters[AjaxRequestConstants::SITE]);
        unset($widgetParameters[AjaxRequestConstants::FIELDS]);
        unset($widgetParameters[AjaxRequestConstants::EDITOR]);

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
        $widgetParameters[AjaxRequestConstants::PARAMETERS][AjaxRequestConstants::METHOD][AjaxRequestConstants::VALUE] = $method;
        $widgetParameters[AjaxRequestConstants::PARAMETERS][AjaxRequestConstants::EXTRA_PARAMETERS][AjaxRequestConstants::VALUE] = $callParameters;

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
            AjaxRequestConstants::METHOD => AjaxRequestConstants::MAPPING_FIRST_PARAMETER,
            AjaxRequestConstants::EXTRA_PARAMETERS => AjaxRequestConstants::MAPPING_SECOND_PARAMETER
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
        foreach ($widgetParameters[AjaxRequestConstants::PARAMETERS] as $key => $value) {
            if (!empty($parametersMapping[$key])) {
                $widgetParameters[AjaxRequestConstants::PARAMETERS][$parametersMapping[$key]] = $value[AjaxRequestConstants::VALUE];
            }
            unset($widgetParameters[AjaxRequestConstants::PARAMETERS][$key]);
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
        $parameters = $request->get(AjaxRequestConstants::PARAMETERS);
        if (empty($parameters)) {
            throw new Exception(__METHOD__ . ": parameters can't be empty");
        }

        $mapping = $this->updateResolveCallMapping($mapping);

        $parameters = $this->decodeParameters($parameters);

        $parameters[AjaxRequestConstants::EDITOR] = false;

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
                AjaxRequestConstants::MAPPING_FIRST_PARAMETER => AjaxRequestConstants::METHOD,
                AjaxRequestConstants::MAPPING_SECOND_PARAMETER => AjaxRequestConstants::EXTRA_PARAMETERS,
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
        foreach ($parameters[AjaxRequestConstants::PARAMETERS] as $key => $value) {
            if (!empty($mapping[$key])) {
                $parameters[AjaxRequestConstants::PARAMETERS][$mapping[$key]][AjaxRequestConstants::VALUE] = $value;
                unset($parameters[AjaxRequestConstants::PARAMETERS][$key]);
            }
        }

        return $parameters;
    }
}