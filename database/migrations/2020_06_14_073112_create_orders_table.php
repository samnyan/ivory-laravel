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
            $table->bigInteger('professor_id')->nullable(false)->comment('创建订单的专家ID');
            $table->bigInteger('doctor_id')->nullable(false)->comment('该订单所属病例的医生ID');
            $table->bigInteger('patient_case_id')->nullable(false)->comment('病例ID');
            $table->boolean('is_first')->nullable(false)->default(false)->comment('是否首单');
            $table->tinyInteger('state')->nullable(false)->comment('未付款,已付款,已发货,已签收,退货申请,退货中,已退货,取消交易');
            $table->integer('product_count')->nullable(true)->comment('不同产品种类的数量');
            $table->float('product_amount_total')->nullable(true)->comment('商品总价');
            $table->float('order_amount_total')->nullable(true)->comment('实付款金额，默认等于商品总价');
            $table->float('logistics_fee')->nullable(true)->comment('运费');
            $table->bigInteger('address_id')->nullable(true)->comment('收货地址ID');
            $table->string('logistics_no', 30)->nullable(true)->comment('物流单号');
            $table->integer('pay_channel')->nullable(true)->comment('支付方式');
            $table->integer('pay_no')->nullable(true)->comment('支付号');
            $table->dateTime('delivery_time')->nullable(true)->comment('发货时间');
            $table->dateTime('pay_time')->nullable(true)->comment('付款时间');
            $table->integer('order_settlement_status')->nullable(true)->comment('订单结算状态：货到付款或分期付款');
            $table->dateTime('order_settlement_time')->nullable(true)->comment('订单结算时间');
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
