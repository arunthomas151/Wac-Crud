<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
//        Designation::truncate();
        DB::table('designations')->insert([
            [
                'name' => 'Developer',
            ],
            [
                'name' => 'Team Lead',
            ],
            [
                'name' => 'Content Writer',
            ],
            [
                'name' => 'Project Manager',
            ],
            [
                'name' => 'Designer',
            ],
            [
                'name' => 'Research Analyst',
            ],
            [
                'name' => 'Project Manager',
            ]
        ]);

    }
}
