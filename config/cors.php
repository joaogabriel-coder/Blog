<?php

return [

    /*
    |--------------------------------------------------------------------------
    | CORS PATHS
    |--------------------------------------------------------------------------
    |
    | Rotas que devem ter CORS habilitado. O 'api/*' garante que todas as suas
    | rotas de API funcionem.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // Permite todos os métodos (GET, POST, etc.)

    /*
    |--------------------------------------------------------------------------
    | ORIGENS PERMITIDAS
    |--------------------------------------------------------------------------
    |
    | Lista de domínios que podem fazer requisições à sua API.
    |
    */

    'allowed_origins' => [
        '*', // <--- SEU DOMÍNIO DA VERCEL
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // Permite todos os cabeçalhos

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];