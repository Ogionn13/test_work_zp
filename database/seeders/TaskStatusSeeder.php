<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taskStatuses = [
            [
                'name' => 'Открытая',
                'is_closed' => false,
                'sort' => 20
            ],
            [
                'name' => 'Срочная',
                'is_closed' => false,
                'sort' => 10
            ],
            [
                'name' => 'Фоновая',
                'is_closed' => false,
                'sort' => 30
            ],
            [
                'name' => 'Приостановлена',
                'is_closed' => false,
                'sort' => 40
            ],
            [
                'name' => 'Завершенная',
                'is_closed' => true,
                'sort' => 100
            ]
        ];
        DB::table('task_statuses')->insert($taskStatuses);
    }
}
