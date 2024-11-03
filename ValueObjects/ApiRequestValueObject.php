<?php

namespace Comitium5\MercuriumWidgetsBundle\ValueObjects;

use Exception;

/**
 * Class ApiRequestValueObject
 *
 * @package Comitium5\MercuriumWidgetsBundle\ValueObjects
 */
class ApiRequestValueObject
{
    const DEFAULT_LIMIT = 10;

    const DEFAULT_ORDER = "publishedAt desc";

    const DEFAULT_PAGE = 1;

    /**
     * @var string
     */
    private $authors;

    /**
     * @var string
     */
    private $categories;

    /**
     * @var string
     */
    private $deniedCategories;

    /**
     * @var string
     */
    private $excludeIds;

    /**
     * @var string
     */
    private $includeIds;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var string
     */
    private $order;

    /**
     * @var int
     */
    private $page;

    /**
     * @var string
     */
    private $tags;

    /**
     * @var array
     */
    private $extraParameters;

    /**
     * @param string $authors
     * @param string $categories
     * @param string $deniedCategories
     * @param string $excludeIds
     * @param string $includeIds
     * @param int $limit
     * @param string $order
     * @param int $page
     * @param string $tags
     * @param array $extraParameters
     * @throws Exception
     */
    public function __construct(
        string $authors = "",
        string $categories = "",
        string $deniedCategories = "",
        string $excludeIds = "",
        string $includeIds = "",
        string $tags = "",
        array  $extraParameters = [],
        int    $limit = self::DEFAULT_LIMIT,
        string $order = self::DEFAULT_ORDER,
        int    $page = self::DEFAULT_PAGE
    )
    {
        $this->authors = $authors;
        $this->categories = $categories;
        $this->deniedCategories = $deniedCategories;
        $this->excludeIds = $excludeIds;
        $this->includeIds = $includeIds;
        $this->limit = $limit;
        $this->order = $order;
        $this->page = $page;
        $this->tags = $tags;
        $this->extraParameters = $extraParameters;

        $this->validate();
    }

    /**
     * @return void
     * @throws Exception
     */
    private function validate()
    {
        $limit = $this->getLimit();
        if ($limit < 1) {
            throw new Exception("ApiRequestValueObject:validate. Quantity must be greater than 0");
        }

        $order = $this->getOrder();
        if (empty($order)) {
            throw new Exception("ApiRequestValueObject:validate. Order can not be empty");
        }

        $page = $this->getPage();
        if ($page < 1) {
            throw new Exception("ApiRequestValueObject:validate. Page must be greater than 0");
        }
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        $parameters = [];

        $authors = $this->getAuthors();
        if (!empty($authors)) {
            $parameters['authors'] = $authors;
        }

        $categories = $this->getCategories();
        if (!empty($categories)) {
            $parameters['categories'] = $categories;
        }

        $deniedCategories = $this->getDeniedCategories();
        if (!empty($deniedCategories)) {
            $parameters['exclude_categories'] = $deniedCategories;
        }

        $deniedArticles = $this->getExcludeIds();
        if (!empty($deniedArticles)) {
            $parameters['exclude_ids'] = $deniedArticles;
        }

        $includedArticles = $this->getIncludeIds();
        if (!empty($includedArticles)) {
            $parameters['include_ids'] = $includedArticles;
        }

        $limit = $this->getLimit();
        if ($limit < 1) {
            $limit = self::DEFAULT_LIMIT;
        }
        $parameters['limit'] = $limit;

        $order = $this->getOrder();
        if (empty($order)) {
            $order = self::DEFAULT_ORDER;
        }
        $parameters['order'] = $order;

        $page = $this->getLimit();
        if ($page < 1) {
            $page = self::DEFAULT_PAGE;
        }
        $parameters['page'] = $page;

        $tags = $this->getTags();
        if (!empty($tags)) {
            $parameters['tags'] = $tags;
        }

        $extraParameters = $this->getExtraParameters();
        if (!empty($extraParameters)) {
            foreach ($extraParameters as $key => $value) {
                $parameters[$key] = $value;
            }
        }

        return $parameters;
    }

    /**
     * @return string
     */
    private function getAuthors(): string
    {
        return $this->authors;
    }

    /**
     * @return string
     */
    private function getCategories(): string
    {
        return $this->categories;
    }

    /**
     * @return string
     */
    private function getDeniedCategories(): string
    {
        return $this->deniedCategories;
    }

    /**
     * @return string
     */
    private function getExcludeIds(): string
    {
        return $this->excludeIds;
    }

    /**
     * @return string
     */
    public function getIncludeIds(): string
    {
        return $this->includeIds;
    }

    /**
     * @return int
     */
    private function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return string
     */
    private function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @return int
     */
    private function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return string
     */
    private function getTags(): string
    {
        return $this->tags;
    }

    /**
     * @return array
     */
    private function getExtraParameters(): array
    {
        return $this->extraParameters;
    }

    /**
     * @param string $authors
     *
     * @return void
     */
    public function setAuthors(string $authors): void
    {
        $this->authors = $authors;
    }

    /**
     * @param string $categories
     *
     * @return void
     */
    public function setCategories(string $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @param string $deniedCategories
     *
     * @return void
     */
    public function setDeniedCategories(string $deniedCategories): void
    {
        $this->deniedCategories = $deniedCategories;
    }

    /**
     * @param string $excludeIds
     *
     * @return void
     */
    public function setExcludeIds(string $excludeIds): void
    {
        $this->excludeIds = $excludeIds;
    }

    /**
     * @param string $includeIds
     *
     * @return void
     */
    public function setIncludeIds(string $includeIds): void
    {
        $this->includeIds = $includeIds;
    }

    /**
     * @param int $limit
     *
     * @return void
     * @throws Exception
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
        $this->validate();
    }

    /**
     * @param string $order
     *
     * @return void
     * @throws Exception
     */
    public function setOrder(string $order): void
    {
        $this->order = $order;
        $this->validate();
    }

    /**
     * @param int $page
     *
     * @return void
     * @throws Exception
     */
    public function setPage(int $page): void
    {
        $this->page = $page;
        $this->validate();
    }

    /**
     * @param string $tags
     *
     * @return void
     */
    public function setTags(string $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @param array $extraParameters
     *
     * @return void
     */
    public function setExtraParameters(array $extraParameters): void
    {
        $this->extraParameters = $extraParameters;
    }
}