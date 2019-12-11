<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecitationMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblRecitation', function (Blueprint $table) {
            $table->bigIncrements('recitation_id');
            $table->integer('student_lrn');
            $table->string('subj_code');
            $table->date('date_of_recitation');
            $table->integer('points');
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
        Schema::drop('tblRecitation');
    }
}
