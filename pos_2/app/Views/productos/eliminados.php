<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid">
            <h4 class="mt-4"><?php echo $titulo ?></h4>
            <div>
                <p>
                    
                    <a href="<?php echo base_url(); ?>/productos" class="btn btn-warning">Productos</a>
                </p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                        <th>Id</th>
                            <th>codigo</th>
                            <th>nombre</th>
                            <th>precio</th>
                            <th>existencias</th>
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
                                <td><?php echo $dato['id'];  ?> </td>
                                <td><?php echo $dato['codigo'];  ?> </td>
                                <td><?php echo $dato['nombre'];  ?> </td>
                                <td><?php echo $dato['precio_venta'];  ?> </td>
                                <td><?php echo $dato['existencias'];  ?> </td>
                                

                                <td><a data-href="<?php echo base_url().'/productos/reingresar/'.$dato['id'];?>" href="#"  data-toggle="modal"
                                data-target="#modal-confirma" data-placement="top" title="Reingresar registro" ><i class="fas fa-arrow-alt-circle-up"></i></a> 
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
        <h5 class="modal-title" id="exampleModalLabel">Reingresar registro </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>??Desea Reingresar el registro?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-ligth" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-ligth" data-dismiss="modal">No</button>
        <a  class="btn btn-danger btn-ok">Si</a>
      </div>
    </div>
  </div>
</div>