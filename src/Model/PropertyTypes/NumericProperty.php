<?php namespace orangeShadow\properties\Model\PropertyTypes;

use orangeShadow\properties\Model\PropertyValue;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class NumericProperty
 * @package orangeShadow\properties\Model\PropertyTypes
 * @type numeric
 */
class NumericProperty extends PropertyValue
{

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->rules[] = 'numeric';
    }

}