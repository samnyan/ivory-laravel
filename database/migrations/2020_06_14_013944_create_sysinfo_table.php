<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSysinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sysinfo', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->collation = 'latin1_swedish_ci';
            $table->charset = 'latin1';
            $table->integer('id')->autoIncrement();
            $table->integer('type')->nullable(false)->comment('0欢迎词1广告');
            $table->integer('msg')->nullable(false)->comment('消息内容');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sysinfo');
    }
}
