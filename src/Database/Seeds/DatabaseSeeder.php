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

    public function run(): void
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

    private function seedUsuarios(): void
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
            ],
            [
                'titulo' => 'O Grande Gatsby',
                'autor' => 'F. Scott Fitzgerald',
                'editora' => 'Editora C',
                'ano_publicacao' => 1925,
                'genero' => 'Ficção',
                'sinopse' => 'A história do misterioso milionário Jay Gatsby.',
                'imagem' => 'o_grande_gatsby.jpg',
                'estoque' => 8
            ],
            [
                'titulo' => 'A Revolução dos Bichos',
                'autor' => 'George Orwell',
                'editora' => 'Editora B',
                'ano_publicacao' => 1945,
                'genero' => 'Fábula Política',
                'sinopse' => 'Uma sátira sobre a Revolução Russa.',
                'imagem' => 'a_revolucao_dos_bichos.jpg',
                'estoque' => 12
            ],
            [
                'titulo' => 'O Senhor dos Anéis',
                'autor' => 'J.R.R. Tolkien',
                'editora' => 'Editora D',
                'ano_publicacao' => 1954,
                'genero' => 'Fantasia',
                'sinopse' => 'Uma épica jornada pela Terra Média.',
                'imagem' => 'o_senhor_dos_aneis.jpg',
                'estoque' => 7
            ],
            [
                'titulo' => 'Moby Dick',
                'autor' => 'Herman Melville',
                'editora' => 'Editora E',
                'ano_publicacao' => 1851,
                'genero' => 'Aventura',
                'sinopse' => 'A busca do Capitão Ahab pela baleia branca.',
                'imagem' => 'moby_dick.jpg',
                'estoque' => 6
            ],
            [
                'titulo' => 'Orgulho e Preconceito',
                'autor' => 'Jane Austen',
                'editora' => 'Editora F',
                'ano_publicacao' => 1813,
                'genero' => 'Romance',
                'sinopse' => 'A complexidade das relações sociais na Inglaterra.',
                'imagem' => 'orgulho_preconceito.jpg',
                'estoque' => 15
            ],
            [
                'titulo' => 'Crime e Castigo',
                'autor' => 'Fiódor Dostoiévski',
                'editora' => 'Editora G',
                'ano_publicacao' => 1866,
                'genero' => 'Romance Psicológico',
                'sinopse' => 'O dilema moral de um jovem após cometer um crime.',
                'imagem' => 'crime_castigo.jpg',
                'estoque' => 9
            ],
            [
                'titulo' => 'O Apanhador no Campo de Centeio',
                'autor' => 'J.D. Salinger',
                'editora' => 'Editora H',
                'ano_publicacao' => 1951,
                'genero' => 'Ficção',
                'sinopse' => 'As experiências de um adolescente rebelde.',
                'imagem' => 'o_apanhador_no_campo.jpg',
                'estoque' => 10
            ],
            [
                'titulo' => 'A Divina Comédia',
                'autor' => 'Dante Alighieri',
                'editora' => 'Editora I',
                'ano_publicacao' => 1320,
                'genero' => 'Poesia Épica',
                'sinopse' => 'Uma viagem pelos reinos do além.',
                'imagem' => 'a_divina_comedia.jpg',
                'estoque' => 4
            ],
            [
                'titulo' => 'Hamlet',
                'autor' => 'William Shakespeare',
                'editora' => 'Editora J',
                'ano_publicacao' => 1603,
                'genero' => 'Tragédia',
                'sinopse' => 'A tragédia de um príncipe em busca de vingança.',
                'imagem' => 'hamlet.jpg',
                'estoque' => 14
            ],
            [
                'titulo' => 'O Estrangeiro',
                'autor' => 'Albert Camus',
                'editora' => 'Editora K',
                'ano_publicacao' => 1942,
                'genero' => 'Filosofia Existencial',
                'sinopse' => 'A indiferença de um homem perante a vida.',
                'imagem' => 'o_estrangeiro.jpg',
                'estoque' => 10
            ],
            [
                'titulo' => 'Jane Eyre',
                'autor' => 'Charlotte Brontë',
                'editora' => 'Editora L',
                'ano_publicacao' => 1847,
                'genero' => 'Romance',
                'sinopse' => 'A luta de uma mulher por sua independência.',
                'imagem' => 'jane_eyre.jpg',
                'estoque' => 11
            ],
            [
                'titulo' => 'Guerra e Paz',
                'autor' => 'Liev Tolstói',
                'editora' => 'Editora M',
                'ano_publicacao' => 1869,
                'genero' => 'Histórico',
                'sinopse' => 'Uma obra monumental sobre a Rússia no período napoleônico.',
                'imagem' => 'guerra_e_paz.jpg',
                'estoque' => 3
            ],
            [
                'titulo' => 'O Sol é para Todos',
                'autor' => 'Harper Lee',
                'editora' => 'Editora N',
                'ano_publicacao' => 1960,
                'genero' => 'Ficção',
                'sinopse' => 'Uma história sobre justiça e preconceito no sul dos EUA.',
                'imagem' => 'o_sol_e_para_todos.jpg',
                'estoque' => 7
            ],
            [
                'titulo' => 'O Hobbit',
                'autor' => 'J.R.R. Tolkien',
                'editora' => 'Editora O',
                'ano_publicacao' => 1937,
                'genero' => 'Fantasia',
                'sinopse' => 'A aventura de Bilbo Bolseiro para recuperar um tesouro.',
                'imagem' => 'o_hobbit.jpg',
                'estoque' => 10
            ],
            [
                'titulo' => 'O Processo',
                'autor' => 'Franz Kafka',
                'editora' => 'Editora P',
                'ano_publicacao' => 1925,
                'genero' => 'Ficção',
                'sinopse' => 'Um homem acusado de um crime que desconhece.',
                'imagem' => 'o_processo.jpg',
                'estoque' => 5
            ],
            [
                'titulo' => 'O Morro dos Ventos Uivantes',
                'autor' => 'Emily Brontë',
                'editora' => 'Editora Q',
                'ano_publicacao' => 1847,
                'genero' => 'Romance Gótico',
                'sinopse' => 'Uma intensa história de amor e vingança.',
                'imagem' => 'o_morro_dos_ventos.jpg',
                'estoque' => 6
            ],
            [
                'titulo' => 'Os Miseráveis',
                'autor' => 'Victor Hugo',
                'editora' => 'Editora R',
                'ano_publicacao' => 1862,
                'genero' => 'Romance',
                'sinopse' => 'A jornada de redenção de Jean Valjean.',
                'imagem' => 'os_miseraveis.jpg',
                'estoque' => 8
            ],
            [
                'titulo' => 'Drácula',
                'autor' => 'Bram Stoker',
                'editora' => 'Editora S',
                'ano_publicacao' => 1897,
                'genero' => 'Terror',
                'sinopse' => 'A luta contra o famoso vampiro da Transilvânia.',
                'imagem' => 'dracula.jpg',
                'estoque' => 7
            ]
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