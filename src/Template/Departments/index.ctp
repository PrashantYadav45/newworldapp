 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                    <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-cubes"></i> 部門</h1>
                </div>

            </div>
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                     <?= $this->Flash->render();?>
                </div>
                 <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading heading_label">
                               <!--  <span class="semi-bold">User Listing</span> -->
                            </div>
                            <div class="row spacing">
                                    <?php echo $this->Form->create(); ?>
                                <div class="col-md-7 right">
                                    <!--  <div class="col-xs-6">
                                    <?php echo $this->Form->input('title',array("required"=>'true',"class"=>"form-control","id"=>"filterdriver","placeholder"=>"Search By Title","label"=>"")); ?>
                                    </div>
                                    <?php echo $this->Form->button('Filter', array("class"=>"btn btn-default","id"=>"searchForm"),['type' => 'submit']); ?>
                                    <div class="btn btn-default reset"> <?php echo $this->Html->link('Reset',array("class"=>"btn btn-default"), ['action' => 'index']); ?></div>-->
                                </div>
                                    <?php echo $this->Form->end(); ?>

                                    <div class="btn btn-default btn-danger"><a href="<?php echo HTTP_ROOT ?>departments/adddepartment" > 加入部門</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                             <!-- <th><?= $this->Paginator->sort('id') ?></th>-->
                                            <th><?= $this->Paginator->sort('dept_name','部門名稱') ?></th>
                                            <th class="col-xs-3"><?=__('部門標') ?></th>
                                            <th class="actions"><?= __('操作') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                       
                                        if(!empty($departments)){

                                          //  print_r($Departments);die;

                                          // printer_draw_text(printer_handle, text, x, y)
                                        foreach ($departments as $Departmentseach): ?>
                                        <tr> 
                                            <!-- <td><?= h($onsite->id) ?></td>-->                       
                                            <td><?= h($Departmentseach->dept_name) ?></td>
                                                                
                                           <td>

                                    <img width="50px;" src=<?php echo HTTP_ROOT.'img/uploads/'.$Departmentseach->image; ?> >

                                           </td>
                                            <td class="actions">
                                                 <?= $this->Html->link(
                                 $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit')),
                                array('action'=>'edit', $Departmentseach->id), array('class' => 'btn btn-info btn-xs', 'target' => '_self','escape' => false, 'rel'=>'tooltip', 'data-placement'=>'top', 'title'=>'Edit'))?>       
                                
                                      <?= $this->Form->postLink('<i class="glyphicon glyphicon-trash"></i> ',
                                        ['action' => 'delete', $Departmentseach->id], 
                                        [
                                            'escape' => false,
                                            'confirm' => __('Are you sure, you want to delete?'),
                                            'rel'=>'tooltip', 'data-placement'=>'top', 'title'=>'Delete'
                                        ]
                                    ) ?>
                                     
                                    </td>                                            
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php }else{ ?>
                                            <tr> <td colspan="6"><center> No Records Found!</center></td></tr>
                                        <?php } ?>
                                    </tbody>
                                    </table>
                                    <div class="paginator">
                                    <ul class="pagination">
                                        <?= $this->Paginator->prev('< ' . __('上一頁')) ?>
                                        <?= $this->Paginator->numbers() ?>
                                        <?= $this->Paginator->next(__('下一頁') . ' >') ?>
                                    </ul>
                                    <p><?= $this->Paginator->counter() ?></p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /.row -->


        </div>
</div>


 
