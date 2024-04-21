<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = array('maths','physics','hindi','english');
        foreach($datas as $data){
            $department = new Department();
            $department->name = $data;
            $department->save();
        }
    }
}
