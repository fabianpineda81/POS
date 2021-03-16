<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
        <br>
        <div class="row">
            <div class="col-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        Total de productos: <?php echo $total?>
                    </div>

                    <a  class="card-footer text-white" href="<?php echo base_url() ?>./productos">Ver detalles </a>
                </div>
            </div>
        
        
        
            <div class="col-4">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        Total del ventas dias: <?php echo $totalVentas['total']?>
                    </div>

                    <a  class="card-footer text-white" href="<?php echo base_url() ?>./ventas">Ver detalles </a>
                </div>
            </div>
        
        
        
            <div class="col-4">
                <div class="card text-white bg-danger">
                    <div class="card-body">
                       Productos con stok minimos  <?php echo $minimos?>
                    </div>

                    <a  class="card-footer text-white" href="<?php echo base_url() ?>./productos/mostrarMinimos">Ver detalles </a>
                </div>
            </div>
        
        </div>
        
        </div>
    </main>