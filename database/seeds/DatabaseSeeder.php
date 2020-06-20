<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AssetsTableSeeder::class);
        //https://my.bluehost.com/hosting/help/89ßß
    }
}
