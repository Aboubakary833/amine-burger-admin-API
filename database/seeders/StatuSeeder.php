<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['Not delivered', 'rejected', 'delivered'];
        foreach ($statuses as $status) {
            Status::create(['name' => $status]);
        }
    }
}
