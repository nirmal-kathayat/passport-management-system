<?php

namespace App\Http\Controllers;

use IAnanta\UserManagement\Models\Role;
use IAnanta\UserManagement\Repository\RoleRepository;
use IAnanta\UserManagement\Repository\PermissionRepository;
use App\Http\Requests\RoleRequest;
use DataTables;

class RoleController extends Controller
{
    private $repo, $permissionRepo;
    public function __construct(RoleRepository $repo, PermissionRepository $permissionRepo)
    {
        $this->repo = $repo;
        $this->permissionRepo = $permissionRepo;
    }

    public function index()
    {
        try {
            if (request()->ajax()) {
                $data = Role::query()->orderBy('created_at', 'asc');
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('permissions', function ($query) {
                        return getRelatedList($query->permissions);
                    })

                    ->rawColumns(['permissions'])
                    ->make(true);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Somthing were wrong', 'type' => 'error']);
        }
        return view('role.index');
    }

    public function create()
    {
        try {
            $data['permissions'] = $this->permissionRepo->getPermissions([
                "paginate" => false
            ]);
            return view('role.form')->with($data);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Somthing were wrong', 'type' => 'error']);
        }
    }

    public function store(RoleRequest $request)
    {
        try {
            $this->repo->storeRole($request->validated());
            return redirect()->route('admin.role')->with(['message' => 'Role created successfully', 'type' => 'success']);
        } catch (Exception $e) {

            return redirect()->back()->with(['message' => 'Somthing were wrong', 'type' => 'error']);
        }
    }

    public function edit($id)
    {
        try {
            $data['permissions'] = $this->permissionRepo->getPermissions([
                "paginate" => false
            ]);
            $data['role'] = $this->repo->findRole($id);
            return view('role.form')->with($data);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Somthing were wrong', 'type' => 'error']);
        }
    }

    public function update(RoleRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data['permissions'] = array_map('intval', $data['permissions']);

            $this->repo->updateRole($data, $id);
            return redirect()->route('admin.role')->with(['message' => 'Role updated successfully', 'type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => 'Somthing were wrong', 'type' => 'error']);
        }
    }

    public function delete($id)
    {
        try {
            $this->repo->deleteRole($id);
            return redirect()->back()->with(['message' => 'Role deleted successfully', 'type' => 'success']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => 'Somthing were wrong', 'type' => 'error']);
        }
    }
}
