<?php namespace Wms\Site\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateContents3Table extends Migration
{
    public function up()
    {
        Schema::table('wms_scontent_contents', function ($table) {
            $table->mediumText('value')->nullable();

        });
    }

    public function down()
    {
//        Schema::table('wms_scontent_contents', function ($table) {
//            if(Schema::hasColumn('wms_scontent_contents','value')){
//                $table->dropColumn(['value']);
//            }
//        });
    }
}
