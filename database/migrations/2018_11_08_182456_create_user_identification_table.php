<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserIdentificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_identification', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->unique();
            $table->string('real_name')->nullable()->comment('Real Name');//真实姓名
            $table->string('id_card', 18)->nullable();//证件号
            $table->string('passport_cover')->nullable();
            $table->string('passport_person_page')->nullable();
            $table->string('passport_self_holding')->nullable();
            $table->unsignedSmallInteger('status')->nullable()->default(0);
            $table->string('failed_reason')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_identification');
    }
}
