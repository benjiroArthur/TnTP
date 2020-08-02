<?php

use App\Region;
use Illuminate\Database\Seeder;

class RegionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            [
                'name'=>"Northern",
                'id'=>1
            ],
            [
                'name'=>"Ashanti",
                'id'=>2
            ],
            [
                'name'=>"Western",
                'id'=>3
            ],
            [
                'name'=>"Volta",
                'id'=>4
            ],
            [
                'name'=>"Eastern",
                'id'=>5
            ],
            [
                'name'=>"Upper West",
                'id'=>6
            ],
            [
                'name'=>"Central",
                'id'=>7
            ],
            [
                'name'=>"Upper East",
                'id'=>8
            ],
            [
                'name'=>"Greater Accra",
                'id'=>9
            ],
            [
                'name'=>"North East",
                'id'=>11
            ],
            [
                'name'=>"Savannah",
                'id'=>10
            ],
            [
                'name'=>"Bono East",
                'id'=>12
            ],
            [
                'name'=>"Oti",
                'id'=>13
            ],
            [
                'name'=>"Ahafo",
                'id'=>14
            ],
            [
                'name'=>"Bono",
                'id'=>15
            ],
            [
                'name'=>"Western North",
                'id'=>16
            ]
        ];

        foreach ($regions as $region){
            Region::create($region);
        }

//
//1 Northern	70,384
//2	Ashanti	24,389
//3	Western	23,941
//4	Volta	20,570
//5	Eastern	19,323
//6	Upper West	18,476
//7	Central	9,826
//8	Upper East	8,842
//9	Greater Accra	3,245
//10	Savannah
//11	North East
//12	Bono East
//13	Oti
//14	Ahafo
//15	Bono
//16	Western North
    }
}
