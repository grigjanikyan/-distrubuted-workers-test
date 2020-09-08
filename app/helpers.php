<?php

use Illuminate\Support\Carbon;

if (!function_exists('getUrlsForBulkInsert')) {
    /**
     * Mutate and return an array of strings to match for bulk insert
     *
     * @param $urls
     * @return array
     */
    function getUrlsForBulkInsert($urls)
    {

        $resp = [];

        foreach ($urls as $index => $url) {
            $resp[$index]['url'] = $url;
            $resp[$index]['created_at'] = Carbon::now()->format('Y-m-d H:i:s');;
            $resp[$index]['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');;
        }

        return $resp;
    }
}
