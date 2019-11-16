<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StudentInfoMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblStudentInfo', function (Blueprint $table) {
            $table->integer('student_lrn');
            $table->string('studentFirstName');
            $table->string('studentLastName');
            $table->string('studentMiddleName');
            $table->integer('studentAge');
            $table->string('studentGender');
            $table->string('schoolYear');
            $table->string('section');
            $table->string('bldg_rmNo');
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
        Schema::drop('tblStudentInfo');
    }
}
