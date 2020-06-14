<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_cases', function (Blueprint $table) {
            $table->id()->comment('方案的ID号，被订单表引用');
            $table->timestamps();
            $table->char('patient_id', 15)->nullable(false)->comment('患者病历号');
            $table->tinyInteger('state')->nullable(false)->comment('0创建1已提交2已审核3已存档4待修改');
            $table->string('features')->comment('患者症状描述');
            $table->json('files')->comment('JSON格式的8张相片2张X版及模型号');
            $table->string('therapy_program', 200)->comment('治疗方案');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patient_cases');
    }
}
