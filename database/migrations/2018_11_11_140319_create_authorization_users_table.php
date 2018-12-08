<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorization_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('approval_first_id')->unsigned()->nullable();
            $table->integer('approval_second_id')->unsigned()->nullable();
            $table->timestamps();
        });

        // Set Foreign Key
        Schema::table('authorization_users', function (Blueprint $table) {
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        // Set Foreign Key
        Schema::table('authorization_users', function (Blueprint $table) {
            $table->foreign('approval_first_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
        });

        // Set Foreign Key
        Schema::table('authorization_users', function (Blueprint $table) {
            $table->foreign('approval_second_id')
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
        Schema::table('authorization_users', function (Blueprint $table) {
            $table->dropForeign('authorization_users_approval_second_id_foreign');
        });

        Schema::table('authorization_users', function (Blueprint $table) {
            $table->dropForeign('authorization_users_approval_first_id_foreign');
        });

        Schema::table('authorization_users', function (Blueprint $table) {
            $table->dropForeign('authorization_users_user_id_foreign');
        });

        Schema::dropIfExists('authorization_users');
    }
}
