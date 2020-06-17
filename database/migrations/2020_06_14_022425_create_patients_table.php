<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->char('id', 15)->nullable(false)
                ->comment('病历号，系统自动生成，患者终生使用');
            $table->timestamps();
            $table->bigInteger('user_id')->nullable(false)->comment('创建该患者的用户');
            $table->string('name', 20)->nullable(false)
                ->comment('患者姓名');
            $table->tinyInteger('age')->nullable(false)->comment('年龄');
            $table->tinyInteger('sex')->nullable(false)->comment('0男1女2其他');
            $table->string('comments', 50)->nullable(false)
                ->comment('备注信息');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
