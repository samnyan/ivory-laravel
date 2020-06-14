<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('user_id')->nullable(false)->comment('用户ID');
            $table->string('real_name', 15)->nullable(false)->comment('收件人姓名');
            $table->string('telephone', 20)->nullable(false)->comment('联系电话');
            $table->integer('country')->nullable(false)->comment('国家');
            $table->integer('province')->nullable(false)->comment('省份');
            $table->integer('city')->nullable(false)->comment('城市');
            $table->integer('area')->nullable(false)->comment('地区');
            $table->integer('street')->nullable(false)->comment('街道/详细收货地址');
            $table->integer('zip')->nullable(false)->comment('邮政编码');
            $table->boolean('is_default')->nullable(false)->default(true)->comment('是否默认地址');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
