<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingKreditGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_kredit_goals', function (Blueprint $table) {
            $table->increments('id');
            $table->float('booking_amount', 16, 2);
            $table->float('run_off', 16, 2)->default(0)->nullable();
            $table->float('loan_close', 16, 2)->default(0)->nullable();
            $table->date('booking_date');
            $table->integer('noa');
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('week')->nullable();
            $table->integer('quarter')->nullable();
            $table->string('action_id', 6);
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('user_goal_id')->unsigned()->nullable();

            $table->integer('first_approval_id')->unsigned()->nullable();
            $table->enum('first_approval_status',['Ongoing', 'Approval', 'Rejected'])->default('Ongoing');
            $table->date('first_approval_date')->nullable();
            $table->integer('second_approval_id')->unsigned()->nullable();
            $table->enum('second_approval_status',['Ongoing', 'Approval', 'Rejected'])->default('Ongoing');
            $table->date('second_approval_date')->nullable();
            $table->timestamps();
        });

        // Set Foreign Key
        Schema::table('booking_kredit_goals', function (Blueprint $table) {
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        // Set Foreign Key
        Schema::table('booking_kredit_goals', function (Blueprint $table) {
            $table->foreign('user_goal_id')
                    ->references('id')
                    ->on('user_goals')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        // Set Foreign Key
        Schema::table('booking_kredit_goals', function (Blueprint $table) {
            $table->foreign('first_approval_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        // Set Foreign Key
        Schema::table('booking_kredit_goals', function (Blueprint $table) {
            $table->foreign('second_approval_id')
                    ->references('id')
                    ->on('users')
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
        Schema::table('booking_kredit_goals', function (Blueprint $table) {
            $table->dropForeign('booking_kredit_goals_user_goal_id_foreign');
        });

        Schema::table('booking_kredit_goals', function (Blueprint $table) {
            $table->dropForeign('booking_kredit_goals_user_id_foreign');
        });

        Schema::table('booking_kredit_goals', function (Blueprint $table) {
            $table->dropForeign('booking_kredit_goals_first_approval_id_foreign');
        });

        Schema::table('booking_kredit_goals', function (Blueprint $table) {
            $table->dropForeign('booking_kredit_goals_second_approval_id_foreign');
        });

        Schema::dropIfExists('booking_kredit_goals');
    }
}
