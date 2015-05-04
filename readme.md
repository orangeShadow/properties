[RU]
#Пакет для добавления произвольным моделям, произвольных свойств с Валидацией

* Шаг 1: Подключаем сервис провайдер app/config/app.php
` 'orangeShadow\properties\PropertiesServiceProvider' `

* Шаг 2: Прогружаем миграции: 
` php artisan vendor:publish `, `php artisan migrate`

* Шаг 3: Создаем, (предполагается, что модель Page у нас есть)
```
$property = melyfaro\CustomModelProperties\Model\Property::create(
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
* Шаг 4: Добавялем к Моделе Page Trait
`use \melyfaro\CustomModelProperties\TraitProperty;`

* Шаг 5: Можем задать по коду свойство или получить его 
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
  return $rules;
}
```
получим валидацию по параметрам properties.code