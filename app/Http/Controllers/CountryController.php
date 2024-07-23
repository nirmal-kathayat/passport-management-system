<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequest;
use App\Repository\ContinentRepository;
use App\Repository\CountryRepository;
use Illuminate\Http\Request;
use DataTables;

class CountryController extends Controller
{
    private $countryRepo, $continentRepo;

    public function __construct(CountryRepository $countryRepo, ContinentRepository $continentRepo)
    {
        $this->countryRepo = $countryRepo;
        $this->continentRepo = $continentRepo;
    }

    public function index()
    {
        try {
            if (request()->ajax()) {
                $data = $this->countryRepo->dataTable();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns([])
                    ->make(true);
            }
            return view('country.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'An error occurred while fetching country data.', 'type' => 'error']);
        }
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

    public function store(CountryRequest $request)
    {
        try {
            $this->countryRepo->storeCountries($request->validated());
            return redirect()->route('admin.country')->with(['message' => 'Country added successfully!', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'An error occurred while fetching country data.', 'type' => 'error']);
        }
    }

    public function edit($id)
    {
        try {
            $country = $this->countryRepo->find($id);
            $continents = $this->continentRepo->get();
            return view('country.form')->with(['country' => $country, 'continents' => $continents]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'An error occurred while fetching country data.', 'type' => 'error']);
        }
    }

    public function update(CountryRequest $request, $id)
    {
        try {
            $this->countryRepo->updateCountry($request->validated(), $id);
            return redirect()->route('admin.country')->with(['message' => 'Country updated successfully!', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'An error occurred while fetching country data.', 'type' => 'error']);
        }
    }

    public function delete($id)
    {
        try {
            $this->countryRepo->delete($id);
            return redirect()->back()->with(['message' => 'Country deleted successfully!', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'An error occurred while fetching country data.', 'type' => 'error']);
        }
    }
}
