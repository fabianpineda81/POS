<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo ?></h4>
            <?php if (isset($validation)) { ?>

                <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>

                </div>
            <?php }; ?>

            <form method="POST"  enctype="multipart/form-data" action="<?php echo base_url(); ?>/cajas/nuevo_arqueo" autocomplete="off">

                <div class="from-group">

                    <div class="row mb-3">

                        <div class="col-12 col-sm-6">
                            <label>Numero de caja</label>
                            <input class="form-control" id="numero_caja" name="numero_caja" value="<?php echo $caja['numero_caja'] ?>" type="text" autofocus required />

                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" value="<?php echo $session->nombre ?>" type="text" required />

                        </div>
                    </div>
                </div>

              

                <div class="from-group">

                    <div class="row mb-3">

                        <div class="col-12 col-sm-6">
                            <label> Monto inicial</label>
                            <input class="form-control" id="monto_inicial" name="monto_inicial" type="text" autofocus required />

                        </div>

                        <div class="col-12 col-sm-6">
                            <label>Folio inicial</label>
                            <input class="form-control" id="folio" name="folio" value="<?php echo $caja['folio'] ?>" type="text" required />

                        </div>
                    </div>
                </div>

                <div class="from-group">

                    <div class="row mb-3">

                        <div class="col-12 col-sm-6">
                            <label>Fecha </label>
                            <input class="form-control" id="fecha" name="fecha" type="text" value="<?php echo date('Y-m-d') ?>" autofocus required />

                        </div>

                        <div class="col-12 col-sm-6">
                            <label> Hora </label>
                            <input class="form-control" id="hora" name="hora" type="text" value="<?php echo date('H-i-s') ?>" autofocus required />

                        </div>

                        
                    </div>
                </div>

                


                <a href="<?php echo base_url(); ?>/productos" class="btn btn-primary">regresar </a>
                <button type="submit" class="btn btn-success">Guardar</button>

            </form>
        </div>
    </main>