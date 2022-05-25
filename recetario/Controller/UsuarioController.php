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

    static function es_favorito(string $usuario, int $id_receta): void
    {
        $user = new Usuario();
        $id_usuario = $user->get_usuario($usuario)['id'];
        $resp = $user->es_favorito($id_usuario, $id_receta);
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        echo '{"status":  200, "favorito": "'.$resp.'"}';
    }
}