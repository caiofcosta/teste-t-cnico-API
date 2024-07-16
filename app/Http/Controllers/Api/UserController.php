<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\Api\UserIndexResource;
use App\Http\Resources\Api\UserShowResource;
use App\Http\Resources\Api\UserStoreResource;
use App\Http\Resources\Api\UserUpdateResource;
use App\Interfaces\Api\UserControllerInterface;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController implements UserControllerInterface
{
   
    public function index()
    {
        $users = User::paginate(10);

        return $this->sendResponse(new UserIndexResource($users), 'Lista  de usuarios');
    }

    public function store(UserStoreRequest $request)
    {
        $new = User::create($request->validated());

        return $this->sendResponse(new UserStoreResource($new), 'Usuario cadastrado', 201);
    }

    public function show(User $user)
    {
        return $this->sendResponse(new UserShowResource($user), 'Usuario encontrado', 200);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        return $this->sendResponse(new UserUpdateResource($user), 'Usuario atualizado', 200);
    }
    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     tags={"Usuários"},
     *     summary="Deleta um usuário existente",
     *     description="Para testar é preciso estar autenticado",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do usuário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuário deletado com sucesso",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Usuário deletado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (! $user) {
            return $this->sendError('Usuário não encontrado', [], 404);
        }

        $user->delete();

        return $this->sendResponse('', 'Usuario deletado', 200);
    }
}
