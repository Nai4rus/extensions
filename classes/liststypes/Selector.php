<?php


namespace Nai4rus\Extensions\Classes\ListsTypes;


class Selector
{
    private $listType;
    private $listColumn;
    private $options = [];
    private $methodPrefix = 'get';
    private $methodPostfix = 'Options';

    public function __construct(ListTypeInterface $listType)
    {
        $this->listType = $listType;
        $this->listColumn = $this->listType->getListColumn();
    }

    public function selector()
    {
        if (isset($this->listColumn->config['method'])) {
            return $this->returnSelectedByMethod();
        }

        return $this->returnSelectedByOptions();
    }


    private function returnSelectedByMethod()
    {
        $methodName = $this->makeOptionsMethod($this->listColumn->columnName);

        $this->setupOptionsByMethod($methodName);

        return $this->returnSelectedOption();
    }


    private function returnSelectedByOptions()
    {
        if (isset($this->listColumn->config['options'])) {
            $this->options = $this->listColumn->config['options'];
        }

        return $this->returnSelectedOption();
    }


    private function makeOptionsMethod($name)
    {
        $name = ucfirst(camel_case($name));
        return $this->methodPrefix . $name . $this->methodPostfix;
    }


    private function setupOptionsByMethod($methodName)
    {
        $model = $this->listType->getModel();
        if (method_exists($model, $methodName)) {
            $this->options = $model->$methodName();
        }
    }

    private function returnSelectedOption()
    {
        $selectedValue = $this->listType->getSelectedValue();

        if (isset($this->options[$selectedValue])) {
            return $this->options[$selectedValue];
        }

        return $selectedValue;
    }
}
