<?php

namespace Biblioteca\Models;

use Biblioteca\Database;
use PDO;
use DateTime;

class Emprestimo
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function createLoan($livro_id, $usuario_id)
    {
        try {
            $pdo = $this->db->getPdo();
            
            // Verifica se o livro está disponível
            $stmt = $pdo->prepare("SELECT estoque FROM livros WHERE id_livro = ?");
            $stmt->execute([$livro_id]);
            $livro = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($livro['estoque'] <= 0) {
                throw new \Exception('Livro não disponível para empréstimo');
            }

            // Data de devolução prevista (15 dias a partir de hoje)
            $data_devolucao = new DateTime();
            $data_devolucao->modify('+15 days');

            // Inicia transação
            $pdo->beginTransaction();

            // Cria o empréstimo
            $stmt = $pdo->prepare("
                INSERT INTO emprestimos (id_livro, id_usuario, data_devolucao_prevista, status)
                VALUES (?, ?, ?, 'ativo')
            ");
            $stmt->execute([
                $livro_id,
                $usuario_id,
                $data_devolucao->format('Y-m-d H:i:s')
            ]);

            // Atualiza o estoque do livro
            $stmt = $pdo->prepare("
                UPDATE livros 
                SET estoque = estoque - 1 
                WHERE id_livro = ?
            ");
            $stmt->execute([$livro_id]);

            $pdo->commit();
            return true;

        } catch (\Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    public function returnBook($emprestimo_id)
    {
        try {
            $pdo = $this->db->getPdo();
            
            // Inicia transação
            $pdo->beginTransaction();

            // Busca informações do empréstimo
            $stmt = $pdo->prepare("
                SELECT id_livro, status 
                FROM emprestimos 
                WHERE id_emprestimo = ?
            ");
            $stmt->execute([$emprestimo_id]);
            $emprestimo = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$emprestimo) {
                throw new \Exception('Empréstimo não encontrado');
            }

            if ($emprestimo['status'] === 'finalizado') {
                throw new \Exception('Este empréstimo já foi finalizado');
            }

            // Atualiza o empréstimo
            $stmt = $pdo->prepare("
                UPDATE emprestimos 
                SET status = 'finalizado',
                    data_devolucao_real = CURRENT_TIMESTAMP
                WHERE id_emprestimo = ?
            ");
            $stmt->execute([$emprestimo_id]);

            // Atualiza o estoque do livro
            $stmt = $pdo->prepare("
                UPDATE livros 
                SET estoque = estoque + 1 
                WHERE id_livro = ?
            ");
            $stmt->execute([$emprestimo['id_livro']]);

            $pdo->commit();
            return true;

        } catch (\Exception $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $e;
        }
    }

    public function getAllLoans()
    {
        $pdo = $this->db->getPdo();
        $stmt = $pdo->query("
            SELECT e.*, l.titulo as livro_titulo, u.nome as usuario_nome
            FROM emprestimos e
            JOIN livros l ON e.id_livro = l.id_livro
            JOIN usuarios u ON e.id_usuario = u.id_usuario
            WHERE e.deleted_at IS NULL
            ORDER BY e.data_emprestimo DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLoansByUser($usuario_id)
    {
        $pdo = $this->db->getPdo();
        $stmt = $pdo->prepare("
            SELECT e.*, l.titulo as livro_titulo
            FROM emprestimos e
            JOIN livros l ON e.id_livro = l.id_livro
            WHERE e.id_usuario = ? AND e.deleted_at IS NULL
            ORDER BY e.data_emprestimo DESC
        ");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}