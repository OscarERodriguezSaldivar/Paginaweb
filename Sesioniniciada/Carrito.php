<?php
session_start();
require_once 'Paypal_Config.php';
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
  <div class="overlay hidden"><div class="overlay-content"><img src="css/loading.gif" alt="Processing..."/></div></div>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/dropdowns.css" rel="stylesheet">
      

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
        
              
        <form action="TiendaBusqueda.php" method="POST" class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3"
                role="search">
                <input type="search" name="search_query" class="form-control form-control-dark text-bg-dark"
                    placeholder="Search..." aria-label="Search">
            </form>
        
        <ul class="nav col-12 col-lg-auto  mb-md-0">
          <li><a class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Usuario </a>
            <ul class="dropdown-menu dropdown-menu-dark ">
                
              <li><a class="dropdown-item" href="MisPedidos.php">Mis Pedidos</a></li>
              <li><a class="dropdown-item" href="TodosProductos.php">Todos mis productos</a></li>
              <li><a class="dropdown-item" href="MisOrdenes.php">Mis Ordenes</a></li>
              <li><a class="dropdown-item" href="Listas.php">Mis Listas</a></li>
              <li><a class="dropdown-item" href="Chat.php">Chat</a></li>
              
              <a class="dropdown-item dropdown-item-danger d-flex gap-2 align-items-center" href="cerrar_sesion.php">
                             
                             Cerrar sesión
                           </a>
              
              
            </ul>
             
          </li>
             
            
        </ul>
      </div>
    </div>
  </header>
  
  <main class="main">
    <body>
      <div class="container">
        <p></p>
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

                    // ...

                    echo '<td><form method="post" action="eliminar_del_carrito.php">';
                    echo '<input type="hidden" name="idProducto" value="' . $row['ID_Carrito'] . '">';
                    echo '<button class="btn btn-danger btn-sm" type="submit">Eliminar</button>';
                    echo '</form></td>';
                    // ...


                    
                    echo '<td>$' . ($row['Cant'] * $row['Precio']) . '</td>';
                    echo '</tr>';
                }

                // Mostrar el total de productos y el precio total en el footer
                echo '<tr>';
                echo '<th scope="row" colspan="2">Total productos</th>';
                echo '<td>' . $totalProductos . '</td>';
                echo '<td class="font-weight-bold">$' . $totalPrecio . '</td>';
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

            

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              
              <a href="PAGAR.php"><button class="btn btn-info  text-white " id="pagar-carrito" type="button">Pagar</button></a>


              <!--Implementacion de PayPal-->
              <script src="https://www.paypal.com/sdk/js?client-id=AefjyNHPl9Eb4rgOZMZTtGLuQ4dbVJOJ-ERAOG7kSo_cYwnXAwagAhaYQSD2B2yZlmk9ilrNmMvYim5Q&disable-funding=credit,card"></script>



             <!-- Set up a container element for the button -->
              <div id="paypal-button-container"></div>


              <script>



              paypal.Buttons({
                    // Sets up the transaction when a payment button is clicked
                    createOrder: (data, actions) => {
                        return actions.order.create({
                          "purchase_units": [{
                                "custom_id": "<?php echo $itemNumber; ?>",
                                "description": "<?php echo $itemName; ?>",
                                "amount": {
                                    "currency_code": "<?php echo $currency; ?>",
                                    "value": <?php echo $totalPrecio; ?>,
                                    "breakdown": {
                                        "item_total": {
                                            "currency_code": "<?php echo $currency; ?>",
                                            "value": <?php echo $totalPrecio; ?>
                                        }
                                    }
                                },
                                "items": [
                                    {
                                        "name": "<?php echo $itemName; ?>",
                                        "description": "<?php echo $itemName; ?>",
                                        "unit_amount": {
                                            "currency_code": "<?php echo $currency; ?>",
                                            "value": <?php echo $totalPrecio; ?>
                                        },
                                        "quantity": "1",
                                        "category": "DIGITAL_GOODS"
                                    },
                                ]
                            }]
                        });
                    },
                      // Finalize the transaction after payer approval
                      onApprove: (data, actions) => {
                        return actions.order.capture().then(function(orderData) {
                            setProcessing(true);

                            var postData = {paypal_order_check: 1, order_id: orderData.id};
                            fetch('PayPal_Checkout_validate.php', {
                                method: 'POST',
                                headers: {'Accept': 'application/json'},
                                body: encodeFormData(postData)
                            })
                            .then((response) => response.json())
                            .then((result) => {
                                if(result.status == 1){
                                    window.location.href = "payment-status.php?checkout_ref_id="+result.ref_id;
                                }else{
                                    const messageContainer = document.querySelector("#paymentResponse");
                                    messageContainer.classList.remove("hidden");
                                    messageContainer.textContent = result.msg;
                                    
                                    setTimeout(function () {
                                        messageContainer.classList.add("hidden");
                                        messageText.textContent = "";
                                    }, 5000);
                                }
                                setProcessing(false);
                            })
                            .catch(error => console.log(error));
                        });
                    }
                }).render('#paypal-button-container');

                const encodeFormData = (data) => {
                  var form_data = new FormData();

                  for ( var key in data ) {
                    form_data.append(key, data[key]);
                  }
                  return form_data;   
                }

                // Show a loader on payment form processing
                const setProcessing = (isProcessing) => {
                    if (isProcessing) {
                        document.querySelector(".overlay").classList.remove("hidden");
                    } else {
                        document.querySelector(".overlay").classList.add("hidden");
                    }
                }   



              </script>


            </div><p></p>



          <div class="row" id="cards"></div>
          


          
        </div>
      
        <template id="template-footer">
              <th scope="row" colspan="2">Total productos</th>
              <td>10</td>
              <td>
                  <button class="btn btn-danger btn-sm" id="vaciar-carrito">
                      vaciar todo
                  </button>
              </td>
              <td class="font-weight-bold">$ <span></span></td>
          </template>
          
          <template id="template-carrito">
            <tr>
              <th scope="row">id</th>
              <td>Café</td>
              <td>1</td>
              <td>
                  <button class="btn btn-info btn-sm">
                      +
                  </button>
                  <button class="btn btn-danger btn-sm">
                      -
                  </button>
              </td>
              <td>$ <span>500</span></td>
            </tr>
          </template>
      
    



        <template id="template-card">
          <div class="col-12 mb-2 col-md-4">
            <div class="card">
              <img src="" alt="" class="card-img-top">
            <div class="card-body">
              <h5>Titulo</h5>
              <p>precio</p>
              <button class="btn btn-dark">Comprar</button>
            </div>
            </div>
          </div>
          </template>
        
          
      <script src="../js/app.js"></script>
      

      </body>
        
    </main>

    



</span>



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
    <div class="Copyright"><p class="copy">©, ByteQuest</p></div>
    <script src="../js/bootstrap.bundle.min.js"></script>
</html>