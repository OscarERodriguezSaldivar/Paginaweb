<?php
session_start();

?>




<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Tienda Online</title>
        <meta name="viewport" content="width=devide-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minimum-scale=1.0">
        <link rel="stylesheet" href="../css/estilos.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <link rel="icon" type="image/png" href="img/logo.JPG">

        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/dropdowns.css" rel="stylesheet">
        <link href="../Proyecto/css/form-validation.css" rel="stylesheet">

    
    
    </head>
        
    
    <header class="p-3 text-bg-dark">
            
        <div class="container">
              
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
  
                <h1 class="main-header__title">ByteQuest</h1>

             
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <br></br>
                  <li><a href="Home.php" class="nav-link px-2 text-white">Home</a></li>&nbsp;&nbsp;&nbsp;&nbsp;
                            <?php
          if ($_SESSION['user-tipe'] == 2) {
              echo '<a href="Perfil.php" class="nav-link px-2 text-white">Perfil</a>';
          } else {
              if ($_SESSION['user-rol'] == 1){
              echo '<a href="PerfilPublico.php" class="nav-link px-2 text-white">Perfil</a>';
              } else{
                  echo '<a href="Perfil.Vendedor.php" class="nav-link px-2 text-white">Perfil</a>';
              }
          }
          ?>
                  <li><a href="Tienda.php" class="nav-link px-2 text-white">Shop</a></li>&nbsp;&nbsp;&nbsp;&nbsp;
                  <li><a href="Carrito.php" class="nav-link px-2 text-secondary"> <i class="fa-solid fa-cart-shopping"></i> &nbsp;&nbsp;Carrito </a></li>
                  
                </ul>
        
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
                  <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
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
            
        </div>
          
    </header>
    

          
    
          
        
        
    <main class="main">
        <body class="bg-light">
            <div class="container">
                <div class="py-5 text-center">
                    <h2>Checkout form</h2>
                </div>
                <div class="row g-5">
                    <div class="col-md-5 col-lg-4 order-md-last">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">

                    <!-- AQUI SE MUESTRA EL TOTAL DE PRODUCTOS QUE SE VAN A PAGAR CON LA SUMA TOTAL JUNTO CON EL IVA Y EL COSTO DE ENVIO -->


                    <h1>Carrito</h1>
        <hr>
        <table class="table">
        <thead>
            <!-- Encabezados de la tabla -->
        </thead>
        <tbody id="items">
            <!-- Cuerpo de la tabla -->
        </tbody>
        <tfoot>
            <?php
            // Tu lógica de conexión a la base de datos
            require 'Conexion.php';

            // Crear una instancia de la clase de conexión
            $conexionDB = new ConexionDB();
            $conexion = $conexionDB->getConexion();

            // Verificar la conexión
            if ($conexion->connect_error) {
                die("Error de conexión: " . $conexion->connect_error);
            }

            // Consulta para obtener los elementos del carrito
            $query = "SELECT * FROM Carrito";
            $resultado = $conexion->query($query);

            // Verificar si hay resultados
            if ($resultado->num_rows > 0) {
                $totalProductos = 0;
                $totalPrecio = 0;

                while ($row = $resultado->fetch_assoc()) {
                    // Incrementar el contador de productos y sumar el precio total
                    $totalProductos += $row['Cant'];
                    $totalPrecio += $row['Cant'] * $row['Precio'];

                    // Imprimir cada elemento del carrito en el footer de la tabla
                    echo '<tr>';
                    echo '<td>' . $row['ID_Producto_Carrito'] . '</td>';
                    echo '<td>' . $row['NombreProduct'] . '</td>';
                    echo '<td>' . $row['Cant'] . '</td>';
                    echo '<td>$' . ($row['Cant'] * $row['Precio']) . '</td>';
                    echo '</tr>';
                }

                // Calcular el IVA
                $ivaPorcentaje = 0.16; // Porcentaje de IVA (16% en este ejemplo)
                $iva = $totalPrecio * $ivaPorcentaje;

                // Calcular el precio total con IVA
                $totalConIVA = $totalPrecio + $iva;

                // Mostrar el total de productos y el precio total en el footer
                echo '<tr>';
                echo '<th scope="row" colspan="2">Total productos</th>';
                echo '<td>' . $totalProductos . '</td>';
                echo '<td>$' . $totalPrecio . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<th scope="row" colspan="3">IVA (' . ($ivaPorcentaje * 100) . '%)</th>';
                echo '<td>$' . $iva . '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<th scope="row" colspan="3">Total con IVA</th>';
                echo '<td class="font-weight-bold">$' . $totalConIVA . '</td>';
                echo '</tr>';
                
            } else {
                // Si el carrito está vacío, mostrar un mensaje
                echo '<tr id="footer">';
                echo '<th scope="row" colspan="5">Carrito vacío - ¡comience a comprar!</th>';
                echo '</tr>';
            }

            // Cerrar la conexión
            $conexion->close();
            ?>
        </tfoot>
    </table>
                        

                      
                    </div>
                      
                    
                    <div class="col-md-7 col-lg-8">
                    
                        <h4 class="mb-3">Billing address</h4>
                        
                        <form class="needs-validation" action="crearcompra.php" method="POST" enctype="multipart/form-data">
                        
                            <div class="row g-3">


                                <div class="col-12">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="1234 Main St" required>
                                    <div class="invalid-feedback">Please enter your shipping address.</div>
                            
                                </div>
                                <div class="row gy-3">
                                    <div class="col-md-6">
                                    <label for="cc-name" class="form-label">Name on card</label>
                                    <input type="text" class="form-control" id="cc-name" name="cc-name" placeholder="" required>
                                    <small class="text-muted">Full name as displayed on card</small>
                                        <div class="invalid-feedback">
                                            Name on card is required
                                        </div>
                                    </div>
                
                                    <div class="col-md-6">
                                    <label for="cc-number" class="form-label">Credit card number</label>
                                    <input type="text" class="form-control" name="cc-number" id="cc-number" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Credit card number is required
                                        </div>
                                    </div>
                
                                    <div class="col-md-3">
                                    <label for="cc-expiration" class="form-label">Expiration</label>
                                    <input type="text" class="form-control" name="cc-expiration" id="cc-expiration" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Expiration date required
                                        </div>
                                    </div>
                
                                    <div class="col-md-3">
                                    <label for="cc-cvv" class="form-label">CVV</label>
                                    <input type="text" class="form-control" name="cc-cvv" id="cc-cvv" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Security code required
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <input type="hidden" name="subtotal" value="<?php echo $totalConIVA; ?>">
                                <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>                
                        </form>
                    </div>
                </div>
            </div>
        </body>
    </main>




        
        
    
    
    <footer class="main-footer">
            
        
        <div class="footer__section">
                
            <h2 class="footer__title">Conocenos</h2>
            <p class="footer__txt">blah blah</p>
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
                    en tu correo electronico y comprar productos.
            </p>
                    
            <input type="email" class="footer__input" placeholder="Enter your email">
            
                
        </div>


    </footer>
        
    <div class="Copyright"><p class="copy">© ByteQuest</p></div>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/form-validation.js"></script>



        
    
</html>