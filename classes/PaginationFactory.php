<?php


namespace Nai4rus\Extensions\Classes;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;
use Nai4rus\Extensions\Classes\Pagination\ContentInfo;
use Nai4rus\Extensions\Classes\Pagination\ControlInfo;
use Nai4rus\Extensions\Classes\Pagination\Paginator;

class PaginationFactory
{
    private const BLACKLIST_PARAMS = [
        'content_info',
        'control_info',
    ];

    private $content_info;
    private $control_info;
    private $handler;
    private $remote_form_selector;
    private $items_collection;


    public function __construct(LengthAwarePaginator $items_collection, ContentInfo $content, ControlInfo $control)
    {
        $this->items_collection = $items_collection;
        $this->content_info = $content;
        $this->control_info = $control;
    }


    public function generate(string $handler_method)
    {
        $this->handler = $handler_method;

        if (Request::ajax()) {
            return $this->generatePagination()->toAjax();
        }

        return $this->generatePagination();
    }


    public function getRemoteFormSelector()
    {
        return $this->remote_form_selector;
    }


    public function setRemoteFormSelector($remote_form_selector): self
    {
        $this->remote_form_selector = $remote_form_selector;
        return $this;
    }


    public function getItemsCollection(): LengthAwarePaginator
    {
        return $this->items_collection;
    }


    public function getContentInfo(): ContentInfo
    {
        return $this->content_info;
    }


    public function getControlInfo(): ControlInfo
    {
        return $this->control_info;
    }


    public function toArray(): array
    {
        $vars = get_object_vars($this);

        return array_filter($vars, function ($k) {
            return !in_array($k, self::BLACKLIST_PARAMS, true);
        }, ARRAY_FILTER_USE_KEY);
    }


    private function generatePagination(): Paginator
    {
        return new Paginator($this);
    }

}