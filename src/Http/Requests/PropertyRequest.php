<?php namespace \orangeShadow\properties\Http\Requests;

use orangeShadow\properties\Model\Property;
use App\Http\Requests\Request;

class PropertyRequest extends Request
{

    public function authorize()
    {
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = array();
        foreach(Request::input('properties') as $key => $value) {
            $property =  Property::where('code',$key)->first();
            $class = 'orangeShadow\\properties\\Model\\PropertyTypes\\'.ucfirst($property->type)."Property";
            $p = new $class;
            $p->setPropertyParams($property->code, $property->title, $property->description, $property->sort, $property->multiple, $property->required, $property->defaultValues);
            $rules['properties.'.$key] =  implode("|", $p->getRules());
        }

        return $rules;
    }
}