<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('clinic_id')->nullable(false)->comment('诊所ID');
            $table->bigInteger('professor_id')->nullable(true)->comment('创建订单的专家ID');
            $table->bigInteger('doctor_id')->nullable(false)->comment('该订单所属病例的医生ID');
            $table->bigInteger('patient_case_id')->nullable(false)->comment('病例ID');
            $table->boolean('is_first')->nullable(false)->default(false)->comment('是否首单');
            $table->tinyInteger('state')->nullable(false)->comment('未付款,已付款,已发货,已签收,退货申请,退货中,已退货,取消交易');
            $table->integer('product_count')->nullable(true)->comment('产品总数');
            $table->float('total_price')->nullable(true)->comment('商品总价');
            $table->float('payment_price')->nullable(true)->comment('实付款金额，默认等于商品总价');
            $table->float('shipping_fee')->nullable(true)->comment('运费');
            $table->integer('pay_method')->nullable(true)->comment('支付方式');
            $table->string('pay_number')->nullable(true)->comment('支付平台订单号');
            $table->dateTime('pay_time')->nullable(true)->comment('付款时间');
            $table->string('tracking_number', 30)->nullable(true)->comment('物流单号');
            $table->bigInteger('address_id')->nullable(true)->comment('收货地址ID');
            $table->dateTime('shipping_time')->nullable(true)->comment('发货时间');
            $table->bigInteger('fapiao_id')->nullable(true)->comment('发票编号');
            $table->string('comments')->nullable(true)->comment('备注说明');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
