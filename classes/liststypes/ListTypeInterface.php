<?php


namespace Nai4rus\Extensions\Classes\ListsTypes;


use Backend\Classes\ListColumn;

interface ListTypeInterface
{
    public function getValue();


    public function getListColumn(): ListColumn;


    public function getModel(): \Model;
}
