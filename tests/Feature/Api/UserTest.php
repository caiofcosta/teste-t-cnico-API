<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->token = $this->user->createToken($this->user->email)->plainTextToken;
});

test('tenta recuperar uma lista de usuarios', function () {

    User::factory(25)->create();

    $response = $this->getJson('/api/users?page=1', ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(200);

    $response->assertJsonStructure([
        'success',
        'data' => [
            'records' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'role',
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
    // +1 que foi gerado para autenticar o token
    $response->assertJsonPath('data.meta.total', 26);

});

test('tenta criar um novo usuario', function () {
    $userData = [
        'name' => 'Novo Usuário',
        'email' => 'novousuario@example.com',
        'role' => 'user',
        'password' => 'password',
        'password_confirmed' => 'password',
    ];

    $response = $this->postJson('/api/users', $userData, ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(201);
    unset($userData['password_confirmed'], $userData['password']);

    $this->assertDatabaseHas('users', $userData);
});

test('tenta criar um novo usuario sem dados espera erros', function () {
    $userData = [];

    $response = $this->postJson('/api/users', $userData, ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(422);

    $response->assertJsonStructure([
        'message',
        'errors' => [
            'name',
            'email',
            'role',
            'password',
        ],
    ]);
});

test('tenta recuperar um unico usuario', function () {
    $user = User::factory()->create();

    $response = $this->getJson('/api/users/'.$user->id, ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(200)
        ->assertJsonFragment(['name' => $user->name]);
});

test('tenta atualizar um usuario', function () {
    $user = User::factory()->create();

    $updateData = ['name' => 'Usuário Atualizado'];

    $response = $this->putJson('/api/users/'.$user->id, $updateData, ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(200)
        ->assertJsonFragment(['name' => 'Usuário Atualizado']);

    $this->assertDatabaseHas('users', ['name' => 'Usuário Atualizado']);
});

test('tenta atualizar um usuario sem dados esperado erro', function () {
    $user = User::factory()->create();

    $userData = [
        'name' => '',
        'email' => '',
        'password' => '',
    ];

    $response = $this->putJson('/api/users/'.$user->id, $userData, ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'email',
                'password',
            ],
        ]);
});

test('tenta deletar um usuario', function () {
    $user = User::factory()->create();

    $response = $this->deleteJson('/api/users/'.$user->id, [], ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(200);

    $this->assertSoftDeleted('users', ['id' => $user->id]);
});

test('tenta deletar um usuario nao existente espera erro', function () {

    $response = $this->deleteJson('/api/users/'. 99999999999, [], ['Authorization' => "Bearer $this->token"]);

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'Usuário não encontrado',
        ]);

});
