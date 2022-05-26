<?php
namespace Controller;

use Model\Usuario;

class UsuarioController
{
    static function begin_session(string $username, string $password) :void
    {

        $username = strtoupper($username);
        $user = new Usuario();

        if ($user->check_user_password($username, hash('sha512',$password))) {
            $_SESSION['username'] = $username;
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            header("HTTP/1.1 200 OK");
            header('Content-Type: application/json');
            $msg = '<p>Iniciaste sesión como: ' . $username.'</p>'.
            '<meta http-equiv=\'refresh\' content=\'3; url=/ \'/>';
            echo '{"status":  200, "msg": "'.$msg.'"}';
        } else {
            header('HTTP/1.0 401 Unauthorized');
            echo '{"status":  401, "msg": "Verifica tus credenciales "}';
        }
    }

    static function get_id_usuario(string $username): int
    {
        $user = new Usuario();
        return $user->get_usuario($username)['id'];
    }

    static function cambiar_favorito(string $username, int $id_receta): void
    {
        $user = new Usuario();
        $id_usuario = self::get_id_usuario($username);

        $es_favorito = $user->es_favorito($id_usuario, $id_receta) == 1;
        header("HTTP/1.1 201 OK");
        header('Content-Type: application/json');
        if ($es_favorito) {
            $user->del_favorito($id_usuario,$id_receta);
            echo json_encode([
                'status' => 200,
                'action' => 'del',
                'msg' => 'Se elimino la receta de favoritos'
            ]);
        } else {
            $user->add_favorito($id_usuario,$id_receta);
            echo json_encode([
                'status' => 200,
                'action' => 'add',
                'msg' => 'Se añadió la receta a tus recetas favoritas'
            ]);
        }


    }
}