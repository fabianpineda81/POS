<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo; ?></h4>
            <?php  if(isset($validation)){?>

                <div class="alert alert-danger">
                <?php echo $validation->listErrors(); ?>

            </div>
            <?php };?>



            <form method="POST" action="<?php echo base_url(); ?>/unidades/insertar" autocomplete="off">
            <?php csrf_field() ?>
                <div class="from-group">

                    <div class="row mb-3">

                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo  set_value('nombre') ?>" autofocus required />

                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Numero caja</label>
                            <input class="form-control" id="numero_caja" name="numero_caja" type="text"  value="<?php echo  set_value('numero_caja')?> " required />

                        </div>
                    </div>
                </div>

                <a href="<?php echo base_url(); ?>/unidades" class="btn btn-primary">regresar </a>
                <button type="submit" class="btn btn-success">Guardar</button>

            </form>
        </div>
    </main>