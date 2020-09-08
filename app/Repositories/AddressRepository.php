<?php


namespace App\Repositories;

use App\Models\Address;

class AddressRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new Address();
    }

    /**
     * Fetches the next unprocessed item, and sets the status of this item to 'processing'
     *
     * @return array
     */
    public function getFirstAvailable()
    {
        $address = $this->model->where('status', config('enums.statuses.new'))->first();

        $address->status = config('enums.statuses.processing');
        $address->save();

        return $address->toArray();
    }

    /**
     * Inserts the array of the urls as seperate rows in db
     *
     * @param $urls
     * @return mixed
     */
    public function bulkCreate($urls)
    {
        $urls = getUrlsForBulkInsert($urls);

        return $this->model::insert($urls);
    }

    /**
     * Update the values of the $data["id"]
     *
     * @param $data
     */
    public function update($data)
    {
        $this->model->find($data["id"])->update($data);
    }

}
