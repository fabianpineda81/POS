<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo; ?></h4>
            <?php if (isset($validation)) { ?>

                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>

                </div>
            <?php }; ?>



            <form method="POST" action="<?php echo base_url(); ?>/usuarios/insertar" autocomplete="off">
                <?php csrf_field() ?>
                <div class="from-group">

                    <div class="row mb-3">

                        <div class="col-12 col-sm-6">
                            <label>Usuario</label>
                            <input class="form-control" id="usuario" name="usuario" type="text" value="<?php echo  set_value('usuario') ?>" autofocus required />

                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Nombre </label>
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo  set_value('nombre') ?> " required />

                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-12 col-sm-6">
                            <label>Password</label>
                            <input class="form-control" id="password" name="password" type="text" value="<?php echo  set_value('password') ?>" required />

                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Repite contraseña </label>
                            <input class="form-control" id="repassword" name="repassword" type="text" value="<?php echo  set_value('repassword') ?> " required />

                        </div>
                    </div>

                    <div class="from-group">

                        <div class="row mb-3">

                            <div class="col-12 col-sm-6">
                                <label>Caja</label>
                                <select class="form-control" id="id_caja" name="id_caja">
                                    <option>Selecionar caja </option>
                                    <?php foreach ($cajas as $caja) { ?>

                                        <option value="<?php echo $caja['id'] ?>"><?php echo $caja['nombre'] ?></option>

                                    <?php } ?>
                                </select>

                            </div>

                            <div class="col-12 col-sm-6">
                                <label>Roles</label>
                                <select class="form-control" id="id_rol" name="id_rol">
                                    <option>Selecionar rol</option>
                                    <?php foreach ($roles as $rol) { ?>

                                        <option value="<?php echo $rol['id'] ?>"><?php echo $rol['nombre'] ?></option>

                                    <?php } ?>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url(); ?>/usuarios" class="btn btn-primary">regresar </a>
                <button type="submit" class="btn btn-success">Guardar</button>

            </form>
        </div>
    </main>