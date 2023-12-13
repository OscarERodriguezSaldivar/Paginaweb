<html>
    <head>
        <meta charset="UTF-8">
        <title>Tienda Online</title>
        <meta name="viewport" content="width=devide-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minimum-scale=1.0">
        <link rel="stylesheet" href="../css/estilos.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
        <link rel="icon" type="image/png" href="../img/logo.JPG">

        
        <link href="../css/bootstrap.min.css" rel="stylesheet">

    </head>
    <header class="p-3 text-bg-dark">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            <h1 class="main-header__title">ByteQuest</h1>

         
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <br></br>
              <li><a href="1index.php" class="nav-link px-2 text-white">Home</a></li>&nbsp;&nbsp;&nbsp;&nbsp;
              <li><a href="tienda.php" class="nav-link px-2 text-secondary">Shop</a></li>&nbsp;&nbsp;&nbsp;&nbsp;
              
            </ul>
    
            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
              <input type="search" class="form-control form-control-dark text-bg-dark" placeholder="Search..." aria-label="Search">
            </form>
    
            <div class="text-end">
                <a type="button" href="pregunta.html" class="btn btn-outline-light me-2"> <i class="fa-solid fa-user"></i> Registrate/Inicio Sesión</a>
            </div>
          </div>
        </div>
      </header>
    <main class="main">
        <?php include 'productostienda.php'; ?>
    </main>
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

</html>