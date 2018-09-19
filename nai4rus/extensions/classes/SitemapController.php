<?php
namespace Nai4rus\Extensions\Classes;

use Carbon\Carbon;
use Cms\Classes\Page;
use Illuminate\Support\Facades\Request;
use October\Rain\Exception\ApplicationException;
use RainLab\Sitemap\Classes\DefinitionItem;

class SitemapController
{
    public $requestUrl;
    public $reference;

    public $pageName;
    public $params = [];
    public $items = [];
    public $nameTimeProperty = 'updated_at';

    public $settings = [];

    public $pages = [];

    /**
     * SitemapController constructor.
     * @param string $reference
     */
    public function __construct(string $reference)
    {
        $this->requestUrl = Request::url();
        $this->reference = $reference;
    }

    /**
     * @param string $reference
     * @return SitemapController
     */
    public static function instance(string $reference)
    {
        return new static($reference);
    }

    /**
     * @param $item
     * @return static
     */
    public static function createByItem(DefinitionItem $item)
    {
        return new static($item->reference);
    }

    /**
     * @return mixed
     */
    public function init()
    {
        if (empty($this->reference)) {
            return null;
        }
        $formattedName = preg_replace('/\W+/iu', '-', $this->reference);
        $functionName = camel_case('on' . ucfirst($formattedName));
        if (!method_exists($this, $functionName)) {
            return null;
        }
        return $this->$functionName();
    }

    /**
     * @param $items
     * @param string $pageName
     * @param array $paramsOptions
     * @param string $nameTimeProperty
     * @return $this
     */
    public function add($items, string $pageName, array $paramsOptions = null, string $nameTimeProperty = null)
    {
        $settings = [];
        $settings['items'] = $items;
        $settings['pageName'] = $pageName;
        $settings['params'] = $paramsOptions;
        $settings['nameTimeProperty'] = $nameTimeProperty;

        $this->settings[] = (object) $settings;

        return $this;
    }

    /**
     * @param \Closure|null $callback
     * @param string $urlCurrentPage
     * @param Carbon or Argon $updTimeCurrentPage
     * @return array
     * @throws ApplicationException
     */
    public function generate(\Closure $callback = null, string $urlCurrentPage = null, $updTimeCurrentPage = null)
    {
        $updTimeCurrentPage = $updTimeCurrentPage ?: Carbon::now();
        $urlCurrentPage = $urlCurrentPage ?: url('/');

        $this->generatePages($callback);

        $pages = [
            'url' => $urlCurrentPage,
            'mtime' => $updTimeCurrentPage,
            'items' => $this->pages
        ];
        return $pages;
    }

    /**
     * @param \Closure|null $callback
     * @throws ApplicationException
     */
    protected function generatePages(\Closure $callback = null)
    {
        if ($callback) {
            foreach ($this->settings as $settings) {
                foreach ($settings->items as $item){
                    $this->pages[] = $callback($item);
                }
            }
        } else {
            foreach ($this->settings as $settings) {
                foreach ($settings->items as $item) {
                    $params = $this->generateParams($item, $settings->params);

                    $url = Page::url($settings->pageName, $params);

                    if ($settings->nameTimeProperty) {
                        if (!isset($item->{$settings->nameTimeProperty})) {
                            throw new ApplicationException('The specified model property does not exist');
                        }

                        $mtime = $item->{$settings->nameTimeProperty};
                    } else {
                        $mtime = Carbon::now();
                    }

                    $this->pages[] = [
                        'url' => $url,
                        'mtime' => $mtime
                    ];
                }

            }

        }

    }

    /**
     * @param $item
     * @param array $paramArr
     * @return array
     * @throws ApplicationException
     */
    protected function generateParams($item, array $paramArr)
    {
        $params = [];
        foreach ($paramArr as $paramName => $modelProperty) {
            if ($modelProperty === false) {
                $params[$paramName] = false;
            } else {
                $obj = $item;
                $properties = explode('.', $modelProperty);

                foreach ($properties as $property) {
                    if (!isset($obj->$property)) {
                        throw new ApplicationException('The specified model property does not exist');
                    }
                    $obj = $obj->$property;
                }

                $params[$paramName] = $obj;
            }
        }
        return $params;
    }
}
