<?php namespace Wms\Ulogin\Models;

use Model;

/**
 * account Model
 */
class Account extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'wms_ulogin_accounts';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [
        'identity',
        'uid',
        'profile',
        'network'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [];
    public $belongsTo = [
        'user' => ['Rainlab\User\Models\User']
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];
}
