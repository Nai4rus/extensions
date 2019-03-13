<?php


namespace Nai4rus\Extensions\Classes;

use Model;
use Backend\Classes\ListColumn;
use Nai4rus\Extensions\Classes\ListsTypes\ListTypeInterface;

class ListColumnType implements ListTypeInterface
{
    private $value;
    private $column;
    private $model;


    public function __construct($value, ListColumn $column, Model $model = null)
    {
        $this->value = $value;
        $this->column = $column;
        $this->model = $model;
    }


    public function getListColumn(): ListColumn
    {
        return $this->column;
    }


    public function getModel(): Model
    {
        return $this->model;
    }


    public function getValue()
    {
        return $this->value;
    }


}
