<?php

/**
 * @category DMC
 * @package DMC_Composition
 * @copyright Copyright (c) 2018 digital.manufaktur GmbH
 * @license https://opensource.org/licenses/OSL-3.0 Open Software License ("OSL") v. 3.0
 * @author digital.manufaktur GmbH
 * @link https://www.digitalmanufaktur.com/
 */

namespace DMC\Composition;

use Magento\Framework\App\ObjectManager;
use ReflectionException;

trait Composite
{
    
    /**
     * Composition cache
     *
     * @var array
     */
    private $compositionCache = [];
    
    /**
     * Get composition property
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        $result = null;
        $cache =& $this->compositionCache;
        $objectManager = ObjectManager::getInstance();
        while ($result === null) {
            if (isset($class)) {
                $class = get_parent_class($class);
                if (!$class) {
                    break;
                }
            } else {
                if (method_exists($this, '_get')) {
                    $result = $this->_get($property);
                    if ($result !== null) {
                        break;
                    }
                }
                $class = __CLASS__;
            }
            $compositeClass = $class . 'Composition';
            if (!isset($cache[$compositeClass])) {
                try {
                    $cache[$compositeClass] = $objectManager->get(
                        $compositeClass
                    );
                } catch (ReflectionException $e) {
                }
            }
            if (isset($cache[$compositeClass])) {
                $compositeClass = $cache[$compositeClass];
                if (method_exists($compositeClass, __FUNCTION__)) {
                    $result = $compositeClass->{$property};
                }
            }
        }
        return $result;
    }
    
}
