<?php 
namespace App\Http\Controllers\Api\Swagger;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\ActivitySearchRequest;
use App\Http\Requests\ActivityStoreRequest;
use App\Http\Requests\ActivityUpdateRequest;
use App\Http\Requests\TokenRequest;
use App\Interfaces\Api\ActivityControllerInterface;
use App\Interfaces\Api\TokenControllerInterface;
use App\Models\Activity;
use App\Models\User;

class ActivityControllerAnnotation extends BaseController implements  ActivityControllerInterface{
    /**
     * @OA\Get(
     *     path="/activities",
     *     tags={"Atividades"},
     *     summary="Lista todas as atividades",
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
     *                         @OA\Property(property="id", type="integer", example=1),
     *                         @OA\Property(property="user_id", type="integer", example=1),
     *                         @OA\Property(property="title", type="string", example="Meeting"),
     *                         @OA\Property(property="type", type="string", example="meeting"),
     *                         @OA\Property(property="description", type="string", example="Discuss project details"),
     *                         @OA\Property(property="start_date", type="string", format="date-time", example="2024-07-17T09:00:00Z"),
     *                         @OA\Property(property="end_date", type="string", format="date-time", example="2024-07-17T10:00:00Z"),
     *                         @OA\Property(property="completion_date", type="string", format="date-time", example="2024-07-17T10:00:00Z"),
     *                         @OA\Property(property="status", type="string", example="active"),
     *                     ),
     *                 ),
     *                 @OA\Property(property="links", type="object",
     *                     @OA\Property(property="first", type="string", example="http://localhost/api/activities?page=1"),
     *                     @OA\Property(property="last", type="string", example="http://localhost/api/activities?page=10"),
     *                     @OA\Property(property="prev", type="string", example="http://localhost/api/activities?page=9"),
     *                     @OA\Property(property="next", type="string", example="http://localhost/api/activities?page=2"),
     *                     @OA\Property(property="self", type="string", example="http://localhost/api/activities"),
     *                 ),
     *                 @OA\Property(property="meta", type="object",
     *                     @OA\Property(property="total", type="integer", example=100),
     *                     @OA\Property(property="per_page", type="integer", example=10),
     *                     @OA\Property(property="current_page", type="integer", example=1),
     *                     @OA\Property(property="last_page", type="integer", example=10),
     *                     @OA\Property(property="from", type="integer", example=1),
     *                     @OA\Property(property="to", type="integer", example=10),
     *                 ),
     *             ),
     *             @OA\Property(property="message", type="string", example="Lista de atividades")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthenticated.")
     *         )
     *     ),   
     *     security={{"sanctum": {}}}
     * )
     */
    public function index(){}
    /**
     * @OA\Post(
     *     path="/activities",
     *     tags={"Atividades"},
     *     summary="Cria uma nova atividade",
     *     description="Para testar é preciso estar autenticado",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Reunião semanal"),
     *             @OA\Property(property="type", type="string", example="meeting"),
     *             @OA\Property(property="description", type="string", example="Discussão sobre os próximos passos do projeto"),
     *             @OA\Property(property="start_date", type="string", format="date-time", example="2024-07-17T09:00:00Z"),
     *             @OA\Property(property="end_date", type="string", format="date-time", example="2024-07-17T10:00:00Z"),
     *             @OA\Property(property="status", type="string", example="aberto"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Atividade cadastrada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="user_id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Reunião semanal"),
     *                 @OA\Property(property="type", type="string", example="meeting"),
     *                 @OA\Property(property="description", type="string", example="Discussão sobre os próximos passos do projeto"),
     *                 @OA\Property(property="start_date", type="string", format="date-time", example="2024-07-17T09:00:00Z"),
     *                 @OA\Property(property="end_date", type="string", format="date-time", example="2024-07-17T10:00:00Z"),
     *                 @OA\Property(property="completion_date", type="string", format="date-time", example=null),
     *                 @OA\Property(property="status", type="string", example="aberto"),
     *             ),
     *             @OA\Property(property="message", type="string", example="Atividade cadastrada")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de validação",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Já existe uma atividade cadastrada para este usuário nesta data ou período."),
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="user_id", type="array",
     *                     @OA\Items(type="string", example="O campo user_id é obrigatório."),
     *                 ),
     *                 @OA\Property(property="title", type="array",
     *                     @OA\Items(type="string", example="O campo title é obrigatório."),
     *                 ),
     *                 @OA\Property(property="type", type="array",
     *                     @OA\Items(type="string", example="O campo type é obrigatório."),
     *                 ),
     *                 @OA\Property(property="start_date", type="array",
     *                     @OA\Items(type="string", example="O campo start_date é obrigatório."),
     *                 ),
     *                 @OA\Property(property="end_date", type="array",
     *                     @OA\Items(type="string", example="O campo end_date é obrigatório."),
     *                 ),
     *             )
     *         )
     *     ),
     *     security={{"sanctum": {}}}
     * )
     */
    public function store(ActivityStoreRequest $request){}

