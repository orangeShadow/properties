<?php namespace orangeShadow\properties\Model\PropertyTypes;

use orangeShadow\properties\Model\PropertyValue;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/**
 * Class DateProperty
 * @type date
 * @package orangeShadow\properties\Model\PropertyTypes
 */
class DateProperty extends PropertyValue
{

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
        $this->rules[] = 'date';
    }

    public function getValueAttribute()
    {
        if($this->getMultiple()) {
            $array = json_decode($this->attributes['value']);
            return array_map(function($e){
                return Carbon::parse($e);
            }, $array);
        } else {
            return  Carbon::parse($this->attributes['value']);
        }
    }
}