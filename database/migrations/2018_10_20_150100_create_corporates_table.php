<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorporatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('corporate_ID', 30)->unique();
            $table->string('corporate_name');
            $table->timestamps();
        });

        //Set office_id on user
        Schema::table('offices', function($table){
            $table->integer('corporate_id')->unsigned()->nullable()->after('parent');
        });

        // Set Foreign Key
        Schema::table('offices', function (Blueprint $table) {
            $table->foreign('corporate_id')
                    ->references('id')
                    ->on('corporates')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offices', function (Blueprint $table) {
            $table->dropForeign('offices_corporate_id_foreign');
        });

        Schema::table('offices', function($table) {
            $table->dropColumn('corporate_id');
        });

        Schema::dropIfExists('corporates');
    }
}
