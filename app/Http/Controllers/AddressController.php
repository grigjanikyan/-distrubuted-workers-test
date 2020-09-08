<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessAddress;
use App\Repositories\AddressRepository;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    private $repo;

    public function __construct(AddressRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Creates new entries
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request) {
        return $this->repo->bulkCreate($request->input('urls'));
    }

    /**
     * Dispatches the addresses processing job
     */
    public function dispatchJob()
    {
        $this->dispatch(new ProcessAddress);
    }
}
