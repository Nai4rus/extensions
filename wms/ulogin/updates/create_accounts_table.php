<?php namespace Wms\Ulogin\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('wms_ulogin_accounts', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('identity',400);
            $table->string('uid',400);
            $table->string('profile',400);
            $table->string('network');
            $table->boolean('is_active')->default(1);
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wms_ulogin_accounts');
    }
}
