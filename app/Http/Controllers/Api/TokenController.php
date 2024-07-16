<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TokenRequest;
use App\Interfaces\Api\TokenControllerInterface;
use Illuminate\Support\Facades\Auth;

class TokenController extends BaseController implements TokenControllerInterface
{    
    public function createToken(TokenRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $success = $request->user()->createToken($request->email);

            return $this->sendResponse(['token' => $success->plainTextToken], 'Token criado com sucesso.');
        }

        return response()->json('As credenciais informadas não coincidem com nossos registros. Por favor, verifique seu e-mail e senha e tente novamente.', 401);

    }
}
