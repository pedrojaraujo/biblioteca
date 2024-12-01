<?php
// src/Services/LivroService.php

namespace Pedrojaraujo\Biblioteca\Services;

use Pedrojaraujo\Biblioteca\Interfaces\LivroRepositoryInterface;
use Pedrojaraujo\Biblioteca\Repositories\LivroRepository;


class LivroService
{
    private LivroRepositoryInterface $livroRepository;

    public function __construct()
    {
        $this->livroRepository = new LivroRepository();
    }

    public function listarLivros()
    {
        return $this->livroRepository->buscarTodos();
    }

    public function obterLivro(int $id)
    {
        return $this->livroRepository->buscarPorId($id);
    }

    public function criarLivro(array $data)
    {
        return $this->livroRepository->criar($data);
    }

    public function atualizarLivro(int $id, array $data)
    {
        return $this->livroRepository->atualizar($id, $data);
    }

    public function deletarLivro(int $id)
    {
        return $this->livroRepository->deletar($id);
    }
}
