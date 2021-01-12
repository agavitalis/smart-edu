<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(TermSeeder::class);
        $this->call(KlassSeed::class);
        $this->call(LevelSeeder::class);
        $this->call(SessionSeeder::class);
    }
}
