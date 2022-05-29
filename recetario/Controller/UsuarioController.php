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
            $_SESSION['id_usuario'] = self::get_id_usuario($username);
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

    static function get_datos(string $username): array
    {
        $user = new Usuario();
        $datos =  $user->get_datos($username);
        if (!empty($datos)) {
            $datos['apellido_materno'] = is_null($datos['apellido_materno']) ? '' : $datos['apellido_materno'];
            return $datos;
        }
        $datos['username'] = $_SESSION['username'];
        $datos['nombre'] = 'John';
        $datos['apellido_paterno'] = 'Doe';
        $datos['apellido_materno'] = '';
        $datos['fecha_nacimiento'] ='1997-07-15';
        $datos['estatura'] = 120;
        $datos['peso']=60.0;

        return $datos;

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

    static function update_datos(
        string $nombre,
        string $apellido_paterno,
        string|null $apellido_materno,
        string $fecha_nacimiento,
        int $estatura,
        float $peso
    ): void
    {

        $user = new Usuario();

        $actualizar = !is_null($user->get_datos($_SESSION['username']));
        $user->set_datos(
            $nombre,
            $apellido_paterno,
            $apellido_materno,
            $fecha_nacimiento,
            $estatura,
            $peso,
            $actualizar
        );

        header("HTTP/1.1 201 OK");
        header('Content-Type: application/json');
        echo json_encode([
                'status' => 200,
                'msg' => 'Se Actualizarón tus datos'
            ]);
    }
}
