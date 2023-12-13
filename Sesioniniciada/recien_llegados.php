<?php

require 'Conexion.php';

$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();

$ultimosProductosQuery = "SELECT p.ID_Producto, p.NombreProduct, p.Precio, p.CantDisponible, MAX(i.Imagen) AS Imagen
                          FROM Productos p
                          LEFT JOIN Imagenes i ON p.ID_Producto = i.ID_Producto
                          WHERE i.video = 0
                          AND p.Eliminado =0
                          AND p.CantDisponible>0
                          GROUP BY p.ID_Producto
                          ORDER BY p.RowDate DESC
                          LIMIT 4";
$ultimosProductosResult = $conexion->query($ultimosProductosQuery);

$categoriaAccesoriosQuery1 = "SELECT p.ID_Producto, p.NombreProduct, p.Precio, p.CantDisponible, MAX(i.Imagen) AS Imagen
                            FROM Productos p
                            LEFT JOIN Imagenes i ON p.ID_Producto = i.ID_Producto
                            WHERE p.ID_Categoria = 1 AND i.video = 0 AND p.CantDisponible>0
                            AND p.Eliminado =0
                            GROUP BY p.ID_Producto
                            ORDER BY p.RowDate DESC
                            LIMIT 4";

$categoriaAccesoriosResult1 = $conexion->query($categoriaAccesoriosQuery1);

$categoriaAccesoriosQuery2 = "SELECT p.ID_Producto, p.NombreProduct, p.Precio, p.CantDisponible, MAX(i.Imagen) AS Imagen
                            FROM Productos p
                            LEFT JOIN Imagenes i ON p.ID_Producto = i.ID_Producto
                            WHERE p.ID_Categoria = 2 AND i.video = 0 AND p.CantDisponible>0
                            AND p.Eliminado =0
                            GROUP BY p.ID_Producto
                            ORDER BY p.RowDate DESC
                            LIMIT 4";

$categoriaAccesoriosResult2 = $conexion->query($categoriaAccesoriosQuery2);

$categoriaAccesoriosQuery3 = "SELECT p.ID_Producto, p.NombreProduct, p.Precio, p.CantDisponible, MAX(i.Imagen) AS Imagen
                            FROM Productos p
                            LEFT JOIN Imagenes i ON p.ID_Producto = i.ID_Producto
                            WHERE p.ID_Categoria = 3 AND i.video = 0 AND p.CantDisponible>0
                            AND p.Eliminado =0
                            GROUP BY p.ID_Producto
                            ORDER BY p.RowDate DESC
                            LIMIT 4";

$categoriaAccesoriosResult3 = $conexion->query($categoriaAccesoriosQuery3);

$categoriaAccesoriosQuery4 = "SELECT p.ID_Producto, p.NombreProduct, p.Precio, p.CantDisponible, MAX(i.Imagen) AS Imagen
                            FROM Productos p
                            LEFT JOIN Imagenes i ON p.ID_Producto = i.ID_Producto
                            WHERE p.ID_Categoria = 4 AND i.video = 0 AND p.CantDisponible>0
                            AND p.Eliminado =0
                            GROUP BY p.ID_Producto
                            ORDER BY p.RowDate DESC
                            LIMIT 4";

$categoriaAccesoriosResult4 = $conexion->query($categoriaAccesoriosQuery4);
?>


<section class="container-products" >
    <?php
    echo "<h2 class='main-title'>Recien llegados</h2";
    echo "<div class='horizontal-container-products'>";
    while ($row_producto = $ultimosProductosResult->fetch_assoc()) {
        echo "<div class='product'>
                <img src='" . $row_producto['Imagen'] . "' alt='' class='product__img'>
                <div class='product__description'>
                   <h3 class='product__title'>" . $row_producto['NombreProduct'] . "</h3>
                    <span class='product__price'>$" . $row_producto['Precio'] . "</span> 
                </div>
                <i class='product__icon fa-solid fa-cart-plus'></i>
                <p></p><a type='button' class='btn btn-sm btn-outline-secondary' href='Producto.php?id=" . $row_producto['ID_Producto'] . "'>Ver producto</a>
            
            </div>";
            
    }
    echo "</section>";
    
    echo "<section class='container-products'>";
    echo "<h2 class='main-title'>accesorios</h2";
    while ($row_producto = $categoriaAccesoriosResult1->fetch_assoc()) {
        echo "<div class='product'>
                <img src='".$row_producto['Imagen']."' alt='' class='product__img'>
                <div class='product__description'>
                   <h3 class='product__title'>" . $row_producto['NombreProduct'] . "</h3>
                    <span class='product__price'>$" . $row_producto['Precio'] . "</span> 
                </div>
                <i class='product__icon fa-solid fa-cart-plus'></i>
                <p></p><a type='button' class='btn btn-sm btn-outline-secondary' href='Producto.php?id=" . $row_producto['ID_Producto'] . "'>Ver producto</a>
    
            </div>";
    }
    echo "</section>";
    
    echo "<section class='container-products'>";
    echo "<h2 class='main-title'>pantallas</h2";
    while ($row_producto = $categoriaAccesoriosResult2->fetch_assoc()) {
        echo "<div class='product'>
                <img src='".$row_producto['Imagen']."' alt='' class='product__img'>
                <div class='product__description'>
                   <h3 class='product__title'>" . $row_producto['NombreProduct'] . "</h3>
                    <span class='product__price'>$" . $row_producto['Precio'] . "</span> 
                </div>
                <i class='product__icon fa-solid fa-cart-plus'></i>
                <p></p><a type='button' class='btn btn-sm btn-outline-secondary' href='Producto.php?id=" . $row_producto['ID_Producto'] . "'>Ver producto</a>
            
            </div>";
    }
    echo "</section>";
    
    echo "<section class='container-products'>";
    echo "<h2 class='main-title'>setups</h2";
    while ($row_producto = $categoriaAccesoriosResult3->fetch_assoc()) {
        echo "<div class='product'>
                <img src='".$row_producto['Imagen']."' alt='' class='product__img'>
                <div class='product__description'>
                   <h3 class='product__title'>" . $row_producto['NombreProduct'] . "</h3>
                    <span class='product__price'>$" . $row_producto['Precio'] . "</span> 
                </div>
                <i class='product__icon fa-solid fa-cart-plus'></i>
                <p></p><a type='button' class='btn btn-sm btn-outline-secondary' href='Producto.php?id=" . $row_producto['ID_Producto'] . "'>Ver producto</a>
           
            </div>";
    }
    echo "</section>";
    
    echo "<section class='container-products'>";
    echo "<h2 class='main-title'>videojuegos y consolas</h2";
    while ($row_producto = $categoriaAccesoriosResult4->fetch_assoc()) {
        echo "<div class='product'>
                <img src='".$row_producto['Imagen']."' alt='' class='product__img'>
                <div class='product__description'>
                   <h3 class='product__title'>" . $row_producto['NombreProduct'] . "</h3>
                    <span class='product__price'>$" . $row_producto['Precio'] . "</span> 
                </div>
                <i class='product__icon fa-solid fa-cart-plus'></i>
                <p></p><a type='button' class='btn btn-sm btn-outline-secondary' href='Producto.php?id=" . $row_producto['ID_Producto'] . "'>Ver producto</a>
         
            </div>";
    }
    echo "</section>";
    $conexion->close();
    ?>


</section>
