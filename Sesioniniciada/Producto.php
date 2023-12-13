<?php
session_start();

// Verificar si se proporciona un ID de producto en la URL
if (isset($_GET['id'])) {
  $idProducto = $_GET['id'];

  // Incluir el archivo de conexión
  require 'Conexion.php';

  // Crear una instancia de la clase de conexión
  $conexionDB = new ConexionDB();
  $conexion = $conexionDB->getConexion();

  // Verificar la conexión
  if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
  }

  // Query para obtener la información del producto por su ID
  $query = "SELECT Productos.*, user.nombre, categoria.Nombre, GROUP_CONCAT(imagenes.imagen) AS imagenes
    FROM Productos 
    INNER JOIN user ON Productos.RowIdUser = user.ID_User 
    INNER JOIN categoria ON Productos.ID_Categoria = categoria.ID_Categoria
    LEFT JOIN imagenes ON Productos.ID_Producto = imagenes.ID_Producto
    WHERE Productos.ID_Producto = $idProducto
    GROUP BY Productos.ID_Producto;";




  $resultado = $conexion->query($query);

  // Verificar si se obtuvieron resultados

  // Obtener la fila del resultado como un array asociativo
  $row = $resultado->fetch_assoc();


  // Cerrar la conexión a la base de datos
  
} else {
  // Si no se proporciona un ID de producto, puedes mostrar un mensaje de error o redirigir a otra página.
  echo "ID de producto no proporcionado.";
}
?>


<!DOCTYPE html>
<html lang="es">

<head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <meta charset="UTF-8">
  <title>Tienda Online</title>
  <meta name="viewport"
    content="width=devide-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="../css/estilos.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <link rel="icon" type="image/png" href="img/logo.JPG">
  <script type="text/javascript">window.$crisp = [];
    window.CRISP_WEBSITE_ID = "cf2b71b4-1c73-4963-893b-29146e2992e9";
    (function () {
      d = document; s = d.createElement("script");
      s.src = "https://client.crisp.chat/l.js";
      s.async = 1; d.getElementsByTagName("head")[0].appendChild(s);
    })();</script>

  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="navbar.css" rel="stylesheet">
  <link href="../css/dropdowns.css" rel="stylesheet">




</head>

