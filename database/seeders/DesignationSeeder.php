<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = array('teacher','staff','security','principal');
        foreach($datas as $data){
            $designation = new Designation();
            $designation->name = $data;
            $designation->save();
        }
    }
}
