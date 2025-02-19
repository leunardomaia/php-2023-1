<?php

require_once '../db/conexao.php';
require_once 'aluno.php';

class AlunoDao
{
  private $conexao;

  public function __construct()
  {
    $conexao = new Conexao();
    $this->conexao = $conexao->conectar();
  }

  public function inserir(Aluno $aluno)
  {
    // monta SQL
    $sql = 'INSERT INTO tb_aluno (nome, endereco, telefone, data_nascimento) VALUES (:nome, :endereco, :telefone, :data_nascimento)';

    // preencher SQL com dados do aluno que eu quero inserir
    $stmt = $this->conexao->prepare($sql);
    $stmt->bindValue(':nome', $aluno->nome);
    $stmt->bindValue(':endereco', $aluno->endereco);
    $stmt->bindValue(':telefone', $aluno->telefone);
    $stmt->bindValue(':data_nascimento', $aluno->data_nascimento);
    
    // manda executar SQL
    $stmt->execute();
  }

  public function listar_tudo()
  {
    $sql = 'SELECT * FROM tb_aluno';
    $stmt = $this->conexao->prepare($sql);
    $stmt->execute();

    $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
    $alunos = array();

    // percorrer resultados
    foreach ($resultados as $item) {

      // instanciar aluno novo
      $novo_aluno = new Aluno($item->id, $item->nome, $item->endereco, $item->telefone, $item->data_nascimento);

      // guardar num novo array
      $alunos[] = $novo_aluno;
    }
    // retornar esse novo array
    return $alunos;
  }

  public function procurar_por_id($id)
    {
        $sql = 'SELECT * FROM tb_aluno WHERE id = :id';

        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_OBJ);

        $item = $resultado;
        
        // instanciar aluno novo
        $aluno = new Aluno($item->id, $item->nome, $item->endereco, $item->telefone, $item->data_nascimento);

        return $aluno;
    }
}
