<?php

namespace Comitium5\MercuriumWidgetsBundle\Helpers\Entities;

use Comitium5\ApiClientBundle\Client\Client;
use Comitium5\ApiClientBundle\Client\Services\AbstractApiService;
use Comitium5\ApiClientBundle\Client\Services\ContactApiService;
use Comitium5\ApiClientBundle\ValueObject\ParametersValue;
use Comitium5\MercuriumWidgetsBundle\Abstracts\Helpers\AbstractEntityHelper;
use Comitium5\MercuriumWidgetsBundle\Factories\ApiServiceFactory;
use Comitium5\MercuriumWidgetsBundle\Helpers\ApiResultsHelper;
use Exception;

/**
 * Class ConactHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Helpers\Entities
 */
class ContactHelper extends AbstractEntityHelper
{
    const EMPTY_EMAIL = "ContactHelper::getByEmail. email can not be empty";

    /**
     * @var ContactApiService
     */
    private $service;

    /**
     * @param Client $api
     */
    public function __construct(Client $api)
    {
        $factory = new ApiServiceFactory($api);
        $this->service = $factory->createContactApiService();
    }

    /**
     * @return AbstractApiService
     */
    public function getService(): AbstractApiService
    {
        return $this->service;
    }

    /**
     * @param array $parameters
     *
     * @return array
     * @throws Exception
     */
    public function getBy(array $parameters = []): array
    {
        return $this->service->findBy(
            new ParametersValue($parameters)
        );
    }

    /**
     * @param string $email
     *
     * @return array
     * @throws Exception
     */
    public function getByEmail(string $email): array
    {
        if (empty($email)) {
            throw new Exception(self::EMPTY_EMAIL);
        }

        $contact = $this->getBy(['email' => $email]);

        return ApiResultsHelper::extractOne($contact);
    }

    /**
     * @param int $entityId
     *
     * @return array
     */
    public function get(int $entityId): array
    {
        // TODO: Implement get() method.
    }

    /**
     * @param string $entitiesIds
     *
     * @return array
     */
    public function getByIds(string $entitiesIds): array
    {
        // TODO: Implement getByIds() method.
    }

    /**
     * @param string $entitiesIds
     * @param int $quantityOfEntities
     *
     * @return array
     */
    public function getByIdsAndQuantity(string $entitiesIds, int $quantityOfEntities = PHP_INT_MAX): array
    {
        // TODO: Implement getByIdsAndQuantity() method.
    }

    /**
     * @return array
     */
    public function getLastPublished(): array
    {
        // TODO: Implement getLastPublished() method.
    }
}