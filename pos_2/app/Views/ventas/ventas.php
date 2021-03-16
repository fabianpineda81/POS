<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo ?></h4>
            <div>
                <p>
                  
                    <a href="<?php echo base_url(); ?>/ventas/eliminados" class="btn btn-warning">eliminados</a>
                </p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Folio</th>
                            <th>Cliente </th>
                            <th>Total</th>
                            <th>Cajaro</th>
                            <th></th>
                            <th></th>

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
                                <td><?php echo $dato['fecha_alta'];  ?> </td>
                                <td><?php echo $dato['folio'];  ?> </td>
                                <td><?php echo $dato['cliente'];  ?> </td>
                                <td><?php echo $dato['total'];  ?> </td>
                                <td><?php echo $dato['cajero'];  ?> </td>
                                <td><a  href="<?php echo base_url().'/factura/facturar/'.$dato['id'];?>" class="btn btn-primary "><i class="fas fa-list"></i></a> </td>
                                <td><a  href="<?php echo base_url().'/ventas/muestraTicket/'.$dato['id'];?>" class="btn btn-primary "><i class="fas fa-list-alt"></i></a> 

                                </td>

                                

                                <td><a data-href="<?php echo base_url().'/ventas/eliminar/'.$dato['id'];?>" href="#"  data-toggle="modal"
                                data-target="#modal-confirma" data-placement="top" title="Eliminar registro" class="btn btn-danger"><i class="fas fa-trash"></i></a> 
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