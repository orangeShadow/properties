<?php namespace orangeShadow\properties\Model;

use orangeShadow\properties\Model\PropertyTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;

class Property extends Model
{

    public $fillable = ["code", "model", "title", "description", "type", "sort", "multiple", "required", "rules", "default_values"];

    /**
     * Get Property related to Eloquent Model
     * @param $model Eloquent
     * @return array
     */
    public function getPropertyByModel($model)
    {
        $function = new \ReflectionClass($model);
        $className  = $function->getShortName();

        $list  = self::where('model', '=', $className)->orderBy('sort')->get();

        return $list;
    }

    /**
     * Set default Values from array to json
     * @param $value
     */
    public function setDefaultValuesAttribute($value)
    {
        $this->attributes['default_values']=json_encode($value);
    }

    /**
     *  Get default Values from json to array
     **/ 
    public function getAttributeDefaultValues()
    {
       return json_decode($this->attributes['default_values'],true);
    }


    /**
     * Get available type from annotations from class in PropertyTypes folder
     * @return array
     */
    public static function getAvailableTypeProperties()
    {
        //TODO: hard binding with a folder PropertyType. BAD!!!
        $types  = [];
        $path = __DIR__;
        $path.="/PropertyTypes";
        $allFiles = new \DirectoryIterator($path);
        $phpFiles = new \RegexIterator($allFiles, '/\.php$/');
        foreach ($phpFiles as $phpFile) {
            $r=new \ReflectionClass(__NAMESPACE__."\\PropertyTypes\\".substr($phpFile->getFilename(),0,strpos($phpFile->getFilename(),'.')));
            if(!empty($r)) {
                $doc = $r->getDocComment();

                preg_match_all('#@type (.*?)\n#is', $doc, $annotations);
                if(!empty($annotations[1])) {
                    $types[] = trim($annotations[1][0]);
                }
            }
        }

        return $types;
    }
}