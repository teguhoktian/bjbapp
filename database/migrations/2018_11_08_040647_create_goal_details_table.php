<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goal_details', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('goal_id')->unsigned()->nullable();
            $table->timestamps();
        });

        // Set Foreign Key
        Schema::table('goal_details', function (Blueprint $table) {
            $table->foreign('goal_id')
                    ->references('id')
                    ->on('goals')
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
        Schema::table('goal_details', function (Blueprint $table) {
            $table->dropForeign('goal_details_goal_id_foreign');
        });

        Schema::dropIfExists('goal_details');
    }
}
