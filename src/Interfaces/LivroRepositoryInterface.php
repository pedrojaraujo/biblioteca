<?php

namespace Pedrojaraujo\Biblioteca\Interfaces;

use Pedrojaraujo\Biblioteca\Models\livro;


interface LivroRepositoryInterface
{
    public function buscarTodos(): array;
    public function buscarPorId(int $id): ?Livro;
    public function criar(array $data): Livro;
    public function atualizar(int $id, array $data): ?Livro;
    public function deletar(int $id): bool;
}
