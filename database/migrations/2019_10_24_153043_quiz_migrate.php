<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QuizMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblQuiz', function (Blueprint $table) {
            $table->bigIncrements('quiz_id');
            $table->integer('student_lrn');
            $table->string('subj_code');
            $table->date('date_of_quiz');
            $table->integer('no_of_items');
            $table->integer('score');
            $table->double('equivalent');
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
        Schema::drop('tblQuiz');
    }
}
