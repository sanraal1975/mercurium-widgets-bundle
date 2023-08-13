<?php

namespace Comitium5\MercuriumWidgetsBundle\ValueObjects;

/**
 * Class RichSnippetPublisherValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\ValueObjects
 */
class RichSnippetPublisherValueObject
{
    /**
     * @var string
     */
    private $subSiteName;

    /**
     * @var string
     */
    private $subSiteUrl;

    /**
     * @var array
     */
    private $logo;

    /**
     * @var string
     */
    private $schemaSocialNetworks;

    /**
     * @var array
     */
    private $projectSocialNetworks;

    /**
     * @param string $subSiteName
     * @param string $subSiteUrl
     * @param array $logo
     * @param string $schemaSocialNetworks
     * @param array $projectSocialNetworks
     */
    public function __construct(string $subSiteName, string $subSiteUrl, array $logo, string $schemaSocialNetworks, array $projectSocialNetworks)
    {
        $this->subSiteName = $subSiteName;
        $this->subSiteUrl = $subSiteUrl;
        $this->logo = $logo;
        $this->schemaSocialNetworks = $schemaSocialNetworks;
        $this->projectSocialNetworks = $projectSocialNetworks;
    }

    /**
     * @return string
     */
    public function getSubSiteName(): string
    {
        return $this->subSiteName;
    }

    /**
     * @return string
     */
    public function getSubSiteUrl(): string
    {
        return $this->subSiteUrl;
    }

    /**
     * @return array
     */
    public function getLogo(): array
    {
        return $this->logo;
    }

    /**
     * @return string
     */
    public function getSchemaSocialNetworks(): string
    {
        return $this->schemaSocialNetworks;
    }

    /**
     * @return array
     */
    public function getProjectSocialNetworks(): array
    {
        return $this->projectSocialNetworks;
    }
}