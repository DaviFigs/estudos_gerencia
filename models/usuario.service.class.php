<?php
require_once __DIR__ . '/banco.service.class.php';

class Usuario{
    function __get($name){
        return $this->$name;
    }
    function __set($name, $value){
        $this->$name = $value;
    }

    function cadastrar_usuario($param) 
    {
        $conexao = BANCO::conectar();
        try {
            $conexao->beginTransaction();

            $queryBusca = 'SELECT id_usuario FROM usuario WHERE email = ?';
            $statementBusca = $conexao->prepare($queryBusca);
            $statementBusca->execute([$param['email']]);
            if ($statementBusca->fetch()) {
                return [
                    'error' => true,
                    'msg' => 'Email já cadastrado'
                ];
            }

            $query = 'INSERT INTO usuario (nome, email, senha)
                VALUES (?,?,?)';

            $statement = $conexao->prepare($query);
            $statement->execute([
                $param['nome'],
                $param['email'],
                $this->hash_senha($param['senha'])
            ]);

            $conexao->commit();
            return [
                'error' => false,
                'msg' => 'Usuário cadastrado com sucesso',
            ];

        } catch (Exception $e) {
            if ($conexao->inTransaction()) {
                $conexao->rollBack();
            }
            return [
                'error' => true,
                'msg' => 'Erro ao cadastrar usuário'
            ];
        }
    }

    function login($param)
    {
        $conexao = BANCO::conectar();
        try {
            $query = 'SELECT id_usuario, nome, email, senha FROM usuario WHERE email = ? LIMIT 1';
            $statement = $conexao->prepare($query);
            $statement->execute([
                $param['email']
            ]);

            $usuario = $statement->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                return [
                'error' => true,
                'msg' => "Erro ao encontrar usuário"
                ];
            }

            if (!password_verify($param['senha'], $usuario['senha'])) {
                return [
                'error' => true,
                'msg' => "Senha incorreta"
                ];
            }
            else{
                $this->auditar_ultimo_login($usuario);
                return [
                    'item' => $usuario,
                    'error' => false,
                    'msg' => "Usuário logado com sucesso"
                ];
            }

        } catch (Exception $e) {
            return [
                'error' => true,
                'msg' => $e->getMessage()
            ];
        }
    }


    function auditar_ultimo_login($param){
        $conexao = BANCO::conectar();
        try{
            $query = 'UPDATE usuario SET ultimo_login = NOW() where id_usuario = ?';
            $statement = $conexao->prepare($query);
            $statement->execute([$param['id_usuario']]);

            if($statement->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }

        }catch(Exception $e){
            return false;
        }
    }
    function listar_usuarios(){
        $conexao = BANCO::conectar();
        try{
            $query = 'select * from usuario order by nome asc';
            $statement = $conexao->prepare($query);
            $statement->execute();
            return $statement->fetchAll();

        }catch(Exception $e){
            return false;
        }
    }

    function buscar_dados_usuario($param){
        $conexao = BANCO::conectar();
        try{
            $query = 'select * from usuario where id_usuario = ?';
            $statement = $conexao->prepare($query);
            $statement->execute([$param['id_usuario']]);
            return  [
                'items' => $statement->fetch(),
                'error' => false,
                'msg' => 'Dados do usuário encontrados com sucesso'
            ];

        }catch(Exception $e){
            error_log($e->getMessage());
            return [    
                'error' => true,
                'msg' => 'Erro ao buscar dados do usuário'
            ];
        }
    }

    function buscar_dados_por_id($id){
        $conexao = BANCO::conectar();
        try{
            $query = 'select * from usuario where id = ?';
            $statement = $conexao->prepare($query);
            $statement->execute([$id]);
            $usuario =  $statement->fetch();
            
            $query = 'select * from endereco where id = ?';
            $statement = $conexao->prepare($query);
            $statement->execute([$usuario['id_endereco']]);
            $endereco =  $statement->fetch();

            return $dados_usuario = [
                    'usuario'=>$usuario,
                    'endereco'=>$endereco];

        }catch(Exception $e){
            error_log($e->getMessage());
            return false;
        }
    }

    function hash_senha($senha){
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    
}
