<?php namespace Nai4rus\Extensions\Components;

use Cms\Classes\ComponentBase;
use Cms\Classes\Page;
use Cms\Classes\Theme;

class Pages extends ComponentBase
{
    public function componentDetails(): array
    {
        return [
            'name' => 'All pages',
            'description' => 'Список всех страниц || All pages'
        ];
    }


    public function defineProperties(): array
    {
        return [];
    }


    public $pageList = [];


    public function onRun(): void
    {

        foreach (Page::getNameList() as $code => $name) {
            $this->pageList[$code] = [
                'name' => $name,
                'url' => Page::url($code),
                'path' => Theme::getActiveTheme()->getPath() . '/pages/' . $code . '.htm'
            ];
        }
    }
}
