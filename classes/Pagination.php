<?php

namespace Nai4rus\Extensions\Classes;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Request;

class Pagination
{
    private $page_number;
    private $pagination_container;
    private $items_container;
    private $handler_name;
    private $items_partial_name;
    private $component;
    private $pagination_partial_name;
    private $items;
    private $partial_params = [];
    private $pagination_params = [];
    private $form_selector;


    /**
     * Pagination constructor.
     * @param $component
     * @param $itemsPartialName
     * @param $handlerName
     * @param $paginationPartialName
     */
    public function __construct($component, $itemsPartialName, $handlerName, $paginationPartialName)
    {
        $this->component = $component;
        $this->items_partial_name = $itemsPartialName;
        $this->handler_name = $handlerName;
        $this->pagination_partial_name = $paginationPartialName;

        $this->page_number = post('page') ?: 1;
        $this->pagination_container = post('self') ?: '#paginate';
        $this->items_container = post('container') ?: '@#contentBox';
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @return array
     */
    public function generate(LengthAwarePaginator $paginator)
    {
        $this->items = $paginator;

        $this->generatePaginationPartialParams();

        $this->generateItemsPartialParams();

        if (Request::ajax()) {
            return $this->generateAjaxPagination();
        }

        return $this->generatePagination();
    }

    public function addPaginationPartialParams(array $params)
    {
        $this->pagination_params = array_merge($this->pagination_params, $params);
    }

    public function addItemsPartialParams(array $params)
    {
        $this->partial_params = array_merge($this->partial_params, $params);
    }

    public function changePaginationContainer(string $selector)
    {
        $this->pagination_container = $selector;
    }

    public function changeItemsContainer(string $selector)
    {
        $this->items_container = $selector;
    }

    public function setFormSelector(string $selector)
    {
        $this->form_selector = $selector;
    }

    private function generatePaginationPartialParams()
    {
        $this->pagination_params = array_merge($this->pagination_params, [
            'items' => $this->items,
            'handler' => $this->handler_name,
            'container' => $this->items_container,
            'selfContainer' => $this->pagination_container,
            'form' => $this->form_selector
        ]);
    }

    private function generateItemsPartialParams()
    {
        $this->partial_params = array_merge($this->partial_params, [
            'items' => $this->items
        ]);
    }

    private function generatePagination()
    {
        $data = [
            'paginationCont' => $this->pagination_container,
            'pagination' => $this->component->renderPartial($this->pagination_partial_name, $this->pagination_params),
            'container' => $this->items_container,
            'items' => $this->items,
            'template' => $this->component->renderPartial($this->items_partial_name, $this->partial_params)
        ];

        return $data;
    }

    private function generateAjaxPagination()
    {
        $data = [
            $this->pagination_container => $this->component->renderPartial($this->pagination_partial_name, $this->pagination_params),
            'items' => $this->items,
            $this->items_container => $this->component->renderPartial($this->items_partial_name, $this->partial_params)
        ];

        return $data;
    }


}