<?php
namespace Modules\Admin\Services;

use App\Models\User;

class UserCrudOperationsService {

    protected $user;
    public function __construct(User $user) {
        $this->user = $user;
    }
    public function users() {
        return $this->user->all();
    }
    public function show($id) {
        return $this->user->whereId($id)->first();
    }
    public function store($data) {
        return $this->user->create($data);
    }

    public function update($id, $data) {
        return $this->user->where('id', $id)->update($data);
    }

    public function delete($id) {
        return $this->user->where('id',$id)->delete();
    }
}
