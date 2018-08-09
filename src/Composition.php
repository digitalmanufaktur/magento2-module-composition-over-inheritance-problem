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

trait Composition
{
    
    /**
     * Get composition property
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property)
    {
        $result = null;
        if (__CLASS__ == debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1]['class'] . 'Composition') {
            $result = $this->{$property};
        }
        return $result;
    }
    
}
