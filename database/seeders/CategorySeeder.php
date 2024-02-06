<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = [
            [
                'name'=> 'Согласование',
                'is_closed' => false,
                'sort' => 40
            ],
            [
                'name'=> 'Приоритетный',
                'is_closed' => false,
                'sort' => 10
            ],
            [
                'name'=> 'В работе',
                'is_closed' => false,
                'sort' => 20
            ],
            [
                'name'=> 'Ожидание оплаты',
                'is_closed' => false,
                'sort' => 40
            ],
            [
                'name'=> 'Отложен',
                'is_closed' => false,
                'sort' => 50
            ],
            [
                'name'=> 'Успешно',
                'is_closed' => true,
                'sort' => 250
            ],
            [
                'name'=> 'Провал',
                'is_closed' => true,
                'sort' => 300
            ]
        ];
        DB::table('categories')->insert($category);
    }
}
