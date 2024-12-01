<?php
// src/Controllers/LivroController.php

namespace Pedrojaraujo\Biblioteca\Controllers;

use Pedrojaraujo\Biblioteca\Services\LivroService;
use Pedrojaraujo\Biblioteca\Core\Request;
use Pedrojaraujo\Biblioteca\Core\Response;

class LivroController
{
    private LivroService $livroService;

    public function __construct()
    {
        $this->livroService = new LivroService();
    }

    public function index()
    {
        $livros = $this->livroService->listarLivros();
        $data = array_map(function ($livro) {
            return [
                'id' => $livro->getId(),
                'titulo' => $livro->getTitulo(),
                'autor' => $livro->getAutor(),
                'criado_em' => $livro->getCriadoEm(),
                'atualizado_em' => $livro->getAtualizadoEm(),
            ];
        }, $livros);

        Response::json($data);
    }

    public function show($vars)
    {
        $id = (int)$vars['id'];
        $livro = $this->livroService->obterLivro($id);
        if ($livro) {
            $data = [
                'id' => $livro->getId(),
                'titulo' => $livro->getTitulo(),
                'autor' => $livro->getAutor(),
                'criado_em' => $livro->getCriadoEm(),
                'atualizado_em' => $livro->getAtualizadoEm(),
            ];
            Response::json($data);
        } else {
            Response::json(['message' => 'Livro não encontrado'], 404);
        }
    }

    public function store()
    {
        $data = Request::getBody();
        if (isset($data['titulo']) && isset($data['autor'])) {
            $livro = $this->livroService->criarLivro($data);
            $response = [
                'id' => $livro->getId(),
                'titulo' => $livro->getTitulo(),
                'autor' => $livro->getAutor(),
                'criado_em' => $livro->getCriadoEm(),
                'atualizado_em' => $livro->getAtualizadoEm(),
            ];
            Response::json($response, 201);
        } else {
            Response::json(['message' => 'Dados inválidos'], 400);
        }
    }

    public function update($vars)
    {
        $id = (int)$vars['id'];
        $data = Request::getBody();
        if (isset($data['titulo']) && isset($data['autor'])) {
            $livro = $this->livroService->atualizarLivro($id, $data);
            if ($livro) {
                $response = [
                    'id' => $livro->getId(),
                    'titulo' => $livro->getTitulo(),
                    'autor' => $livro->getAutor(),
                    'criado_em' => $livro->getCriadoEm(),
                    'atualizado_em' => $livro->getAtualizadoEm(),
                ];
                Response::json($response);
            } else {
                Response::json(['message' => 'Livro não encontrado'], 404);
            }
        } else {
            Response::json(['message' => 'Dados inválidos'], 400);
        }
    }

    public function destroy($vars)
    {
        $id = (int)$vars['id'];
        $deleted = $this->livroService->deletarLivro($id);
        if ($deleted) {
            Response::json(['message' => 'Livro deletado com sucesso']);
        } else {
            Response::json(['message' => 'Livro não encontrado'], 404);
        }
    }
}
