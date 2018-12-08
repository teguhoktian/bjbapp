<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_goals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('quarter_goal_id')->unsigned()->nullable();
            $table->float('amount', 16, 2);
            $table->timestamps();
        });

         // Set Foreign Key
        Schema::table('user_goals', function (Blueprint $table) {
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        // Set Foreign Key
        Schema::table('user_goals', function (Blueprint $table) {
            $table->foreign('quarter_goal_id')
                    ->references('id')
                    ->on('quarter_goals')
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
        Schema::table('user_goals', function (Blueprint $table) {
            $table->dropForeign('user_goals_quarter_goal_id_foreign');
        });

        Schema::table('user_goals', function (Blueprint $table) {
            $table->dropForeign('user_goals_user_id_foreign');
        });

        Schema::dropIfExists('user_goals');
    }
}
