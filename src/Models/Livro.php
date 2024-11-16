<?php

//src/Models/Livro.php

namespace Pedrojaraujo\Biblioteca\Models;

class livro
{
    private int $id;
    private string $titulo;
    private string $autor;
    private string $criado_em;
    private string $atualizado_em;


    public function __construct($id, $titulo, $autor, $criado_em, $atualizado_em)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->criado_em = $criado_em;
        $$this->autualizado_em = $autualizado_em;
    }



    //Getters

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getAutor(): string
    {
        return $this->autor;
    }

    public function getCriadoEm(): string
    {
        return $this->criado_em;
    }

    public function getAtualizadoEm(): string
    {
        return $this->atualizado_em;
    }
}
