<?php


namespace Nai4rus\Extensions\Classes\ListsTypes;


use October\Rain\Support\Facades\Str;

class StrWords
{
    private $listType;
    private $strLimit = 30;

    public function __construct(ListTypeInterface $listType)
    {
        $this->listType = $listType;
    }

    public function strWords()
    {
        $column = $this->listType->getListColumn();
        $selectedValue = $this->listType->getValue();

        $this->changeStrLimitByConfig($column->config);

        return Str::words($selectedValue, $this->strLimit);
    }

    private function changeStrLimitByConfig($config)
    {
        if (!empty($config['limit']) && is_int($config['limit'])) {
            $this->strLimit = $config['limit'];
        }
    }
}
