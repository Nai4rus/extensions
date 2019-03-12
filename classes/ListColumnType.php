<?php


namespace Nai4rus\Extensions\Classes;


use Nai4rus\Extensions\Classes\ListsTypes\ListTypeInterface;

class ListColumnType implements ListTypeInterface
{
    private $selectedValue;
    private $column;
    private $model;

    public function __construct($selectedValue, $column, $model = null)
    {
        $this->selectedValue = $selectedValue;
        $this->column = $column;
        $this->model = $model;
    }

    public function getListColumn()
    {
        return $this->column;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getSelectedValue()
    {
        return $this->selectedValue;
    }


}
