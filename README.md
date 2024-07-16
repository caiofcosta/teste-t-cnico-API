# Projeto Laravel com Docker e Sail

Este é um projeto Laravel que utiliza Docker com Sail para gerenciar o ambiente de desenvolvimento, MySQL como banco de dados, e inclui autenticação via Sanctum e testes utilizando SQLite.

## Instalação

### Pré-requisitos

- Docker
- Docker Compose


Copie o arquivo de ambiente de exemplo e configure suas variáveis de ambiente:
cp .env.example .env

apos copiar .env use comando docker para instalar container:
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs

gerar chave:
./vendor/bin/sail artisan key:generate


Inicie o ambiente Docker usando Sail:
./vendor/bin/sail up -d


Instale as dependências PHP:
./vendor/bin/sail composer install


Execute as migrações do banco de dados e os seeders:
./vendor/bin/sail artisan migrate --seed

Gerar a documentação Swagger:
./vendor/bin/sail artisan l5-swagger:generate


Utilização
Para acessar a aplicação, utilize o endereço fornecido pelo Docker após iniciar o Sail.

Autenticação
Este projeto utiliza Laravel Sanctum para autenticação. Para obter um token de autenticação:

Faça uma solicitação POST para /api/login com suas credenciais.

Use o token retornado no cabeçalho Authorization para acessar endpoints protegidos.


Testes
Os testes são executados utilizando SQLite para simplicidade e rapidez:
./vendor/bin/sail test