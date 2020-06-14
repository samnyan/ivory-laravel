<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('pwd')->nullable(false)->comment('不超过20位的密码');
            $table->tinyInteger('type')->default(0)->nullable(false)
                ->comment('0医生1患者2专家3其他，目前系统只提供医生和专家登录，专家即网站的管理维护人员，可以是矫治器生产者本人');
            $table->string('username', 20)->nullable(false)->unique();
            $table->tinyInteger('sex')->nullable(false)
                ->comment('0男1女2保密');
            $table->integer('age')->nullable(true)->comment('年龄');
            $table->string('head_portrait', 50)->nullable(true)
                ->comment('头像文件路径');
            $table->string('clinic', 20)->nullable(true)
                ->comment('诊所名称');
            $table->string('mobile', 14)->nullable(true)
                ->comment('手机号码+86');
            $table->string('email', 30)->nullable(false)->unique();
            $table->string('fixphonenumber', 15)->nullable(true);
            $table->string('certificat', 50)->nullable(true)
                ->comment('证书图像的存储路径');
            $table->tinyInteger('certificat_checked')->nullable(true)->comment('证书状态：0未上传，1已上传，2已审核通过，3审核不通过');
            $table->string('wechat', 20)->nullable(true)->unique()
                ->comment('微信号，值为空表示未绑定');
            $table->string('intro', 200)->nullable(true)
                ->comment('200字以内的个人简介');
            $table->string('school', 50)->nullable(true)
                ->comment('毕业学校');
            $table->string('major', 50)->nullable(true)
                ->comment('专业');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
