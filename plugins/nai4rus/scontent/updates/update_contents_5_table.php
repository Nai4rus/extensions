<?php namespace Wms\Site\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateContents5Table extends Migration
{
    public function up()
    {
        Schema::table('wms_scontent_contents', function ($table) {
            $table->integer('type_content')->default();
        });
    }

    public function down()
    {
//        Schema::table('wms_scontent_contents', function ($table) {
//            if(Schema::hasColumn('wms_scontent_contents','type_content')) {
//                $table->dropColumn(['type_content']);
//            }
//        });
    }
}
