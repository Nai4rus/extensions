<?php namespace Wms\Scontent\Models;

use Model;
use System\Models\File;
use Cms\Classes\Page as CmsPage;
use Wms\Site\Classes\Helper;

/**
 * content Model
 */
class Content extends Model {
    /**
     * @var string The database table used by the model.
     */
    public $table = 'wms_scontent_contents';
    public $cmsPage = 'contents_page';
    public $nameModel = 'contents';

    //use \October\Rain\Database\Traits\Sluggable;
    //protected $slugs = ['slug' => 'title'];
//        use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\NestedTree;

    //    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];
    //    public $translatable = ['title','text'];

//        public $rules = [
//            'code' => 'required'
//        ];
//        public $attributeNames = [
//            'code' => 'Идентификатор'
//        ];
//        use \October\Rain\Database\Traits\Validation;

    /**
     * @var array Guarded fields
     */
    protected $guarded = [ '*' ];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];
    protected $dates = [];
    protected $jsonable = [];

    /**
     * @var array Relations
     */
    public $morphToMany = [];
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [ 'image' => File::class ];
    public $attachMany = [ 'images' => File::class ];

    public function beforeSave() {
        if ($this->type == 0) {
            $this->value = $this->raw_field;
        } else {
            $this->value = $this->formatted_field;
        }

        if (empty($this->title)) {
            switch ($this->type_content) {
                case 0:
                    $res = 'Структура';
                    break;
                case 1:
                    $res = 'Список';
                    break;
                case 2:
                    $res = 'Заголовок';
                    break;
                case 3:
                    $res = 'Текст';
                    break;
                case 4:
                    $res = 'Изображение';
                    break;
                case 5:
                    $res = 'Ссылка';
                    break;
                case 6:
                    $res = 'Блок';
                    break;
            }
            $this->title = $res;
        }
    }

    public function listPages() {
        return CmsPage::sortBy('baseFileName')->lists('title', 'baseFileName');
    }
}
