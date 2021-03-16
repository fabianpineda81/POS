<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo ?></h4>
            <div>
                <p>
                    <a href="<?php echo base_url(); ?>/cajas/nuevo_arqueo" class="btn btn-info">Agregar</a>
                    <a href="<?php echo base_url(); ?>/cajas/eliminados" class="btn btn-warning">eliminados</a>
                </p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fecha apertura</th>
                            <th>Fecha cierre</th>
                            <th>Monto inicial</th>
                            <th>Monto final </th>
                            <th>Total ventas</th> 
                            <th>Estatus</th> 

                        </tr>
                    </thead>
                    <!--  <tfoot>
                                            <tr>
                                                <th>Name</th>
                                                <th>Position</th>
                                                <th>Office</th>
                                                <th>Age</th>
                                                <th>Start date</th>
                                                <th>Salary</th>
                                            </tr>
                                        </tfoot> -->
                    <tbody>
                        <?php
                        foreach ($datos as $dato) { ?>
                            <tr>
                                <td><?php echo $dato['id'];  ?> </td>
                                <td><?php echo $dato['fecha_apertura'];  ?> </td>
                                <td><?php echo $dato['fecha_fin']??'';  ?> </td>
                                <td><?php echo $dato['monto_inicial'];  ?> </td>
                                <td><?php echo $dato['monto_final'];  ?> </td>
                                <td><?php echo $dato['total_ventas'];  ?> </td>
                                

                                
                                  <?php if($dato['estatus']==1){?>
                                  <td>abierta</td>
                                  <td><a data-href="<?php echo base_url().'/cajas/cerrar/'.$dato['id'];?>"  href="#"  data-toggle="modal"data-target="#modal-confirma" data-placement="top" title="Eliminar registro" class="btn btn-danger"><i class="fas fa-lock"></i></a> </td>
                                  <?php }else{?>
                                    <td>Cerrada</td>
                                  <td><a data-href="<?php echo base_url().'/cajas/nuevo_arqueo/'.$dato['id'];?>"  href="#"  data-toggle="modal"data-target="#modal-confirma" data-placement="top" title="Eliminar registro" class="btn btn-danger"><i class="fas fa-print"></i></a> </td>
                                    <?php } ?>
                                

                                </td>

                                

                                

                                
                            </tr>

                        <?php 
                        } ?>

                    </tbody>
                </table>
            </div>

        </div>
    </main>
        <!-- modal -->
    <div class="modal fade" id="modal-confirma" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Eliminar registro </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>¿Desea Eliminar el registro?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-ligth" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-ligth" data-dismiss="modal">No</button>
        <a  class="btn btn-danger btn-ok">Si</a>
      </div>
    </div>
  </div>
</div>