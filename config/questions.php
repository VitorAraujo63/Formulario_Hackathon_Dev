<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Gabarito das Questões do Hackathon
    |--------------------------------------------------------------------------
    |
    | Aqui definimos os índices das respostas corretas para cada área.
    | Os índices começam em 0 (primeira opção) até 3 (quarta opção).
    |
    | Estrutura: [pergunta1, pergunta2, pergunta3, pergunta4, pergunta5, pergunta6]
    |
    */

    'Front-End' => [
        0, // Resposta correta da pergunta 1 (Índice 0, 1, 2 ou 3)
        1, // Resposta correta da pergunta 2
        2, // Resposta correta da pergunta 3
        3, // ...
        0,
        1
    ],

    'Back-End' => [
        1, 2, 0, 3, 1, 0 // Ajuste conforme o gabarito real
    ],

    'Full-Stack' => [
        0, 0, 1, 1, 2, 2 // Ajuste conforme o gabarito real
    ],

    'Documentação Figma' => [
        3, 2, 1, 0, 3, 2 // Ajuste conforme o gabarito real
    ],
];
