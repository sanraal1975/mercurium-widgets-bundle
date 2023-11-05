<?php

namespace Comitium5\MercuriumWidgetsBundle\Resolvers;

use Symfony\Bundle\TwigBundle\TwigEngine;

/**
 * Class TwigResolver
 *
 * @package Comitium5\MercuriumWidgetsBundle\Resolvers
 */
class TwigResolver
{
    /**
     * @var TwigEngine
     */
    private $twigEngine;

    /**
     * @param TwigEngine $twigEngine
     */
    public function __construct(TwigEngine $twigEngine)
    {
        $this->twigEngine = $twigEngine;
    }

    /**
     * @param string $twigFile
     * @param string $search
     * @param array $replaces
     *
     * @return array|string|string[]
     */
    public function resolve(string $twigFile, string $search, array $replaces)
    {
        if (empty($twigFile)) {
            return "";
        }

        if (empty($search)) {
            return "";
        }

        if (!empty($replaces)) {
            foreach ($replaces as $replace) {
                $view = $twigFile;
                $view = str_replace($search, $replace, $view);
                if ($this->twigEngine->exists($view)) {
                    return $view;
                }
            }
        }

        $defaultView = $twigFile;
        $defaultView = str_replace($search, "default", $defaultView);

        return ($this->twigEngine->exists($defaultView)) ? $defaultView : "";
    }
}