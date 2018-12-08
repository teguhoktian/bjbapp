<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',12)->unique();
            $table->string('name',120);
            $table->string('parent')->nullable();
            $table->timestamps();
        });

        //Set office_id on user
        Schema::table('users', function($table){
            $table->integer('office_id')->unsigned()->nullable()->after('status');
        });

        // Set Foreign Key
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('office_id')
                    ->references('id')
                    ->on('offices')
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_office_id_foreign');
        });

        Schema::table('users', function($table) {
            $table->dropColumn('office_id');
        });

        Schema::dropIfExists('offices');
    }
}
