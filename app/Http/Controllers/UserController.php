<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Mail\ForgotPasswordEmail;
use App\Repository\UserRepository;
use Carbon\Carbon;
use IAnanta\UserManagement\Models\Admin;
use Exception;
use DataTables;
use IAnanta\UserManagement\Repository\RoleRepository;
use Illuminate\Http\Request;


class UserController extends Controller
{
    private $repo, $roleRepo;
    public function __construct(UserRepository $repo, RoleRepository $roleRepo)
    {
        $this->repo = $repo;
        $this->roleRepo = $roleRepo;
    }

    public function index()
    {
        try {
            if (request()->ajax()) {
                $data = $this->repo->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->rawColumns([])
                    ->make(true);
            }
            return view('user.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function create()
    {
        try {
            $data['roles'] = $this->roleRepo->getRoles();
            return view('user.form')->with($data);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function store(UserRequest $request)
    {
        try {
            $this->repo->store($request->validated());
            return redirect()->route('admin.user')->with(['message' => 'Users created successfully!', 'type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function edit($id)
    {
        try {
            $data['roles'] = $this->roleRepo->getRoles();
            $data['user'] = $this->repo->find($id);
            return view('user.form')->with($data);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $this->repo->update($request->validated(), $id);
            return redirect()->route('admin.user')->with(['message' => 'Users updated successfully!', 'type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function delete($id)
    {
        try {
            $this->repo->delete($id);
            return redirect()->back()->with(['message' => 'Users deleted successfully!', 'type' => 'success']);
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }


    public function validatePasswordRequest(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            $user = $this->repo->getUserByEmail($request->email);
            if (!$user) {
                return redirect()->back()->with(['message' => 'Email does not exist!', 'type' => 'error']);
            }

            $tokenData = $this->repo->createOrUpdateResetToken($request->email);

            if ($this->sendResetEmail($request->email, $tokenData->token)) {
                return redirect()->back()->with(['message' => 'A reset link has been sent to your email address.', 'type' => 'success']);
            } else {
                return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }

    private function sendResetEmail($email, $token)
    {
        try {
            $this->repo->getUserByEmail($email);
            // Generate the password reset link
            $link = url('/') . '/password/reset/' . $token;
            // dd($link);
            // Mail::to($user->email)->send(new ForgotPasswordEmail($link));
            // return true;
        } catch (Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function passwordReset($token)
    {
        try {
            $email = $this->repo->getPasswordResetEmail($token);
            if ($email) {
                return view('auth.forgotpassword', ['email' => $email]);
            } else {
                return redirect()->back()->with(['message' => 'Email not found!', 'type' => 'error']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function changePasswordPost(Request $request)
    {
        try {
            $request->validate([
                'password' => 'required|min:4',
                'confirm_password' => 'required|same:password',
                'email' => 'required|email'
            ]);

            $email = $request->input('email');
            $result = $this->repo->resetPassword($email, $request->password);
            if ($result) {
                return redirect()->route('login')->with(['message' => 'Password has been changed successfully!.', 'type' => 'success']);
            } else {
                return redirect()->back()->with(['message' => 'Failed to change the password!', 'type' => 'error']);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['message' => $e->getMessage(), 'type' => 'error']);
        }
    }
}
