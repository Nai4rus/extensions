<?php


namespace Nai4rus\Extensions\Classes\Pagination;


use Cms\Classes\Controller;
use Illuminate\Support\Facades\Input;

class ControlInfo
{
    private $partial_alias;
    private $container_selector;
    private $vars;
    private $container_selector_key = 'control_container';


    public function __construct(string $partial_alias, string $container_selector = null, array $vars = [])
    {
        $this->partial_alias = $partial_alias;
        $this->container_selector = $container_selector ?: Input::get($this->container_selector_key) ?: '#paginate';
        $this->vars = $vars;
    }


    public function renderPartial(): string
    {
        return (new Controller())->renderPartial($this->partial_alias, $this->toArray());
    }


    public function getPartialAlias(): string
    {
        return $this->partial_alias;
    }


    public function setPartialAlias(string $partial_alias): self
    {
        $this->partial_alias = $partial_alias;
        return $this;
    }


    public function getContainerSelector(): string
    {
        return $this->container_selector;
    }


    public function setContainerSelector(string $container_selector): self
    {
        $this->container_selector = $container_selector;
        return $this;
    }


    public function getVars(): array
    {
        return $this->vars;
    }


    public function setVars(array $vars): self
    {
        $this->vars = $vars;
        return $this;
    }


    public function addVars(array $vars): self
    {
        $this->vars = array_merge($this->vars, $vars);
        return $this;
    }


    public function getContainerSelectorKey(): string
    {
        return $this->container_selector_key;
    }


    public function setContainerSelectorKey(string $container_selector_key): self
    {
        $this->container_selector_key = $container_selector_key;
        return $this;
    }


    public function toArray(): array
    {
        return get_object_vars($this);
    }


}