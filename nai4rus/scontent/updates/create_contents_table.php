<?php namespace Wms\Scontent\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateContentsTable extends Migration
{
    public function up()
    {
        Schema::create('wms_scontent_contents', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            $table->string('cms')->nullable();
            $table->string('title')->nullable();
            $table->boolean('type')->default(true);
            $table->mediumText('raw_field')->nullable();
            $table->mediumText('formatted_field')->nullable();
			$table->integer('is_active')->default(1);
			$table->integer('sort_order')->default(500);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wms_scontent_contents');
    }
}
