<?php

namespace Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Helper;

use Comitium5\MercuriumWidgetsBundle\Helpers\WidgetHelper;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Interfaces\BundleHeaderValueObjectInterface;
use Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\ValueObject\BundleHeaderValueObject;

/**
 * Class BundleHeaderHelper
 *
 * @package Comitium5\MercuriumWidgetsBundle\Widgets\BundleHeader\Helper
 */
class BundleHeaderHelper extends WidgetHelper
{
    /**
     * @var BundleHeaderValueObject
     */
    private $valueObject;

    /**
     * @param BundleHeaderValueObject $valueObject
     */
    public function __construct(BundleHeaderValueObjectInterface $valueObject)
    {
        $this->valueObject = $valueObject;
        $api = $this->valueObject->getApi();
        parent::__construct($api);
    }
}