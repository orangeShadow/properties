# CustomModelProperties
[RU]
#Пакет для добавления произвольным моделям, произвольных свойств с Валидацией

Пример использотвания:
*Шаг 1: Создаем, (предполагается, что модель Page у нас есть)
```$property = melyfaro\CustomModelProperties\Model\Property::create(
				[
					"model"=>"Page",
					"code"=>"VIEWS",
					"title"=>"Кол-во просмотров",
					"description"=>"Счетчик просмотра страницы",
					"type"=>"numeric",
					"sort"=>"1",
					"multiple"=>false,
					"required"=>true
				]
		);
```
*Шаг 2: Добавялем к Моделе Page Trait
`use \melyfaro\CustomModelProperties\TraitProperty;`

*Шаг3: Можем задать по коду свойство или получить его 
```
$page = App\Page::find(1);
//Задать значение свойства по коду 
$page->setPropertyValueByCode('VIEWS',1);
//Получить значение свойства по коду
$page->getPropertyValueByCode('VIEWS');
```

##Вспомогательные методы TraitProperty:
>Получить весь список свойств текущей модели
`getProperties()`

>Получить весь список значений свойств текущей модели
`getPropertiesValue`

Если наследоваться от melyfaro\CustomModelProperties\Http\Requests 
```
public function rules()
{
  $rules = parent::relus();
  $rules+=[свои правила];
}
```
получим валидацию по параметрам properties.code