<?php 
namespace App\Http\Controllers\Api\Swagger;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\TokenRequest;
use App\Interfaces\Api\TokenControllerInterface;
use App\Models\User;

class TokenControllerAnnotation extends BaseController implements  TokenControllerInterface{
    /**
     * @OA\Post(
     *      path="/login",
     *      tags={"Autenticacão"},
     *      summary="Gera token",
     *      description="Gera Token para usar API",
     *      @OA\RequestBody(
     *          required=true,
     *          description="User credentials",
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *              @OA\Property(property="password", type="string", format="passwordTeste", example="password")
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Token created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="IZQp6HteYq8...")
     *             ),
     *             @OA\Property(property="message", type="string", example="Token criado com sucesso.")
     *         )
     *     ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *      )
     * )
     */
    public function createToken(TokenRequest $request)
    {
        //
    }
}