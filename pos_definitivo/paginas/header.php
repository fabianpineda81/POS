<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html">Start Bootstrap</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#">Settings</a>
                        <a class="dropdown-item" href="#">Activity Log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="login.html">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            
                            
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-shopping-basket"></i></div>
                                Productos
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="../paginas/productos.php">Productos </a>
                                    <a class="nav-link" href="../paginas/frabicantes">Fabricantes</a>
                                    <a class="nav-link" href="../paginas/estantes">Estantes</a>
                                </nav>
                            </div>


                            <a class="nav-link" href="/clientes"><i class="fas fa-users"></i> Clientes </a>

                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menuCompras" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                                Compras
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="menuCompras" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="/compras/nuevo">Nueva compra </a>
                                    <a class="nav-link" href="/compras">Compras</a>
                                    
                                </nav>
                            </div>
                            <a class="nav-link" href="/ventas/venta"><i class="fas fa-cash-register"></i> Caja </a>
                            <a class="nav-link" href="/ventas"><i class="fas fa-shopping-cart"></i> Ventas</a>
                            

                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menuReportes" aria-expanded="false" aria-controls="collapseLayouts">
                               
                                <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                                Reportes
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="menuReportes" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href=" /productos/mostrarMinimos">Reportes minimos </a>
                                    
                                    
                                </nav>
                            </div>
                                 
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#subAdministracion" aria-expanded="false" aria-controls="subAdministracion">
                                <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                                Administracion
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="subAdministracion" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="/configuracion">Configuracion </a>
                                    <a class="nav-link" href="/usuarios">Usuarios </a>
                                    <a class="nav-link" href="/roles">Roles</a>
                                    <a class="nav-link" href="/cajas">Roles</a>
                                     
                                </nav>
                            </div>
                            
                            </div>
                            
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Usuario
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
    

    