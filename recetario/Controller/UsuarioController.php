<?php
namespace Controller;

use Model\Usuario;

class UsuarioController
{
    static function begin_session(string $username, string $password)
    {

        $username = strtoupper($username);
        $user = new Usuario();

        if ($user->check_user_password($username, hash('sha512',$password))) {
            $_SESSION['username'] = $username;
            $_SESSION['valid'] = true;
            $_SESSION['timeout'] = time();
            header("HTTP/1.1 200 OK");
            echo '';
            header('Content-Type: application/json');
            $msg = '<p>Iniciaste sesión como: ' . $username.'</p>'.
            '<meta http-equiv=\'refresh\' content=\'3; url=/ \'/>';
            echo '{"status":  200, "msg": "'.$msg.'"}';
        } else {
            header('HTTP/1.0 401 Unauthorized');
            echo '{"status":  401, "msg": "Verifica tus credenciales "}';
        }
    }
}