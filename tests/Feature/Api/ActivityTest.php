<?php

use App\Models\Activity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken($this->user->email)->plainTextToken;
});

test('tenta recuperar uma lista de atividade', function () {

    Activity::factory(25)->create();

    $response = $this->getJson('/api/activities?page=1', ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(200);

    $response->assertJsonStructure([
        'success',
        'data' => [
            'records' => [
                '*' => [
                    'id',
                    'user_id',
                    'title',
                    'type',
                    'description',
                    'start_date',
                    'end_date',
                    'completion_date',
                    'status',
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
                'self',
            ],
            'meta' => [
                'total',
                'per_page',
                'current_page',
                'last_page',
                'from',
                'to',
            ],
        ],
        'message',
    ]);

    $response->assertJsonPath('data.meta.total', 25);

});

test('tenta criar um nova atividade', function () {
    $activitiesData = [
        'user_id' => $this->user->id,
        'title' => 'titulo caio',
        'type' => 'task',
        'description' => 'descricao caio',
        'start_date' => '2024-07-10 08:00:00',
        'end_date' => '2024-07-10 09:00:00',
        'status' => 'aberto',
    ];

    $response = $this->postJson('/api/activities', $activitiesData, ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(201);

    $this->assertDatabaseHas('activities', $activitiesData);
});
test('tenta criar um nova atividade dentro da mesma data', function () {
    $activitiesData = [
        'user_id' => $this->user->id,
        'title' => 'titulo caio',
        'type' => 'task',
        'description' => 'descricao caio',
        'start_date' => '2024-07-10 08:00:00',
        'end_date' => '2024-07-10 09:00:00',
        'status' => 'aberto',
    ];

    $response = $this->postJson('/api/activities', $activitiesData, ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(201);

    $response = $this->postJson('/api/activities', $activitiesData, ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(422)
        ->assertExactJson([
            'success' => false,
            'message' => 'Já existe uma atividade cadastrada para este usuário nesta data ou período.',
        ]);
});

test('tenta criar um nova atividade sem dados espera erros', function () {
    $userData = [];

    $response = $this->postJson('/api/activities', $userData, ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(422);

    $response->assertJsonStructure([
        'message',
        'errors' => [
            'user_id',
            'title',
            'type',
            'start_date',
            'end_date',
        ],
    ]);
});

test('tenta recuperar um unica atividade', function () {
    $activitie = Activity::factory()->create();

    $response = $this->postJson('/api/activities/search', ['id' => $activitie->id], ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'records' => [
                    '*' => [
                        'id',
                        'user_id',
                        'title',
                        'type',
                        'description',
                        'start_date',
                        'end_date',
                        'completion_date',
                        'status',
                    ],
                ],
                'links' => [
                    'first',
                    'last',
                    'prev',
                    'next',
                    'self',
                ],
                'meta' => [
                    'total',
                    'per_page',
                    'current_page',
                    'last_page',
                    'from',
                    'to',
                ],
            ],
            'message',
        ]);
});

test('tenta atualizar um atividade', function () {
    $activitie = Activity::factory()->create();

    $updateData = ['description' => 'Atividade Atualizado'];

    $response = $this->putJson('/api/activities/'.$activitie->id, $updateData, ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(200)
        ->assertJsonFragment($updateData);

    $this->assertDatabaseHas('activities', $updateData);
});

test('tenta atualizar uma atividade sem dados esperado erro', function () {
    $activitie = Activity::factory()->create();

    $userData = [];

    $response = $this->putJson('/api/activities/'.$activitie->id, $userData, ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(422)
        ->assertExactJson([
            'success' => false,
            'message' => 'Nenhum campo foi enviado na requisição',
        ]);
});

test('tenta deletar um atividade', function () {
    $activitie = Activity::factory()->create();

    $response = $this->deleteJson('/api/activities/'.$activitie->id, [], ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(200);

    $this->assertSoftDeleted('activities', ['id' => $activitie->id]);
});

test('tenta deletar um usuario nao existente espera erro', function () {

    $response = $this->deleteJson('/api/activities/'. 99999999999, [], ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'Atividade não encontrado',
        ]);

});
