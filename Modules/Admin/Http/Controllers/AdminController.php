<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Modules\Admin\Services\UserCrudOperationsService;
use App\Http\Resources\UserResource;
use Modules\Admin\Http\Requests\CreateUserRequest;

class AdminController extends Controller
{
    use ApiResponser;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public $userService;
    public function __construct(UserCrudOperationsService $userService) {
        $this->userService = $userService;
    }
    public function index()
    {
        $users = $this->userService->users();
        return $this->successResponse(UserResource::collection($users), "", 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->userService->store($request->all());
        return $this->successResponse(new UserResource($user), "", 200);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $user = $this->userService->show($id);
        return $this->successResponse(new UserResource($user), "", 200);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update($id, CreateUserRequest $request)
    {
        $user = $this->userService->update($id, $request->all());
        return $this->successResponse($user, "", 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $deleteUser = $this->userService->delete($id);
        return $this->successResponse($deleteUser, "Deleted Successfully", 200);
    }
}
