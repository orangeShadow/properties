<?php namespace orangeShadow\properties\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Validation\ValidationException;
use Validator;

class PropertyValue extends Model
{
    protected $code = null;

    protected $title       = '';
    protected $description = '';

    protected $sort     = 0;
    protected $multiple = false;
    protected $required = false;

    protected $rules = [];
    /**
     * an array of property for multiple choice
     * @var null
     */
    protected $defaultValues = null;

    protected $validateRules = [];

    protected $table = 'property_values';

    public $fillable = ["property_id", "value", "element_id"];

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($value)
    {
        $this->code=$value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setSort($value)
    {
        $this->sort=$value;
    }

    public function getMultiple()
    {
        return $this->multiple;
    }

    public function setMultiple($value)
    {
        $this->multiple=$value;
    }


    public function getRequired()
    {
        return $this->required;
    }

    public function setRequired($value)
    {
        if($value) {
            $this->rules[] = 'required';
        }
        $this->required=$value;
    }


    public function getRules()
    {
        return $this->rules;
    }
    /**
     * Set property params
     * @param $code
     * @param $title
     * @param $description
     * @param $sort
     * @param $multiple
     * @param $required
     * @param $defaultValues
     *
     * @return $this
     */
    public function setPropertyParams($code, $title, $description, $sort=100, $multiple=false, $required=false, $defaultValues=null)
    {
        $this->code = $code;

        $this->title = $title;
        $this->description = $description;

        $this->setSort($sort);
        $this->setMultiple($multiple);
        $this->setRequired($required);

        $this->defaultValues=$defaultValues;
        return $this;
    }

    public function setValueAttribute($value)
    {
        if($this->getMultiple()) {
            foreach($value as $val) {
                $v = Validator::make(['value'=>$val], ['value'=>implode('|',$this->rules)]);
                if($v->fails()) {
                    throw new ValidationException($v);
                }
            }
            $this->attributes['value'] = json_encode($value);
        } else {
            $v = Validator::make(['value'=>$value], ['value'=>implode('|',$this->rules)]);
            if($v->fails()) {
                throw new ValidationException($v);
            }
            $this->attributes['value'] = $value;
        }

        return $this;
    }

    public function getValueAttribute()
    {
        if($this->getMultiple()) {
            return json_decode($this->attributes['value'], true);
        } else {
            return $this->attributes['value'];
        }
    }
}