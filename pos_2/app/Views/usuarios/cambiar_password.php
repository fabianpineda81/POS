<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo ?></h4>

            <?php if (isset($validation)) { ?>

                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>

                </div>
            <?php }; ?>


            <form method="POST" action="<?php echo base_url(); ?>/usuarios/actualizar_password" autocomplete="off">
                <div class="from-group">



                    <div class="row mb-3">

                        <div class="col-12 col-sm-6">
                            <label>Usuario</label>
                            <input class="form-control" id="usuario" name="usuario" type="text" value="<?php echo $usuario["usuario"] ?>" disabled />

                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $usuario["nombre"] ?>" disabled />

                        </div>
                    </div>
                </div>

                <div class="from-group">



                    <div class="row mb-3">

                        <div class="col-12 col-sm-6">
                            <label>Contrase</label>
                            <input class="form-control" id="password" name="password" type="text" required />

                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Confirma contraseña</label>
                            <input class="form-control" id="repassword" name="repassword" type="text" required />

                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary">regresar </a>
                <button type="submit" class="btn btn-success">Guardar</button>

                <?php if (isset($mensaje)) { ?>

                    <div class="alert alert-primary">
                        <?php echo $mensaje; ?>

                    </div>
                <?php }; ?>

            </form>
        </div>
    </main>