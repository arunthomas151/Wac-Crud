<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('profile_image')->nullable();
            $table->unsignedBigInteger('designation')->comment('1 =>Team Lead, 2 => Developer, 3 => Content Writer, 4 => Tester, 5 => Designer, 6 => Research Analyst, 7 => Project Manager, 8 => SEO Analist');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('designation')->references('id')->on('designations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
