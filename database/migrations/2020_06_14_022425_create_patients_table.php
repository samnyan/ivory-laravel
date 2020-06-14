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
            $table->engine = 'MyISAM';
            $table->collation = 'latin1_swedish_ci';
            $table->charset = 'latin1';

            $table->char('id', 15)->charset('latin1')->collation('latin1_swedish_ci')->nullable(false)
                ->comment('病历号，系统自动生成，患者终生使用');
            $table->string('name', 20)->charset('latin1')->collation('latin1_swedish_ci')->nullable(false)
                ->comment('患者姓名');
            $table->dateTime('createtime')->useCurrent()->nullable(false)->comment('创建时间');
            $table->tinyInteger('age')->nullable(false)->comment('年龄');
            $table->tinyInteger('sex')->nullable(false)->comment('0男1女2其他');
            $table->string('comments', 50)->charset('latin1')->collation('latin1_swedish_ci')->nullable(false)
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
