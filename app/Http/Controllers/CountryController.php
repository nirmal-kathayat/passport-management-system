<?php

namespace App\Http\Controllers;

use App\Repository\ContinentRepository;
use App\Repository\CountryRepository;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    private $countryRepo, $continentRepo;

    public function __construct(CountryRepository $countryRepo, ContinentRepository $continentRepo)
    {
        $this->countryRepo = $countryRepo;
        $this->continentRepo = $continentRepo;
    }

    public function create()
    {
        try {
            $continents = $this->continentRepo->get();
            return view('country.form')->with(['continents' => $continents]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'An error occurred while fetching country data.', 'type' => 'error']);
        }
    }
}
