<?php

require_once '../db/conexao.php';
require_once 'curso.php';

class CursoDao
{
    private $conexao;

    public function __construct()
  {
    $conexao = new Conexao();
    $this->conexao = $conexao->conectar();
  }

    public function inserir(Curso $curso)
    {
        // monta SQL
        $sql = 'INSERT INTO tb_curso (nome, descricao, carga_horaria, data_inicio, data_fim) VALUES (:nome, :descricao, :carga_horaria, :data_inicio, :data_fim)';

        // preencher SQL com dados do curso que eu quero inserir
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':nome', $curso->nome);
        $stmt->bindValue(':descricao', $curso->descricao);
        $stmt->bindValue(':carga_horaria', $curso->carga_horaria);
        $stmt->bindValue(':data_inicio', $curso->data_inicio);
        $stmt->bindValue(':data_fim', $curso->data_fim);

        // manda executar SQL
        $stmt->execute();
    }

    public function listar_tudo()
    {
        $sql = 'SELECT * FROM tb_curso';
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
        $cursos = array();

        // percorrer resultados
        foreach ($resultados as $item) {
        
            // instanciar curso novo
            $novo_curso = new Curso($item->id, $item->nome, $item->descricao, $item->carga_horaria, $item->data_inicio, $item->data_fim);
            
            // guardar num novo array
            $cursos[] = $novo_curso;
        }
        // retornar array
        return $cursos;
    }

    public function procurar_por_id($id)
    {
        $sql = 'SELECT * FROM tb_curso WHERE id = :id';

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        // instanciar curso novo
        $curso = new Curso($resultado->id, $resultado->nome, $resultado->descricao, $resultado->carga_horaria, $resultado->data_inicio, $resultado->data_fim);

        return $curso;
    }
}