<body>
  <header class="p-3 text-bg-dark">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

        <h1 class="main-header__title">ByteQuest</h1>


        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <br></br>
          <li><a href="Home.php" class="nav-link px-2 text-secondary">Home</a></li>&nbsp;&nbsp;&nbsp;&nbsp;
          <?php
          if ($_SESSION['user-tipe'] == 2) {
            echo '<a href="Perfil.php" class="nav-link px-2 text-white">Perfil</a>';
          } else {
            if ($_SESSION['user-rol'] == 1) {
              echo '<a href="PerfilPublico.php" class="nav-link px-2 text-white">Perfil</a>';
            } else {
              echo '<a href="Perfil.Vendedor.php" class="nav-link px-2 text-white">Perfil</a>';
            }
          }
          ?>
          <li><a href="Tienda.php" class="nav-link px-2 text-white">Shop</a></li>&nbsp;&nbsp;&nbsp;&nbsp;
          <li><a href="Carrito.php" class="nav-link px-2 text-white"> <i class="fa-solid fa-cart-shopping"></i>
              &nbsp;&nbsp;Carrito </a></li>


        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..."
            aria-label="Search">
        </form>

        <ul class="nav col-12 col-lg-auto  mb-md-0">
          <li>
            <a class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Usuario </a>
            <ul class="dropdown-menu dropdown-menu-dark ">
              <li><a class="dropdown-item" href="MisPedidos.php">Mis Pedidos</a></li>
              <li><a class="dropdown-item" href="TodosProductos.php">Todos mis productos</a></li>
              <li><a class="dropdown-item" href="MisOrdenes.php">Mis Ordenes</a></li>
              <li><a class="dropdown-item" href="Listas.php">Mis Listas</a></li>
              <li><a class="dropdown-item" href="Chat.php">Chat</a></li>
              <li>
                <a class="dropdown-item dropdown-item-danger d-flex gap-2 align-items-center" href="cerrar_sesion.php">

                  Cerrar sesión
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
  </header>

  <main class="main">
    <div class="row ">
      <div class="col">
        <div class="row g-0 border rounded mb-4 shadow-sm " width="500" height="750">
          <div class="container-fluid">
            <div class="container-fluid">
              <div class="container-fluid">
                <div class="row" width="20%">
                  <?php
                  // Verifica si hay imágenes o videos para mostrar
                  if (!empty($row['imagenes'])) {
                    // Divide las imágenes y videos en un array
                    $archivosMultimedia = explode(',', $row['imagenes']);

                    // Muestra cada imagen o video en una columna
                    foreach ($archivosMultimedia as $archivo) {
                      echo '<div class="col-md-6">';

                      // Verifica si el archivo es una imagen
                      $extension = pathinfo($archivo, PATHINFO_EXTENSION);
                      if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                        echo '<img src="' . $archivo . '" class="img-fluid" alt="Imagen">';
                      }
                      // Verifica si el archivo es un video
                      elseif (in_array($extension, ['mp4', 'webm', 'ogg'])) {
                        echo '<video width="700" height="500" controls>';
                        echo '<source src="' . $archivo . '" type="video/' . $extension . '">';
                        echo 'Tu navegador no soporta el tag de video.';
                        echo '</video>';
                      }

                      echo '</div>';
                    }
                  }
                  ?>
                </div>
              </div>
            </div>
            <div class="col">

              <?php echo "<h1 class='product__title text-center mt-5'>{$row['NombreProduct']}</h1>"; ?>
              <div class="row g-5">

                <div class="col-md-11 text-ce">


                  <h3 class="pb-4 mb-4 fst-italic border-bottom">

                  </h3>

                  <article class="blog-post">
                    <h2 class="blog-post-title mb-1">Descripcion</h2>
                    <?php echo "<p class = blog-post-meta>Publicado en {$row['RowDate']} por {$row['nombre']}</p>" ?>

                    <form>
                      <p class="clasificacion ">
                        <label class="nav-link px-2 text-black ">Clasificacion</label>
                        <input id="radio5" type="radio" name="estrellas" value="5"><!--
                                              --><label for="radio5">★</label><!--
                                              --><input id="radio4" type="radio" name="estrellas" value="4"><!--
                                              --><label for="radio4">★</label><!--
                                              --><input id="radio3" type="radio" name="estrellas" value="3"><!--
                                              --><label for="radio3">★</label><!--
                                              --><input id="radio2" type="radio" name="estrellas" value="2"><!--
                                              --><label for="radio4¿2">★</label><!--
                                              --><input id="radio1" type="radio" name="estrellas" value="1"><!--
                                              --><label for="radio1">★</label>
                      </p>

                    </form>
                    <?php echo "<p>{$row['DescripcionProduct']}</p>" ?>
                    <hr>
                    <dt>Categoria</dt>
                    <?php echo "<dd>{$row['Nombre']}</dd>" ?>
                    <dt>Cantidad disponible</dt>
                    <?php echo "<dd>{$row['CantDisponible']}</dd>" ?>


                    <div class="product ">
                      <?php echo "<h3>$ {$row['Precio']}</h3>" ?>
                      <p></p>
                      <div>
                        <button type="button" class="btn btn-warning"
                          onclick="window.location.href='agregar_al_carrito.php?id=<?php echo $row['ID_Producto']; ?>&nombre=<?php echo $row['NombreProduct']; ?>&precio=<?php echo $row['Precio']; ?>'">
                          Agregar al carrito
                        </button>
                        <div class="col-md-11 text-ce">
                          <!-- ... (código previo) ... -->

                          <?php
                          // Obtener el ID del usuario activo
                          $sqlUserId = "SELECT ID_User FROM User WHERE activo = 1";
                          $resultUserId = $conexionDB->getConexion()->query($sqlUserId);

                          if ($resultUserId->num_rows === 1) {
                            $rowUserId = $resultUserId->fetch_assoc();
                            $rowIdUser = $rowUserId['ID_User'];

                            // Formulario para agregar el producto a una lista
                            echo '<form method="POST" action="agregar_a_lista.php">';
                            echo '<label for="listas">Selecciona una lista:</label>';
                            echo '<select name="idLista" id="listas">';

                            // Query para obtener las listas del usuario activo
                            $sqlLists = "SELECT * FROM lista WHERE ID_User_Lista = $rowIdUser";
                            $resultLists = $conexionDB->getConexion()->query($sqlLists);

                            // Muestra las opciones del select con las listas del usuario
                            while ($lista = $resultLists->fetch_assoc()) {
                              echo "<option value='{$lista['ID_Lista']}'>{$lista['NombreLista']}</option>";
                            }

                            echo '</select>';
                            echo "<input type='hidden' name='idProducto' value='{$row['ID_Producto']}'>";
                            echo "<input type='hidden' name='nombreProducto' value='{$row['NombreProduct']}'>";
                            echo "<input type='hidden' name='precioProducto' value='{$row['Precio']}'>";
                            echo '<button type="submit" class="btn btn-secondary">Agregar a lista</button>';
                            echo '</form>';
                          } else {
                            echo "No se encontró un usuario activo.";
                          }
                          ?>

                        </div>
                      </div>

                    </div>
                    <p></p>

                  </article>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
  </main>

  </div>



  <script src="../js/menu.js">

  </script>



  <footer class="main-footer">
    <div class="footer__section">
      <h2 class="footer__title">Conocenos</h2>
      <p class="footer__txt">blah blah </p>
    </div>
    <div class="footer__section">
      <h2 class="footer__title">Metodos de Pago</h2>
      <p class="footer__txt">blah blah </p>
    </div>
    <div class="footer__section">
      <h2 class="footer__title">Contactanos</h2>
      <p class="footer__txt">Email:</p>
    </div>
    <div class="footer__section">
      <h2 class="footer__title">¿Necesitas Ayuda?</h2>
      <p class="footer__txt">blah blah </p>
    </div>
    <div class="footer__section">
      <h2 class="footer__title">Subscribete</h2>
      <p class="footer__txt">Registrate para recibir las ultimas ofertas
        en tu correo electronico y comprar productos.</p>
      <input type="email" class="footer__input" placeholder="Enter your email">
    </div>

  </footer>
  <div class="Copyright">
    <p class="copy">© ByteQuest</p>
  </div>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script>
    function agregarAlCarrito(idProducto, nombreProducto, precioProducto) {
      // Realiza una solicitud fetch para enviar los datos al archivo PHP
      fetch('agregar_al_carrito.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          ID_Producto_Carrito: idProducto,
          NombreProduct: nombreProducto,
          Precio: precioProducto,
          Cant: 1, // Puedes ajustar la cantidad según lo necesario
        }),
      })
        .then(response => {
          if (response.ok) {
            alert('Producto agregado al carrito');
            // Aquí podrías hacer otras acciones, como actualizar el contador del carrito, etc.
          } else {
            alert('Error al agregar el producto al carrito');
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
  </script>

</body>

</html>