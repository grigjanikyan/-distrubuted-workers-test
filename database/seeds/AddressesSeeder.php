<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddressesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urls = [
            'https://google.com/',
            'https://facebook.com/',
            'https://proxify.io/',
            'https://stackoverflow.com/',
            'https://php.net/',
            'https://yahoo.com',
            'https://twitter.com',
            'https://reddit.com',
            'https://linked.com',
            'https://cooll.am'
        ];

        $urls = getUrlsForBulkInsert($urls);

        DB::table('addresses')->insert($urls);
    }
}
