<?php

namespace Controllers;

use MVC\Router;
use Model\Admin;

class LoginController
{
    public static function login(Router $router)
    {   
        $auth=new Admin;
        $alertas = Admin::getAlertas();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Admin($_POST);

            
            $alertas = $auth->validar();
            
            if (empty($alertas)) {
                //verificar si el usuario existe
                $resultado = $auth->existeUsuario();


                if (!$resultado) {
                    //verificar si el usuario existe o no(manda mensaje)
                    $alertas = Admin::getAlertas();
                    
                } else {
                    //verifica el password
                    $autenticado=$auth->comprobarPassword($resultado);

                    if ($autenticado) {//true
                        //Autenticar al usuario
                        $auth->autenticar();
                    } else {
                        //Password incorrecto
                        $alertas = Admin::getAlertas();
                    }
                }
            }
        }

        $router->render('auth/login', [//aca se pone la informacion de la base de datos que quieres enviar al front
            'alertas' => $alertas,
            'auth'=>$auth
        ]);
    }

    public static function logout()
    {   
        session_start();
        //debuguear($_SESSION);//con esto sabremos las propiedades que agregamos al $_SESSION 
        $_SESSION = [];
        header('Location: /HealdFarma');
    }
}
