<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function update($id, array $data);
    public function findByEmailCaseInsensitive($email);
    public function updatePassword($user, $password);
} 