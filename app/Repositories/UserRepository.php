<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $userModel;
    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }
    public function store($user) {
        return $this->userModel->create($user);
    }
    public function setIsVerifiedTrue($phone, $data) {
        return $this->userModel->where('phone', $phone)->update($data);
    }
    public function profile() {
        return auth()->user();
    }
}
