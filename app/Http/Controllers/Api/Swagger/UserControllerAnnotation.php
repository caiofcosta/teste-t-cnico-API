<?php 
namespace App\Http\Controllers\Api\Swagger;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;

class UserControllerAnnotation extends BaseController{
     /**
     * @OA\Get(
     *     path="/users",
     *     tags={"Usuários"},
     *     summary="Lista todos os usuários",
     *     description="Para testar é preciso estar autenticado",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="records", type="array",
     *                     @OA\Items(
     *                         @OA\Property(property="id", type="integer", example=39),
     *                         @OA\Property(property="name", type="string", example="Admin"),
     *                         @OA\Property(property="email", type="string", format="email", example="admin@example.com"),
     *                         @OA\Property(property="role", type="string", example="admin"),
     *                     ),
     *                 ),
     *                 @OA\Property(property="links", type="object",
     *                     @OA\Property(property="first", type="string", example="http://localhost/api/users?page=1"),
     *                     @OA\Property(property="last", type="string", example="http://localhost/api/users?page=16"),
     *                     @OA\Property(property="prev", type="string", example="null"),
     *                     @OA\Property(property="next", type="string", example="http://localhost/api/users?page=2"),
     *                     @OA\Property(property="self", type="string", example="http://localhost/api/users"),
     *                 ),
     *                 @OA\Property(property="meta", type="object",
     *                     @OA\Property(property="total", type="integer", example=152),
     *                     @OA\Property(property="per_page", type="integer", example=10),
     *                     @OA\Property(property="current_page", type="integer", example=1),
     *                     @OA\Property(property="last_page", type="integer", example=16),
     *                     @OA\Property(property="from", type="integer", example=1),
     *                     @OA\Property(property="to", type="integer", example=10),
     *                 ),
     *             ),
     *             @OA\Property(property="message", type="string", example="Lista de usuários")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),   
     *     security={
     *         {"sanctum": {}}
     *     }
     * )
     */
    public function index(){
        //
    }
    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     tags={"Usuários"},
     *     summary="Exibe um usuário específico",
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
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     *             @OA\Property(property="role", type="string", example="admin")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function show(User $user){
        //
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     tags={"Usuários"},
     *     summary="Insere um novo usuário",
     *     description="Para testar é preciso estar autenticado",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="John Doe"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 example="john.doe@example.com"
     *             ),
     *             @OA\Property(
     *                 property="role",
     *                 type="string",
     *                 example="admin"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 type="string",
     *                 example="password"
     *             ),
     *             @OA\Property(
     *                 property="password_confirmed",
     *                 type="string",
     *                 example="password"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User successfully created",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=193),
     *                 @OA\Property(property="name", type="string", example="Novo Usuário"),
     *                 @OA\Property(property="email", type="string", format="email", example="novousuario@example.com"),
     *                 @OA\Property(property="role", type="string", example="admin")
     *             ),
     *             @OA\Property(property="message", type="string", example="Usuario cadastrado")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),   
     *     @OA\Response(
     *         response=422,
     *         description="Validação de dados falhou",     
     *           @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="O campo nome é obrigatório. (e mais 3 erros)"),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="name", type="array",
     *                     @OA\Items(type="string", example="O campo nome é obrigatório.")
     *                 ),
     *                 @OA\Property(property="email", type="array",
     *                     @OA\Items(type="string", example="O campo email é obrigatório.")
     *                 ),
     *                 @OA\Property(property="role", type="array",
     *                     @OA\Items(type="string", example="O campo role é obrigatório.")
     *                 ),
     *                 @OA\Property(property="password", type="array",
     *                     @OA\Items(type="string", example="O campo senha é obrigatório.")
     *                 )
     *             )
     *         )
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function store(UserStoreRequest $request){
        //
    }
    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     tags={"Usuários"},
     *     summary="Atualiza um usuário existente",
     *     description="Para testar é preciso estar autenticado",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do usuário",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", example="Novo Nome"),
     *             @OA\Property(property="email", type="string", format="email", example="novoemail@example.com"),
     *             @OA\Property(property="role", type="string", example="user"),
     *             @OA\Property(property="password", type="string", example="novasenha"),
     *             @OA\Property(property="password_confirmed", type="string", example="novasenha")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="Novo Nome"),
     *             @OA\Property(property="email", type="string", format="email", example="novoemail@example.com"),
     *             @OA\Property(property="role", type="string", example="user")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function update(UserUpdateRequest $request, User $user){
        //
    }

    public function destroy(int $id){
        //
    }
}