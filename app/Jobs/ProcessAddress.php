<?php

namespace App\Jobs;

use App\Repositories\AddressRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAddress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $addressRepo = new AddressRepository();
        $entry = $addressRepo->getFirstAvailable();

        try {
            $entry["http_code"] = $this->getHttpStatusCode($entry["url"]);
            $entry["status"] = config('enums.statuses.done');
        } catch (\Exception $e) {
            $entry["status"] = config('enums.statuses.failed');
        }

        $addressRepo->update($entry);
    }

    /**
     * Makes a curl request and returns the http status code
     * Throws exception on fail
     *
     * @param string $url
     * @return int
     * @throws \Exception
     */
    private function getHttpStatusCode(string $url): int
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode;
    }
}
