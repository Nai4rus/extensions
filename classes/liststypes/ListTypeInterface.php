<?php


namespace Nai4rus\Extensions\Classes\ListsTypes;


interface ListTypeInterface
{
    public function getSelectedValue();
    public function getListColumn();
    public function getModel();
}
