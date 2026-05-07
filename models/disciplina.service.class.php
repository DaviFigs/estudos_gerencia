<?php
require_once __DIR__ . '/banco.service.class.php';

class Disciplina{

     function __get($name){
        return $this->$name;
    }
    function __set($name, $value){
        $this->$name = $value;
    }

    public function enum_prioridade($prioridade){
        $prioridades = [
            'baixa' => 1,
            'media' => 2,
            'alta' => 3
        ];
        if(array_key_exists($prioridade, $prioridades)){
            return $prioridades[$prioridade];
        }
        return null;
    }



    public function excluir_disciplina($param)
    {
        $conexao = BANCO::conectar();
        try {
            $conexao->beginTransaction();

            $query = 'DELETE FROM disciplina WHERE id_disciplina = ?';
            $statement = $conexao->prepare($query);
            $statement->execute([
                $param['id_disciplina']
            ]);

            $conexao->commit();
            return true;
        } catch (Exception $e) {
            if ($conexao->inTransaction()) {
                $conexao->rollBack();
            }
            return false;
        }
    }

    public function listar_disciplinas($param)
    {
        try{
            $conexao = BANCO::conectar();
            $query = 'SELECT * FROM disciplina WHERE id_usuario = ?';
            $statement = $conexao->prepare($query);
            $statement->execute([$param['id_usuario']]);
            $items = $statement->fetchAll(PDO::FETCH_ASSOC);
            return [
                'items' => $items,
                'total' => count($items),
                'error' => false
            ];
        }
        catch(Exception $e){
            return [
                'items' => [],
                'total' => 0,
                'error' => true
            ];
        }
    }

    public function listar_ultimos_estudos($param)
    {
        try{
            $conexao = BANCO::conectar();
            $query = 'SELECT disciplina.nome,disciplina.cor, auditoria_estudo.data_inicio, 
            auditoria_estudo.data_fim, auditoria_estudo.duracao_segundos FROM auditoria_estudo 
            JOIN disciplina ON auditoria_estudo.id_disciplina = disciplina.id_disciplina 
            WHERE auditoria_estudo.id_usuario = ? 
            ORDER BY auditoria_estudo.data_fim DESC LIMIT 10';
            $statement = $conexao->prepare($query);
            $statement->execute([$param['id_usuario']]);
            $items = $statement->fetchAll(PDO::FETCH_ASSOC);
            return [
                'items' => $items,
                'total' => count($items),
                'error' => false
            ];
        }
        catch(Exception $e){
            return [
                'items' => [],
                'total' => 0,
                'error' => true
            ];
        }
    }

    public function atualizar_tempo_de_estudo($param, $conexao){
        $query = 'UPDATE disciplina 
                SET tempo_de_estudo = tempo_de_estudo + ? 
                WHERE id_disciplina = ?';

        $statement = $conexao->prepare($query);
        $statement->execute([
            $param['duracao'],
            $param['disciplina_id'],
        ]);

        return true;
    }

    public function salvar_estudo($param){
        $conexao = BANCO::conectar();

        try {
            $conexao->beginTransaction();

            // 1. Insere auditoria
            $query = 'INSERT INTO auditoria_estudo
            (id_usuario, id_disciplina, data_inicio, data_fim, duracao_segundos)
            VALUES (?,?,?,?,?)';

            $statement = $conexao->prepare($query);
            $statement->execute([
                $param['id_usuario'],
                $param['disciplina_id'],
                $param['tempo_inicial'],
                $param['tempo_final'],
                $param['duracao']
            ]);

            // 2. Atualiza disciplina (mesma conexão!)
            $this->atualizar_tempo_de_estudo($param, $conexao);

            // 3. Se tudo ok, confirma
            $conexao->commit();

            return [
                'error' => false,
                'msg' => 'Estudo salvo com sucesso!'
            ];

        } catch (Exception $e) {

            if ($conexao->inTransaction()) {
                $conexao->rollBack();
            }

            return [
                'error' => true,
                'msg' => 'Erro ao salvar estudo!'
            ];
        }
    }

    public function criar_disciplina($param)
    {
        $param['nome'] = strtoupper($param['nome']);
        //echo '<pre>';
        //print_r($param);
        //exit;
        $conexao = BANCO::conectar();
        try {
            $conexao->beginTransaction();

            $query = 'INSERT INTO disciplina (id_usuario, nome, importancia, cor, descricao)
                VALUES (?,?,?,?,?)';

            $statement = $conexao->prepare($query);
            $statement->execute([
                $param['id_usuario'],
                $param['nome'],
                $this->enum_prioridade($param['importancia']),
                $param['cor'],
                $param['descricao']
            ]);
            $conexao->commit();
            return [
                'error' => false,
                'msg' => 'Disciplina criada com sucesso',
            ];

        } catch (Exception $e) {
            if ($conexao->inTransaction()) {
                $conexao->rollBack();
            }
            return [
                'error' => true,
                'msg' => 'Erro ao criar disciplina'
            ];
        }
    }
}