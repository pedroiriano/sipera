<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_activities', function (Blueprint $table) {
            $table->id();
            $table->string('sub_activity');
            $table->double('budget_01');
            $table->double('budget_02');
            $table->double('budget_03');
            $table->double('budget_04');
            $table->double('budget_05');
            $table->double('budget_06');
            $table->double('budget_07');
            $table->double('budget_08');
            $table->double('budget_09');
            $table->double('budget_10');
            $table->double('budget_11');
            $table->double('budget_12');
            $table->string('physic')->nullable();
            $table->bigInteger('activity_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_activities');
    }
};
