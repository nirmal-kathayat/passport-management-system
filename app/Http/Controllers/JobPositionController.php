<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobPostionRequest;
use App\Repository\JobPositionRepository;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{
    private $positionRepo;
    public function __construct(JobPositionRepository $positionRepo)
    {
        $this->positionRepo = $positionRepo;
    }

    public function index()
    {
        try {
            if (request()->ajax()) {
                $data = $this->positionRepo->dataTable();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns([])
                    ->make(true);
            }
            return view('jobPosition.index');
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Something went wrong!', 'type' => 'error']);
        }
    }
    public function create()
    {
        try {
            return view('jobPosition.form');
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Something went wrong!', 'type' => 'error']);
        }
    }

    public function store(JobPostionRequest $request)
    {
        try {
            $data = $this->positionRepo->storePosition($request->validated());
            return redirect()->route('admin.position')->with(['message' => 'Job Position added successfully!', 'type' => 'success', 'data' => $data]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Something went wrong!', 'type' => 'error']);
        }
    }

    public function edit($id)
    {
        try {
            $position = $this->positionRepo->find($id);
            return view('jobPosition.form')->with(['position' => $position]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Something went wrong!', 'type' => 'error']);
        }
    }
    public function update(JobPostionRequest $request, $id)
    {
        try {
            $this->positionRepo->update($request->validated(), $id);
            return redirect()->route('admin.position')->with(['message' => 'Job Position updated successfully!', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Something went wrong!', 'type' => 'error']);
        }
    }

    public function delete($id)
    {
        try {
            $this->positionRepo->delete($id);
            return redirect()->back()->with(['message' => 'Job Position deleted successfully!', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Something went wrong!', 'type' => 'error']);
        }
    }
}
