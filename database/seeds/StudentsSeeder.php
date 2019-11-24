<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;


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
        $arrayGender = array('male', 'female');
        $arraySchoolYear = array('1', '2', '3', '4');

        $faker = Faker::create();
    	foreach (range(1,500) as $index) {
	       
            DB::table('tblStudentInfo')->insert([
                'student_lrn' => $arrayYear[array_rand($arrayYear)].''.str_pad(rand(0, pow(10, 4) - 1), 4, '0', STR_PAD_LEFT),
                'studentLastName' => $faker->lastName,
                'studentMiddleName' => $faker->lastName,
                'studentFirstName' => $faker->lastName,
                'studentAge' => rand(16, 32),
                'studentGender' => $arrayGender[array_rand($arrayGender)],
                'schoolYear' => $arraySchoolYear[array_rand($arraySchoolYear)],
                'section' => rand(1, 9),
                'bldg_rmNo' => rand(1, 4).''.rand(1, 20)
            ]);
    
	}
    }
}
