<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Online</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="icon" type="image/png" href="img/logo.JPG">
    <script type="text/javascript">
        window.$crisp = [];
        window.CRISP_WEBSITE_ID = "cf2b71b4-1c73-4963-893b-29146e2992e9";
        (function () {
            d = document; s = d.createElement("script");
            s.src = "https://client.crisp.chat/l.js";
            s.async = 1; d.getElementsByTagName("head")[0].appendChild(s);
        })();
    </script>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/dropdowns.css" rel="stylesheet">
</head>
<body>
<header class="p-3 text-bg-dark">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <h1 class="main-header__title">ByteQuest</h1>
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <br></br>
                <li><a href="Home.php" class="nav-link px-2 text-secondary">Home</a></li>
                &nbsp;&nbsp;&nbsp;&nbsp;
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
                <li><a href="Tienda.php" class="nav-link px-2 text-white">Shop</a></li>
                &nbsp;&nbsp;&nbsp;&nbsp;
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
                        <li><a class "dropdown-item" href = "Listas.php"> Mis Listas </a></li>
                        <li><a class="dropdown-item" href="Chat.php">Chat</a></li>
                        <li>
                            <a class="dropdown-item dropdown-item-danger d-flex gap-2 align-items-center"
                            href="cerrar_sesion.php">
                                Cerrar sesión
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </header>

    <main class="main">
        <div class="container">
            <h2 class="text-center">Registrar un nuevo producto</h2>
            <form method="post" action="registrar_producto.php" enctype="multipart/form-data">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nombre del Producto</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="Descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="Descripcion" name="Descripcion" required></textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="precio" class="form-label">Precio</label>
                        <input type="text" class="form-control" id="precio" name="precio" required>
                    </div>
                    <div class="col-md-4">
                        <label for="categoria" class="form-label">Categoría</label>
                        <select class="form-select" id="categoria" name="categoria" required>
                            <option value="1">Perifericos</option>
                            <option value="2">Pantallas</option>
                            <option value="3">SetUps</option>
                            <option value="4">Consolas y videojuegos</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Imágenes (Máx. 3)</label>
                        <input type="file" class="form-control" name="imagenes[]" accept="image/*" multiple required>
                    </div>

                    <!-- <div class="col-md-4"> 
                    <label class="form-label">Elija una imagen </label>
                        <input type="file" class="form-control" id="imagenes" name="imagenes" required> 
                        <input type="file" class="form-control" id="imagenes2" name="imagenes2" required> 
                        <input type="file" class="form-control" id="imagenes3" name="imagenes3" required> 
                     </div> -->

                    <div class="col-md-6">
                        <label class="form-label">Video</label>
                        <input type="file" class="form-control" name="video" accept="video/*" required>
                    </div>
                    <div class="col-md-4">
                        <label for="cantidad" class="form-label">Cantidad Disponible</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Calificación</label>
                        <select class="form-select" name="calificacion">
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★☆</option>
                            <option value="3">★★★☆☆</option>
                            <option value="2">★★☆☆☆</option>
                            <option value="1">★☆☆☆☆</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="proveedor" class="form-label">Proveedor</label>
                        <input type="text" class="form-control" id="proveedor" name="proveedor" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Guardar Producto</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

        <script src="../js/slider.js"></script>
        <script src="../js/menu.js"></script>


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
        <div class="Copyright"><p class="copy">© ByteQuest</p></div>
        <script src="../js/bootstrap.bundle.min.js"></script>
    </body>
</html>
