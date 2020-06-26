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
            $table->bigInteger('user_id')->nullable(false)->comment('创建方案的用户名');
            $table->tinyInteger('state')->nullable(false)->comment('-1已取消 0创建 1资料已提交(医生) 2资料需修改 3方案已制定(专家)
                                                                                          4方案待修改 5方案已同意 6已确认 7已下单 8订单已确认 10已存档');
            $table->text('features')->nullable(true)->comment('患者症状描述');
            $table->json('files')->nullable(true)->comment('JSON格式的8张相片2张X版及模型号');
            $table->text('therapy_program')->nullable(true)->comment('治疗方案');
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
