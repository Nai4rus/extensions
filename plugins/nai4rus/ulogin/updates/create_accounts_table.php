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
            $table->string('identity',400)->nullable();
            $table->string('uid',400)->nullable();
            $table->string('profile',400)->nullable();
            $table->string('network')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('user_id')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wms_ulogin_accounts');
    }
}
