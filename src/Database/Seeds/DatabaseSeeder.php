<?php

namespace Biblioteca\Database\Seeds;

use Biblioteca\Database;
use PDO;

class DatabaseSeeder
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function run()
    {
        try {
            $this->pdo->beginTransaction();
            
            $this->seedUsuarios();
            $this->seedLivros();
            
            $this->pdo->commit();
            echo "Seeds executados com sucesso!\n";
        } catch (\Exception $e) {
            $this->pdo->rollBack();
            echo "Erro ao executar seeds: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    private function seedUsuarios()
    {
        $usuarios = [
            [
                'nome' => 'Admin',
                'email' => 'admin@example.com',
                'senha' => password_hash('admin123', PASSWORD_DEFAULT),
                'tipo_usuario' => 'administrador',
                'telefone' => '11999999999',
                'endereco' => 'Rua Admin, 123'
            ],
            [
                'nome' => 'Usuário',
                'email' => 'user@example.com',
                'senha' => password_hash('user123', PASSWORD_DEFAULT),
                'tipo_usuario' => 'usuario_comum',
                'telefone' => '11988888888',
                'endereco' => 'Rua Usuario, 456'
            ]
        ];

        $stmt = $this->pdo->prepare("
            INSERT INTO usuarios (nome, email, senha, tipo_usuario, telefone, endereco) 
            VALUES (:nome, :email, :senha, :tipo_usuario, :telefone, :endereco)
        ");
        
        foreach ($usuarios as $usuario) {
            try {
                $stmt->execute($usuario);
                error_log("Usuário criado: " . $usuario['email']);
            } catch (\PDOException $e) {
                error_log("Erro ao criar usuário: " . $e->getMessage());
            }
        }
        echo "Usuários inseridos com sucesso!\n";
    }

    private function seedLivros()
    {
        // Mantive alguns livros do seu arquivo original para exemplo
        $livros = [
            [
                'titulo' => 'Dom Quixote',
                'autor' => 'Miguel de Cervantes',
                'editora' => 'Editora A',
                'ano_publicacao' => 1605,
                'genero' => 'Romance',
                'sinopse' => 'A história de um nobre que se torna cavaleiro andante.',
                'imagem' => 'dom_quixote.jpg',
                'estoque' => 10
            ],
            [
                'titulo' => '1984',
                'autor' => 'George Orwell',
                'editora' => 'Editora B',
                'ano_publicacao' => 1949,
                'genero' => 'Ficção Científica',
                'sinopse' => 'Um clássico sobre vigilância e controle totalitário.',
                'imagem' => '1984.jpg',
                'estoque' => 5
            ]
            // Você pode adicionar mais livros aqui...
        ];

        $stmt = $this->pdo->prepare("
            INSERT INTO livros (titulo, autor, editora, ano_publicacao, genero, sinopse, imagem, estoque)
            VALUES (:titulo, :autor, :editora, :ano_publicacao, :genero, :sinopse, :imagem, :estoque)
        ");

        foreach ($livros as $livro) {
            $stmt->execute($livro);
        }
        echo "Livros inseridos com sucesso!\n";
    }
} 