<?php

namespace BikeShare\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use League\Fractal\Manager;

class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $user;

    protected $fractal;


    public function __construct()
    {
        $this->user = auth()->user();
        $this->fractal = new Manager();
    }


    public function download()
    {
        switch (request()->type) {
            case 'stand-qr':
                $file = storage_path('app/qr/stands/' . request()->file . '/qr-stand-' . request()->file . '.svg');
                break;

            case 'bike-qr':
                $file = storage_path('app/qr/bikes/' . request()->file . '/qr-bike-' . request()->file . '.svg');
                break;
        }

        return response()->download($file);
    }
}
