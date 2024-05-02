<main class="contenedor seccion">
  <h1>Administrador de Bienes Raíces</h1>
  <?php
    if($resultado){ mostrarNotificacion($resultado); }
  ?>
  
  <a href="/propiedades/crear" class="boton boton-verde">Nueva Propiedad</a>
  <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>

  <h2>Propiedades</h2>

  <table class="propiedades">
    <thead>
      <tr>
        <th>ID</th>
        <th>Titulo</th>
        <th>Imagen</th>
        <th>Precio</th>
        <th>Acciones</th>
      </tr>
    </thead>
    
    <tbody><!-- Mostrar los resultados de la BBDD en la tabla -->
    <?php foreach($propiedades as $propiedad):?>
      <tr>
        <td><?php echo $propiedad->id; ?></td>
        <td><?php echo $propiedad->titulo; ?></td>
        <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="Imagen Propiedad" class="imagen-tabla"></td>
        <td><?php echo $propiedad->precio; ?> €</td>
        <td>
          <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
          <form method="POST" class="w-100">
            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>"/>
            <input type="hidden" name="tipo" value="propiedad"/>
            <input type="submit" class="boton-rojo-block" value="Eliminar" />
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</main>