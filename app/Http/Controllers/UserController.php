<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepositoryInterface;
use App\Traits\ApiResponser;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    use ApiResponser;
    public function __construct(UserRepositoryInterface $user) {
        $this->user   = $user;
    }
    public function profile() {

        $profile = $this->user->profile();

        return $this->successResponse(new UserResource($profile), "", 200);
    }
}
