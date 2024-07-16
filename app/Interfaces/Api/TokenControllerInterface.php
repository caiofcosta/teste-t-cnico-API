<?php

namespace App\Interfaces\Api;

use App\Http\Requests\TokenRequest;

interface TokenControllerInterface
{
    public function createToken(TokenRequest $request);

}
