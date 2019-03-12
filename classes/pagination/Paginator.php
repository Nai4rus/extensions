<?php

namespace Nai4rus\Extensions\Classes\Pagination;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class Paginator
{
    private const BLACKLIST_PARAMS = [
        'content_info',
        'control_info',
    ];

    private $content_info;
    private $control_info;
    private $handler;
    private $remote_form_selector;
    private $paginator_collection;


    public function __construct(LengthAwarePaginator $paginator_collection, ContentPaginationInfo $content, ControlPaginationInfo $control)
    {
        $this->paginator_collection = $paginator_collection;
        $this->content_info = $content;
        $this->control_info = $control;
    }


    public function generate(string $handler_method): array
    {
        $this->handler = $handler_method;

        if (Request::ajax()) {
            return $this->generateAjaxPagination();
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


    public function getPaginatorCollection(): LengthAwarePaginator
    {
        return $this->paginator_collection;
    }


    public function getContentInfo(): ContentPaginationInfo
    {
        return $this->content_info;
    }


    public function getControlInfo(): ControlPaginationInfo
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


    private function generatePagination(): array
    {
        $data = [
            'pagination_container' => $this->control_info->getContainerSelector(),
            'pagination_partial' => $this->control_info->addVars($this->toArray())->renderPartial(),
            'items_container' => $this->content_info->getContainerSelector(),
            'items' => $this->paginator_collection,
            'items_partial' => $this->content_info->addVars($this->toArray())->renderPartial(),
        ];

        return $data;
    }


    private function generateAjaxPagination(): array
    {
        $items_container = $this->content_info->getContainerSelector();
        $pagination_container = $this->control_info->getContainerSelector();

        $data = [
            $pagination_container => $this->control_info->addVars($this->toArray())->renderPartial(),
            'items' => $this->paginator_collection,
            $items_container => $this->content_info->addVars($this->toArray())->renderPartial()
        ];

        return $data;
    }


}