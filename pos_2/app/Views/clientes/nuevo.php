<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo ?></h4>
            <?php if (isset($validation)) { ?>

                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>

                </div>
            <?php }; ?>

            <form method="POST" action="<?php echo base_url(); ?>/clientes/insertar" autocomplete="off">
                
                <div class="from-group">

                    <div class="row mb-3">

                    <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text"  autofocus />

                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Direccion</label>
                            <input class="form-control" id="direccion" name="direccion" type="text" autofocus  />

                        </div>

                       
                    </div>
                </div>

                
                <div class="from-group">

                    <div class="row mb-3">

                        <div class="col-12 col-sm-6">
                            <label>Telefono</label>
                            <input class="form-control" id="telefono" name="telefono" type="tel" autofocus  />

                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Correo</label>
                            <input class="form-control" id="correo" name="correo" type="email"  />

                        </div>
                    </div>
                </div>

               


                <a href="<?php echo base_url(); ?>/clientes" class="btn btn-primary">regresar </a>
                <button type="submit" class="btn btn-success">Guardar</button>

            </form>
        </div>
    </main>