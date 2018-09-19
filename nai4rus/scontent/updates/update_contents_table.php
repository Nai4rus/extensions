<?php namespace Wms\Site\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateContentsTable extends Migration
{
    public function up()
    {
        Schema::table('wms_scontent_contents', function ($table) {
            $table->string('code')->nullable();

        });
    }

    public function down()
    {
//        Schema::table('wms_scontent_contents', function ($table) {
//            $table->dropColumn(['code']);
//        });
    }
}
