<?php

namespace App\Interfaces\Api;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

interface UserControllerInterface
{
    public function index();

    public function show(User $user);

    public function store(UserStoreRequest $request);

    public function update(UserUpdateRequest $request, User $user);

    public function destroy(int $id);
}
