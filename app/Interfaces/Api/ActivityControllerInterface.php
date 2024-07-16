<?php

namespace App\Interfaces\Api;

use App\Http\Requests\ActivitySearchRequest;
use App\Http\Requests\ActivityStoreRequest;
use App\Http\Requests\ActivityUpdateRequest;
use App\Http\Requests\TokenRequest;
use App\Models\Activity;

interface ActivityControllerInterface
{
    public function index();

    public function store(ActivityStoreRequest $request);

    public function search(ActivitySearchRequest $request);

    public function update(ActivityUpdateRequest $request, Activity $activity);

    public function destroy(int $id);

}
