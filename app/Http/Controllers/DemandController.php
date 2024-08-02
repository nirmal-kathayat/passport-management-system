<?php

namespace App\Http\Controllers;

use App\Http\Requests\DemandRequest;
use App\Repository\CountryRepository;
use App\Repository\DemandRepository;
use App\Repository\ExperienceRepository;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    private $demandRepo, $experienceRepo, $countryRepo;
    public function __construct(DemandRepository $demandRepo, CountryRepository $countryRepo, ExperienceRepository $experienceRepo)
    {
        $this->demandRepo = $demandRepo;
        $this->countryRepo = $countryRepo;
        $this->experienceRepo = $experienceRepo;
    }

    public function index()
    {
        try {
            if (request()->ajax()) {
                $data = $this->demandRepo->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns([])
                    ->make(true);
            }
            $experiences = $this->experienceRepo->getExperience();
            $countries = $this->countryRepo->getCountry();
            return view('demands.index')->with(['experiences' => $experiences, 'countries' => $countries]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function create()
    {
        try {
            $experiences = $this->experienceRepo->getExperience();
            $countries = $this->countryRepo->getCountry();
            return view('demands.form')->with(['experiences' => $experiences, 'countries' => $countries]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function store(DemandRequest $request)
    {
        try {
            $data = $this->demandRepo->storeDemand($request->validated());
            return redirect()->route('admin.demand')->with(['message' => 'Demand added successfully', 'type' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function edit($id)
    {
        try {
            $experiences = $this->experienceRepo->getExperience();
            $countries = $this->countryRepo->getCountry();
            $demand = $this->demandRepo->find($id);
            return view('demands.form')->with(['experiences' => $experiences, 'countries' => $countries, 'demand' => $demand]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(DemandRequest $request, $id)
    {
        try {
            $this->demandRepo->update($request->validated(), $id);
            return redirect()->route('admin.demand')->with(['message' => 'Demand updated successfully', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function delete($id)
    {
       try{
        $this->demandRepo->delete($id);
        return redirect()->back()->with(['message' => 'Demand deleted successfully', 'type' => 'success']);
       }catch(\Exception $e){
        return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
       }
    }
}
