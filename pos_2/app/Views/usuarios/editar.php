<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo ?></h4>

            <?php if (isset($validation)) { ?>

                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>

                </div>
            <?php }; ?>

            <form method="POST" action="<?php echo base_url(); ?>/usuarios/actualizar" autocomplete="off">
                <?php csrf_field() ?>
                <input type="hidden" id="id" name="id" value="<?php echo $usuario["id"]; ?>"> 
                <div class="from-group">

                    <div class="row mb-3">

                        <div class="col-12 col-sm-6">
                            <label>Usuario</label>
                            <input class="form-control" id="usuario" name="usuario" type="text" value="<?php echo  $usuario["usuario"]?>" autofocus required />

                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Nombre </label>
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo  $usuario["nombre"] ?> " required />

                        </div>
                    </div>

                    

                    <div class="from-group">

                        <div class="row mb-3">

                            <div class="col-12 col-sm-6">
                                <label>Caja</label>
                                <select class="form-control" id="id_caja" name="id_caja">
                                    <option>Selecionar caja </option>
                                    <?php foreach ($cajas as $caja) { ?>

                                        <option value="<?php echo $caja['id'] ?>" <?php if($usuario["id_caja"]==$caja["id"]){echo "selected";} ?>><?php echo $caja['nombre'] ?></option>

                                    <?php } ?>
                                </select>

                            </div>

                            <div class="col-12 col-sm-6">
                                <label>Roles</label>
                                <select class="form-control" id="id_rol" name="id_rol">
                                    <option>Selecionar rol</option>
                                    <?php foreach ($roles as $rol) { ?>

                                        <option value="<?php echo $rol['id'] ?>" <?php if($usuario["id_rol"]==$rol['id']){echo "selected";}?>><?php echo $rol['nombre'] ?></option>

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