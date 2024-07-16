<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('tenta criar um token com credenciais inválidas', function () {
    // Tenta criar um token com credenciais inválidas
    $response = $this->postJson('/api/login', [
        'email' => 'email_invalido@example.com',
        'password' => 'senha_incorreta',
    ]);

    // Verifica se a resposta contém a mensagem de erro em português
    $response->assertStatus(401);
    $response->assertExactJson(['As credenciais informadas não coincidem com nossos registros. Por favor, verifique seu e-mail e senha e tente novamente.']);
});

test('tenta cria token com credenciais válidas e retorna mensagem de sucesso', function () {
    $user = User::factory()->create([
        'email' => 'usuario@exemplo.com',
        'role' => 'user',
        'password' => bcrypt('password'),
    ]);

    // Faz a requisição para criar o token
    $response = $this->postJson('/api/login', [
        'email' => 'usuario@exemplo.com',
        'password' => 'password',
    ]);

    // Verifica se a resposta contém o token de autenticação e a mensagem de sucesso em português
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'success',
        'data' => ['token'],
        'message',
    ]);
    $response->assertJsonFragment(['message' => 'Token criado com sucesso.']);
});
