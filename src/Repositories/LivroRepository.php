<?php

namespace Pedrojaraujo\Biblioteca\Repositories;
use PDO;
use PDOException;
use Pedrojaraujo\Biblioteca\Models\Livro;
use Pedrojaraujo\Biblioteca\Interfaces\LivroRepositoryInterface;


class LivroRepository implements LivroRepositoryInterface
{
    private PDO $conn;

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/config.php';
        $db = $config['db'];

        try {
            $this->conn = new PDO("mysql:host={$db['host']};dbname={$db['dbname']};charset=utf8", $db['user'], $db['pass']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }


    public function buscarTodos(): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM livros");
        $stmt->execute();
        $livros = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $livros[] = new Livro(
                $row['id'],
                $row['titulo'],
                $row['autor'],
                $row['criado_em'],
                $row['atualizado_em']
            );
        }
        return $livros;
    }

    public function buscarPorId(int $id): ?Livro
    {
        $stmt = $this->conn->prepare("SELECT * FROM livros WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Livro(
                $row['id'],
                $row['titulo'],
                $row['autor'],
                $row['criado_em'],
                $row['atualizado_em']
            );
        }
        return null;
    }

    public function criar(array $data): Livro
    {
        $stmt = $this->conn->prepare("INSERT INTO livros (titulo, autor) VALUES (:titulo, :autor)");
        $stmt->bindParam(':titulo', $data['titulo']);
        $stmt->bindParam(':autor', $data['autor']);
        $stmt->execute();
        $id = $this->conn->lastInsertId();
        return $this->buscarPorId((int)$id);
    }

    public function atualizar(int $id, array $data): ?Livro
    {
        $stmt = $this->conn->prepare("UPDATE livros SET titulo = :titulo, autor = :autor WHERE id = :id");
        $stmt->bindParam(':titulo', $data['titulo']);
        $stmt->bindParam(':autor', $data['autor']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $this->buscarPorId($id);
    }

    public function deletar(int $id): bool
    {
        $stmt = $this->conn->prepare("DELETE FROM livros WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
