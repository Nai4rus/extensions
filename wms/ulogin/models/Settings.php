<?php namespace Wms\Ulogin\Models;

use Model;

/**
 * settings Model
 */
class Settings extends Model
{
//    use \October\Rain\Database\Traits\Sluggable;
//    use \October\Rain\Database\Traits\Sortable;
//    use \October\Rain\Database\Traits\NestedTree;
//    use \October\Rain\Database\Traits\Validation;
//    use \October\Rain\Database\Traits\SoftDelete;

//    public $implement = ['RainLab.Translate.Behaviors.TranslatableModel'];

    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'wms_ulogin_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    /**
     * @var array Validation rules, custom messages and attributes names.
     */
//    public $rules = [];
//    public $attributeNames = [];
//    public $customMessages = [];

    /**
     * @var array Generate slugs for these attributes.
     */
//    protected $slugs = ['slug' => 'name'];

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];
    protected $dates = [];
    protected $jsonable = [
//        'meta'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $morphToMany = [];
    public $attachOne = [];
    public $attachMany = [];

    public $providers = [
        "vkontakte" => "ВКонтакте",
        "twitter" => "Twitter",
        "mailru" => "Mail.ru",
        "facebook" => "Facebook",
        "odnoklassniki" => "Одноклассники",
        "yandex" => "Яндекс",
        "google" => "Google",
        "steam" => "Steam",
        "soundcloud" => "Soundcloud",
        "lastfm" => "Last.FM",
        "linkedin" => "LinkedIn",
        "liveid" => "Live ID",
        "flickr" => "Flickr",
        "uid" => "uID",
        "livejournal" => "Живой журнал",
        "openid" => "Open ID",
        "webmoney" => "Webmoney",
        "youtube" => "Youtube",
        "foursquare" => "foursquare",
        "tumblr" => "tumblr",
        "googleplus" => "Google+",
        "vimeo" => "Vimeo",
        "instagram" => "Instagram",
        "wargaming" => "Wargaming.net"
    ];

    public function getSiteOptions($value, $form)
    {
        return $this->providers;
    }

}
