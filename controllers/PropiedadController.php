<?php

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class PropiedadController {
  public static function index(Router $router) {

    $propiedades = Propiedad::all();

    // Muestra el mensaje condicional
    $resultado = $_GET['resultado'] ?? null;
    
    $router->render('propiedades/admin', [
      'propiedades' => $propiedades,
      'resultado' => $resultado
    ]);
  }

  public static function crear(Router $router) {

    $propiedad = new Propiedad;
    $vendedores = Vendedor::all();
    $errores = Propiedad::getErrores();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
      /* Crea una nueva instancia */
      $propiedad = new Propiedad($_POST['propiedad']);

      /* Subida de Archivos */

      // Generar un nombre único
      $nombre_imagen = md5( uniqid( rand(), true ) ) . ".jpg";

      // Formatear la imagen 
      // Realizar un resize a la imagen con intervention
      if($_FILES['propiedad']['tmp_name']['imagen']){
      $manager = new ImageManager(Driver::class);
      $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600, 'center');
      $propiedad->setImagen($nombre_imagen);
      }

      // Validar
      $errores = $propiedad->validar(); // Validar por tamaño (0,35Mb máximo) - 350000
    
      // Revisar que el array de errores esté vacío
      if(empty($errores)){
      
        // Crear una carpeta si no existe
        if(!is_dir(CARPETA_IMAGENES)){ mkdir(CARPETA_IMAGENES); }
      
        // Guardar la imagen en el servidor 
        $image->toJpeg()->save(CARPETA_IMAGENES . $nombre_imagen);
      
        // Guarda en la base de datos 
        $propiedad->guardar();
      
      }
    }
    
    $router->render('propiedades/crear', [
      'propiedad' => $propiedad,
      'vendedores' => $vendedores,
      'errores' => $errores
    ]);

  }

  public static function actualizar(Router $router) {
    
    $id = validarORedireccionar("/admin");
    $propiedad = Propiedad::findOne($id);
    $vendedores = Vendedor::all();
    $errores = Propiedad::getErrores();

    // Metodo POST para actualizar
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

    // Asignar los atributos 
    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);

    // Validacion
    $errores = $propiedad->validar();

    /* SUBIDA DE ARCHIVOS */
    
    // Generar un nombre único
    $nombre_imagen = md5( uniqid( rand(), true ) ) . ".jpg";

    if($_FILES['propiedad']['tmp_name']['imagen']){
      $manager = new ImageManager(Driver::class);
      $image = $manager->read($_FILES['propiedad']['tmp_name']['imagen'])->cover(800, 600, 'center');
      $propiedad->setImagen($nombre_imagen);
    }

    
    // Revisar que el array de errores esté vacío
    if(empty($errores)){
      if($_FILES['propiedad']['tmp_name']['imagen']) {
        // Almacenar la imagen 
        // Crear una carpeta si no existe
        if(!is_dir(CARPETA_IMAGENES)){ mkdir(CARPETA_IMAGENES); }
        
        // Guardar la imagen en el servidor 
        $image->toJpeg()->save(CARPETA_IMAGENES . $nombre_imagen);
      }

      /* ACTUALIZAR VALORES EN LA BBDD */
      
      $propiedad->guardar();

    }
  }

    $router->render('/propiedades/actualizar', [
      'propiedad' => $propiedad,
      'vendedores' => $vendedores,
      'errores' => $errores
    ]);
  }

  public static function eliminar(){

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      // Validar Id 
      $id = $_POST['id'];
      $id = filter_var($id, FILTER_VALIDATE_INT);

      if($id) {
        $tipo = $_POST['tipo'];
        if(validarTipoContenido($tipo)) {
          $propiedad = Propiedad::findOne($id);
          $propiedad->deleteOne();
        }
      }
    }
  }
}