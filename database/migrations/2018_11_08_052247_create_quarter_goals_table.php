<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuarterGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quarter_goals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quarter_id')->unsigned()->nullable();
            $table->integer('goal_detail_id')->unsigned()->nullable();
            $table->float('amount', 16, 2);
            $table->enum('breakdown', ['Y', 'N'])->default('Y');
            $table->enum('orientation', ['Positive', 'Negative'])->default('Positive');
            $table->timestamps();
        });

        // Set Foreign Key
        Schema::table('quarter_goals', function (Blueprint $table) {
            $table->foreign('quarter_id')
                    ->references('id')
                    ->on('quarters')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        // Set Foreign Key
        Schema::table('quarter_goals', function (Blueprint $table) {
            $table->foreign('goal_detail_id')
                    ->references('id')
                    ->on('goal_details')
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
        Schema::table('quarter_goals', function (Blueprint $table) {
            $table->dropForeign('quarter_goals_goal_detail_id_foreign');
        });

        Schema::table('quarter_goals', function (Blueprint $table) {
            $table->dropForeign('quarter_goals_quarter_id_foreign');
        });

        Schema::dropIfExists('quarter_goals');
    }
}
