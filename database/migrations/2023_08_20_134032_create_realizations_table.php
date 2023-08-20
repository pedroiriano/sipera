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
        Schema::create('realizations', function (Blueprint $table) {
            $table->id();
            $table->integer('month');
            $table->double('budget_use');
            $table->string('physic_use')->nullable();
            $table->double('performance');
            $table->double('budget_remaining');
            $table->string('problem_category');
            $table->string('problem_description');
            $table->string('problem_solution');
            $table->bigInteger('sub_activity_id');
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
        Schema::dropIfExists('realizations');
    }
};
