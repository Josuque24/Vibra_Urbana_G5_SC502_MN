<?php
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="home.php">Vibra Urbana</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link" href="home.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="productos.php">Productos</a></li>
                <li class="nav-item"><a class="nav-link" href="categorias.php">Categorías</a></li>
                <li class="nav-item"><a class="nav-link" href="sobre_nosotros.php">Sobre Nosotros</a></li>
                <li class="nav-item"><a class="nav-link" href="ayuda.php">Ayuda</a></li>
                <li class="nav-item"><a class="nav-link" href="cuenta.php">Cuenta</a></li>
                <li class="nav-item"><a class="nav-link" href="carrito.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" class="bi bi-cart"
                            viewBox="0 0 16 16" alt="boton carrito">
                            <path
                                d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2">
                            </path>
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <form action="include/logout.php" method="post" class="d-flex align-items-center mb-0">
                        <button type="submit" class="nav-link bg-transparent border-0 p-0" style="cursor: pointer;" alt="boton cerrar sesion">
                            <img src="./assets/icons/red_logout.png" width="20" height="20" alt="Cerrar sesión"
                                style="filter: brightness(0) invert(1); vertical-align: middle;">
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>