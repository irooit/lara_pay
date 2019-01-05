<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->unique();
            $table->date('birthday')->nullable();
            $table->string('country_code')->nullable();
            $table->unsignedSmallInteger('gender')->nullable();//性别。MALE：男，FEMALE：女。
            $table->string('province_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('location')->nullable();
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->string('timezone')->nullable();
            $table->string('introduction')->nullable();
            $table->text('bio')->nullable();

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
        Schema::dropIfExists('user_profiles');
    }
}
