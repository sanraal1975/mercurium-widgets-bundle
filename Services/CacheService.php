<?php

namespace Comitium5\MercuriumWidgetsBundle\Services;

/**
 * Class CacheService
 *
 * @package Comitium5\MercuriumWidgetsBundle\Services
 */
class CacheService
{
    /**
     * @var
     */
    private $redisService;

    /**
     * @var string
     */
    private $subSiteAcronym;

    /**
     * @param $redisService
     * @param string $subSiteAcronym
     */
    public function __construct($redisService, string $subSiteAcronym)
    {
        $this->redisService = $redisService;
        $this->subSiteAcronym = $subSiteAcronym;
    }

    /**
     * @param string $key
     * @param $value
     * @param int $ttl
     *
     * @return bool
     */
    public function set(string $key, $value, int $ttl): bool
    {
        $result = false;

        if (!empty($key)) {
            $redisKey = $this->buildKey($key);
            $result = $this->redisService->set($redisKey, $value, $ttl, $this->subSiteAcronym);
        }

        return $result;
    }

    /**
     * @param string $key
     *
     * @return mixed|string|null
     */
    public function get(string $key)
    {
        $result = "";

        if (!empty($key)) {
            $redisKey = $this->buildKey($key);
            $result = $this->redisService->get($redisKey, $this->subSiteAcronym);
        }

        return $result;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function delete(string $key): bool
    {
        $result = false;
        if (!empty($key)) {
            $redisKey = $this->buildKey($key);
            $result = $this->redisService->set($redisKey, "", 1);
        }
        return $result;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function buildKey(string $key): string
    {
        return sprintf(
            '__%s__%s',
            $this->subSiteAcronym,
            $key
        );
    }
}