    /**
     * @OA\Post(
     *     path="/activities/search",
     *     tags={"Atividades"},
     *     summary="Busca atividades com base em critérios",
     *     description="Para testar é preciso estar autenticado",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="description",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="start_date",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", format="date-time")
     *     ),
     *     @OA\Parameter(
     *         name="end_date",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", format="date-time")
     *     ),
     *     @OA\Parameter(
     *         name="completion_date",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string", format="date-time")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de atividades encontradas",
     *         @OA\JsonContent(
     *             @OA\Property(property="records", type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="user_id", type="integer", example=1),
     *                     @OA\Property(property="title", type="string", example="Reunião semanal"),
     *                     @OA\Property(property="type", type="string", example="meeting"),
     *                     @OA\Property(property="description", type="string", example="Discussão sobre os próximos passos do projeto"),
     *                     @OA\Property(property="start_date", type="string", format="date-time", example="2024-07-17T09:00:00Z"),
     *                     @OA\Property(property="end_date", type="string", format="date-time", example="2024-07-17T10:00:00Z"),
     *                     @OA\Property(property="completion_date", type="string", format="date-time", example=null),
     *                     @OA\Property(property="status", type="string", example="aberto"),
     *                 ),
     *             ),
     *             @OA\Property(property="links", type="object",
     *                 @OA\Property(property="first", type="string", example="http://localhost/api/activities/search?page=1"),
     *                 @OA\Property(property="last", type="string", example="http://localhost/api/activities/search?page=16"),
     *                 @OA\Property(property="prev", type="string", example="null"),
     *                 @OA\Property(property="next", type="string", example="http://localhost/api/activities/search?page=2"),
     *                 @OA\Property(property="self", type="string", example="http://localhost/api/activities/search"),
     *             ),
     *             @OA\Property(property="meta", type="object",
     *                 @OA\Property(property="total", type="integer", example=152),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=16),
     *                 @OA\Property(property="from", type="integer", example=1),
     *                 @OA\Property(property="to", type="integer", example=10),
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     * )
     */
    public function search(ActivitySearchRequest $request){}
    /**
     * @OA\Put(
     *     path="/activities/{activity}",
     *     tags={"Atividades"},
     *     summary="Atualiza uma atividade existente",
     *     description="Para testar é preciso estar autenticado",
     *     @OA\Parameter(
     *         name="activity",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="type", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(property="start_date", type="string", format="date-time"),
     *             @OA\Property(property="end_date", type="string", format="date-time"),
     *             @OA\Property(property="status", type="string", enum={"aberto", "concluído"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Atividade atualizada com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Reunião semanal"),
     *             @OA\Property(property="type", type="string", example="meeting"),
     *             @OA\Property(property="description", type="string", example="Discussão sobre os próximos passos do projeto"),
     *             @OA\Property(property="start_date", type="string", format="date-time", example="2024-07-17T09:00:00Z"),
     *             @OA\Property(property="end_date", type="string", format="date-time", example="2024-07-17T10:00:00Z"),
     *             @OA\Property(property="completion_date", type="string", format="date-time", example=null),
     *             @OA\Property(property="status", type="string", example="aberto"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     ),
     * )
     */
    public function update(ActivityUpdateRequest $request, Activity $activity){}
    /**
     * @OA\Delete(
     *     path="/activities/{activity}",
     *     tags={"Atividades"},
     *     summary="Deleta uma atividade existente",
     *     description="Para testar é preciso estar autenticado",
     *     @OA\Parameter(
     *         name="activity",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Atividade deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Atividade não encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Atividade não encontrada")
     *         )
     *     ),
     * )
     */
    public function destroy(int $id){}

}