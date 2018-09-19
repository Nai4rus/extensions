<?php namespace Wms\Site\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateContents4Table extends Migration
{
    public function up()
    {
        Schema::table('wms_scontent_contents', function ($table) {
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
        });
    }

    public function down()
    {
//        Schema::table('wms_scontent_contents', function ($table) {
//            if(Schema::hasColumn('wms_scontent_contents','nest_right')) {
//                $table->dropColumn(['nest_right', 'nest_left', 'nest_depth']);
//            }
//        });
    }
}
