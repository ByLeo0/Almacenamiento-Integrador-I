<?php

namespace Model;

class Admin extends ActiveRecord
{

    // Base DE DATOS
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function validar()
    {
        if (!$this->email) {
            self::$alertas[] = "El Email del usuario es obligatorio";
        }elseif(!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',$this->email)){//esta funcion toma una expresion regular y hace que siga un patron, en este caso va del 0 al 9 y tiene que tener max 10 digitos
            self::$alertas[]="Formato no válido del email";
        }
        if (!$this->password) {
            self::$alertas[] = "El Password del usuario es obligatorio";
        }/*elseif(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/',$this->email)){//esta funcion toma una expresion regular y hace que siga un patron, en este caso va del 0 al 9 y tiene que tener max 10 digitos
            self::$alertas[]="Formato no válido del email";
        }*/
        return self::$alertas;
    }

    public function existeUsuario()
    {
        // Revisar si el usuario existe.
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        $resultado = self::$db->query($query);

        //debuguear($resultado);// PARA ENTENDER MEJOR, self::$db->query() nos da los atributos de dicho objeto que se hace llamar y se comprueba que existe o no usando el num_rows. Toma dos valores 1(true) y 0(false)
        //Pero, la funcion consultarsql() que hicimos, se usa el fetch_assoc para traer los datos de la DB en array, pero luego se convierten en objetos con la funcion crearObjetos() que está incluida

        //por eso, en esta funcion no hay necesidad de usar el consultarsql porque solo queremos comprobar y el query() es más que suficiente.
        if (!$resultado->num_rows) {//IMPORTANTE, esto nos dice si existe o no en la base de datos. num_rows(1)=existe, num_rows(0)=no existe
            self::$alertas[] = 'El Usuario No Existe';//a pesar de que coloquemos el email bien escrito, si no existe en la base de datos, te saldrá esto.
            return;
        }

        return $resultado;
    }

    public function comprobarPassword($resultado)
    {
        $usuario = $resultado->fetch_object();//con fetch_assoc() te da en array
        //debuguear($usuario);// te da el objeto pero sin referencias: object(stdClass), en cambio usando el consultarSQL() te da referenciado: object(Model\Admin)
        $autenticado = password_verify($this->password, $usuario->password);

        if (!$autenticado) {
            self::$alertas[] = 'El Password es Incorrecto';
        }else{
            return $autenticado;//true
        }
    }

    public function autenticar()
    {
        // El usuario esta autenticado
        session_start();

        // Llenar el arreglo de la sesión
        $_SESSION['usuario'] = $this->email;//para autenticar el usuario con el email
        $_SESSION['login'] = true;

        header('Location: /inicio');
    }
}
