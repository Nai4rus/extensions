<?php

namespace Nai4rus\Extensions\Classes\Pagination;


use Nai4rus\Extensions\Classes\PaginationFactory;

class Paginator implements \IteratorAggregate
{
    public $pagination_container;
    public $pagination_partial;
    public $items;
    public $items_container;
    public $items_partial;


    public function __construct(PaginationFactory $factory)
    {
        $control = $factory->getControlInfo()->addVars($factory->toArray());
        $content = $factory->getContentInfo()->addVars($factory->toArray());

        $this->pagination_container = $control->getContainerSelector();
        $this->pagination_partial = $control->renderPartial();
        $this->items_container = $content->getContainerSelector();
        $this->items_partial = $content->renderPartial();
        $this->items = $factory->getItemsCollection();
    }


    public function getPaginationContainer(): string
    {
        return $this->pagination_container;
    }


    public function getItemsContainer(): string
    {
        return $this->items_container;
    }


    public function renderList(): string
    {
        return $this->items_partial;
    }


    public function renderPagination(): string
    {
        return $this->pagination_partial;
    }


    public function toAjax(): array
    {
        return [
            'items' => $this->items,
            $this->pagination_container => $this->pagination_partial,
            $this->items_container = $this->items_partial
        ];
    }


    public function getIterator(): \ArrayIterator
    {
        return new \ArrayIterator($this->items);
    }
}