<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DropdownsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dropdowns')->delete();
        
        \DB::table('dropdowns')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Transportation',
                'type' => 'trip',
                'classification' => 'Category',
                'color' => 'green',
                'status' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Medical Equipement',
                'type' => 'health',
                'classification' => 'Category',
                'color' => 'red',
                'status' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Machinery',
                'type' => 'cog',
                'classification' => 'Category',
                'color' => 'yellow',
                'status' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Others',
                'type' => 'folder-open',
                'classification' => 'Category',
                'color' => 'gray',
                'status' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Operational',
                'type' => 'Asset',
                'classification' => 'Status',
                'color' => 'green',
                'status' => 1,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Maintenance',
                'type' => 'Asset',
                'classification' => 'Status',
                'color' => 'red',
                'status' => 1,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Disposed',
                'type' => 'Asset',
                'classification' => 'Status',
                'color' => 'black',
                'status' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Borrowed',
                'type' => 'Asset',
                'classification' => 'Status',
                'color' => 'yellow',
                'status' => 1,
            ),
        ));
        
        
    }
}