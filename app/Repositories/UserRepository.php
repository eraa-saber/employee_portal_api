<?php

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function getAll()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function update($id, array $data)
    {
        $user = User::find($id);
        if ($user) {
            $user->update($data);
        }
        return $user;
    }

    public function findByEmailCaseInsensitive($email)
    {
        // Use the correct field name 'email' as per migration and model
        return User::whereRaw('LOWER(email) = ?', [strtolower($email)])->first();
    }

    public function updatePassword($user, $password)
    {
        $user->password = bcrypt($password);
        $user->save();
        return $user;
    }
} 