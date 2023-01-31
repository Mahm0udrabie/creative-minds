<?php

namespace App\Repositories;

interface UserRepositoryInterface {
    public function store($user);
    public function setIsVerifiedTrue($data, $phone);
    public function profile();
}
