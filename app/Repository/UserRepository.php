<?php

namespace App\Repository;

use IAnanta\UserManagement\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class UserRepository
{
  private $query;

  public function __construct(Admin $query)
  {
    $this->query = $query;
  }

  public function get($params = [])
  {
    $query = $this->query->query();
    if (isset($params['isLeadershipBoard']) && !empty($params['isLeadershipBoard'])) {
      $query = $query->leftJoin('applicants', 'applicants.created_by', '=', 'admins.id')
        ->groupBy('admins.id')
        ->select('admins.*', DB::raw('COUNT(applicants.id) as applicants_count'))
        ->orderBy('applicants_count', 'DESC');
    }
    return $query;
  }

  public function store(array $data)
  {
    if (isset($data['image']) && $data['image']) {
      $data['image'] = $this->uploadImage($data['image'], [
        'destination' => 'uploaded/users',
        'image_name' => now()->timestamp,
        'existing_file' => NULL
      ]);
    }
    $updateData = $data;
    unset($updateData['roles']);
    $admin = $this->query->create($updateData);
    if (isset($data['roles']) && !empty($data['roles'])) {
      $admin->roles()->attach($data['roles']);
    }
    return $admin;
  }

  public function find($id)
  {
    return $this->query->findOrFail($id);
  }

  public function update(array $data, int $id)
  {
    $query = $this->find($id);

    if (isset($data['image']) && $data['image']) {
      $data['image'] = $this->uploadImage($data['image'], [
        'destination' => 'uploaded/users',
        'image_name' => now()->timestamp,
        'existing_file' => $query->image
      ]);
    }
    $updatedData = $data;
    unset($updatedData['roles']);
    $query->update($updatedData);
    if (isset($data['roles']) && !empty($data['roles'])) {
      $query->roles()->detach();
      $query->roles()->attach($data['roles']);
    }
    return $query;
  }

  public function delete($id)
  {
    return $this->query->findOrFail($id)->delete();
  }

  public function uploadImage(UploadedFile $file, $params)
  {
    $imageName = $params['image_name'] . '.' . $file->getClientOriginalExtension();
    $file->move($params['destination'], $imageName);
    if (!empty($params['existing_file']) && file_exists(public_path() . '/' . $params['existing_file'])) {
      unlink($params['existing_file']);
    }

    return $params['destination'] . '/' . $imageName;
  }

  public function getPasswordResetEmail($token)
  {
    $email = DB::table('password_reset_tokens')->where('token', $token)->first();
    return $email ? $email->email : null;
  }

  public function resetPassword($email, $password)
  {
    $result = Admin::where('email', $email)->update([
      'password' => Hash::make($password),
    ]);
    return $result;
  }

  public function createOrUpdateResetToken($email)
  {
    $existingToken = DB::table('password_reset_tokens')->where('email', $email)->first();
    if ($existingToken) {
      DB::table('password_reset_tokens')
        ->where('email', $email)
        ->update([
          'token' => Str::random(60),
          'created_at' => Carbon::now()
        ]);
    } else {
      DB::table('password_reset_tokens')->insert([
        'email' => $email,
        'token' => Str::random(60),
        'created_at' => Carbon::now()
      ]);
    }
    return DB::table('password_reset_tokens')->where('email', $email)->first();
  }

  public function getUserByEmail($email)
  {
    return DB::table('admins')->where('email', $email)->first();
  }
}
