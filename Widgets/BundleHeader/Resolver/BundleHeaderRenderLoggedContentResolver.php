<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Resolver;

use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Helper\BundleHeaderRenderLoggedContentHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces\BundleHeaderRenderLoggedContentValueObjectInterface;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\ValueObject\BundleHeaderRenderLoggedContentValueObject;
use Exception;

/**
 * Class BundleHeaderRenderLoggedContentResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Resolver
 */
class BundleHeaderRenderLoggedContentResolver
{
    /**
     * @var BundleHeaderRenderLoggedContentValueObject
     */
    private $valueObject;

    /**
     * @var BundleHeaderRenderLoggedContentHelper
     */
    private $helper;

    /**
     * @param BundleHeaderRenderLoggedContentValueObjectInterface $valueObject
     */
    public function __construct(BundleHeaderRenderLoggedContentValueObjectInterface $valueObject)
    {
        $this->valueObject = $valueObject;
        $this->helper = new BundleHeaderRenderLoggedContentHelper($valueObject);
    }

    /**
     * @return array
     * @throws Exception
     */
    public function resolve(): array
    {
        $accountPage = $this->resolveAccountPage();
        $userName = $this->resolveUserName();
        $userFirstLetter = $this->resolveUserFirstLetter($userName);

        return [
            "accountPage" => $accountPage,
            "userName" => $userName,
            "userFirstLetter" => $userFirstLetter,
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    private function resolveAccountPage(): array
    {
        $page = [];

        $pageId = $this->valueObject->getAccountPageId();
        if (!empty($pageId)) {
            $page = $this->helper->getPage($pageId);
        }

        return $page;
    }

    /**
     * @return string
     */
    private function resolveUserName(): string
    {
        $userData = $this->valueObject->getUserData();

        return (empty($userData['fullName'])) ? "" : $userData['fullName'];
    }

    /**
     * @param string $userName
     *
     * @return string
     */
    private function resolveUserFirstLetter(string $userName): string
    {
        $userFirstLetter = substr($userName, 0, 1);

        return ($userFirstLetter === false) ? "" : $userFirstLetter;
    }
}