<?php namespace orangeShadow\properties;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use orangeShadow\properties\Model\Property;
use orangeShadow\properties\Model\PropertyTypes;

trait TraitProperty
{

    /**
     * Get Model property list without value
     *
     * @return mixed
     */
    public function getProperties()
    {
        $function = new \ReflectionClass($this);
        $className  = $function->getShortName();
        $list  = Property::where('model', '=', $className)->orderBy('sort')->get();

        return $list;
    }

    /**
     * Get Model property list with value
     *
     * @return array
     */
    public function getPropertiesValue()
    {
        $properties =  $this->getProperties();
        $propertyValues = new \Illuminate\Database\Eloquent\Collection;
        foreach($properties as $property) {
            $class = 'orangeShadow\\properties\\Model\\PropertyTypes\\'.ucfirst($property->type)."Property";
            $propertyValue = $class::where('property_id','=',$property->id)->where('element_id',"=",$this->getAttribute($this->getKeyName()))->first();

            if(!empty($propertyValue)) {
                $propertyValue->setPropertyParams($property->code, $property->title, $property->description, $property->sort, $property->multiple, $property->required, $property->defaultValues)
                    ->push($propertyValue);
                
            }
        }
        return $propertyValues;
    }

    /**
     * Get Model property list with value sorted by sort
     *
     * @return array
     */
    public function getPropertiesValueKeyByCode()
    {
        $properties =  $this->getProperties();
        $propertyValues = new \Illuminate\Database\Eloquent\Collection;
        foreach($properties as $property) {
            $class = 'orangeShadow\\properties\\Model\\PropertyTypes\\'.ucfirst($property->type)."Property";
            $propertyValue = $class::where('property_id', '=', $property->id)->where('element_id', "=", $this->getAttribute($this->getKeyName()))->first();

            if(!empty($propertyValue)) {
                $propertyValue->setPropertyParams($property->code, $property->title, $property->description, $property->sort, $property->multiple, $property->required, $property->defaultValues)
                    ->put($property->code, $propertyValue);

            }
        }
        return $propertyValues;
    }


    /**
     * Set property value by property code
     * @param $code
     * @param $value
     * @return $this
     */
    public function setPropertyValueByCode($code,$value)
    {
        $function = new \ReflectionClass($this);
        $className  = $function->getShortName();
        $property = Property::where('code', '=', $code)->where('model', '=', $className)->first();

        if(empty($property->id))
            throw new  ModelNotFoundException("Property Not  Found");
        
        $class = 'orangeShadow\\properties\\Model\\PropertyTypes\\'.ucfirst($property->type)."Property";
        $class::firstOrNew(['property_id'=>$property->id,'element_id'=>$this->getAttribute($this->getKeyName())])
            ->setPropertyParams($property->code, $property->title, $property->description, $property->sort, $property->multiple, $property->required, $property->defaultValues)
            ->setValueAttribute($value)
            ->save();

        return $this;
    }

    /**
     * Get property value by property code
     * @param $code
     * @return $propertyValue
     */
    public function getPropertyValueByCode($code)
    {
        $function = new \ReflectionClass($this);
        $className  = $function->getShortName();
        $property = Property::where('code','=',$code)->where('model','=',$className)->first();

        if(empty($property->id))
            throw new  ModelNotFoundException("Property Not  Found");
        
        $class = 'orangeShadow\\properties\\Model\\PropertyTypes\\'.ucfirst($property->type)."Property";

        return $class::find(['property_id'=>$property->id,'element_id'=>$this->getAttribute($this->getKeyName())])
                    ->first()
                    ->setPropertyParams($property->code, $property->title, $property->description, $property->sort, $property->multiple, $property->required, $property->defaultValues);
    }
}