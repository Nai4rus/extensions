<?php


namespace Nai4rus\Extensions\Classes\ListsTypes;


use Backend\Classes\Controller;
use Backend\Widgets\Lists;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use October\Rain\Exception\ApplicationException;
use October\Rain\Support\Facades\Flash;

class Switcher
{
    private $listType;
    private $params = [];


    public function __construct(ListTypeInterface $listType)
    {
        $this->listType = $listType;
        $this->prepareParams();
    }


    public function render(): string
    {
        $this->addParam('checked', $this->listType->getValue());
        return View::make('nai4rus.extensions::listTypes.switcher', $this->params);
    }


    public function addParam($key, $value): void
    {
        $this->params[$key] = $value;
    }


    public static function implement(): void
    {
        Event::listen('backend.list.extendColumns', function (Lists $widget) {
            $widget->getController()->addJs('/plugins/nai4rus/extensions/assets/js/switcher.js');
            $widget->getController()->addCss('/plugins/nai4rus/extensions/assets/css/switcher.css');

            foreach ($widget->config->columns as $name => $config) {
                if (empty($config['type']) || $config['type'] !== 'slider') {
                    continue;
                }

                $config['clickable'] = false;

                $widget->addColumns([
                    $name => $config
                ]);
            }
        });

        Controller::extend(function (Controller $controller) {
            $controller->addDynamicMethod('onSwitchInList', function () {
                $data = post();
                $rules = [
                    'model.id' => 'required|integer',
                    'model.class' => 'required|string',
                    'model.name' => 'required|string',
                    'value' => 'required'
                ];
                Validator::validate($data, $rules);

                $id = $data['model']['id'];
                $class = $data['model']['class'];

                if (!class_exists($class)) {
                    throw new ApplicationException(Lang::get('backend::lang.model.not_found', [
                        'id' => $id,
                        'class' => $class
                    ]));
                }

                $class::where('id', $id)->update([
                    $data['model']['name'] => $data['value'] === 'true'
                ]);
            });
        });
    }


    private function prepareParams(): void
    {
        $config = $this->listType->getListColumn()->config;
        $fieldOn = Lang::get($config['options']['on'] ?? 'backend::lang.list.column_switch_true');
        $fieldOff = Lang::get($config['options']['off'] ?? 'backend::lang.list.column_switch_false');

        $model = $this->listType->getModel();
        $this->params = [
            'field_on' => mb_substr($fieldOn, 0, 4),
            'field_off' => mb_substr($fieldOff, 0, 4),
            'class' => get_class($model),
            'id' => $model->id,
            'name' => $this->listType->getListColumn()->columnName
        ];
    }
}