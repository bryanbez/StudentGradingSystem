<?php

use Illuminate\Database\Seeder;

class StudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $arrayYear = array('2014', '2015', '2016', '2017', '2018', '2019');

        DB::table('tblStudentInfo')->insert([
            'student_lrn' => $arrayYear[array_rand($arrayYear)].''.str_pad(rand(0, pow(10, 4) - 1), 4, '0', STR_PAD_LEFT),
            'studentLastName' => str_random(10),
            'studentMiddleName' => str_random(10),
            'studentFirstName' => str_random(10),
            'studentAge' => rand(16, 32),
            'studentGender' => array_rand(array('male', 'female')),
            'schoolYear' => array_rand(array('1st', '2nd', '3rd', '4th')),
            'section' => rand(1, 20),
            'bldg_rmNo' => rand(1, 4)
        ]);
    }
}
