<?php

namespace Controllers;
use MVC\Router;
use Model\Vendedor;

class VendedorController {


  public static function crear(Router $router) {

    $errores = Vendedor::getErrores();
    $vendedor = new Vendedor;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Crear una nueva instancia 
    $vendedor = new Vendedor($_POST['vendedor']);

    // Validar que no haya campos vacíos 
    $errores = $vendedor->validar();

    if(empty($errores)) {
      $vendedor->guardar();
    }
  }

    $router->render('vendedores/crear', [
      'errores' => $errores,
      'vendedor' => $vendedor
    ]);
  }

  public static function actualizar(Router $router) {

    $id = validarORedireccionar("/admin");
    $vendedor = Vendedor::findOne($id);
    $errores = Vendedor::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $args = $_POST['vendedor'];
      $vendedor->sincronizar($args);
      $errores = $vendedor->validar();

      if(empty($errores)) {
        $vendedor->guardar();
      }
    }
    
    $router->render('vendedores/actualizar', [
      'vendedor' => $vendedor,
      'errores' => $errores
    ]);
  }

  public static function eliminar() {
    
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id = $_POST['id'];
      $id = filter_var($id, FILTER_VALIDATE_INT);

      if($id){
        $tipo = $_POST['tipo'];
        if(validarTipoContenido($tipo)){
          $vendedor = Vendedor::findOne($id);
          $vendedor->deleteOne();
        }
      }
    } 
  }
}