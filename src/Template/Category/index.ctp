 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                    <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-gift"></i> Category Listing</h1>
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
                                      <div class="col-xs-6">
                                    <?php echo $this->Form->input('cat_name',array("required"=>'true',"class"=>"form-control","id"=>"filterdriver","placeholder"=>"Search By Category Name","label"=>"")); ?>
                                    </div>
                                    <?php echo $this->Form->button('Filter', array("class"=>"btn btn-default","id"=>"searchForm"),['type' => 'submit']); ?>
                                    <div class="btn btn-default reset"> <?php echo $this->Html->link('Reset',array("class"=>"btn btn-default"), ['action' => 'index']); ?></div>
                                </div>
                                    <?php echo $this->Form->end(); ?>

                                    <div class="btn btn-default btn-danger"><a href="<?php echo HTTP_ROOT ?>category/add" >Add Category Name</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                            <th><?= $this->Paginator->sort('cat_name') ?></th>
                                            <th class="actions"><?= __('Actions') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                      
                                        if(!empty($category)){
                                        foreach ($category as $category): ?>
                                        <tr> 
                                           <td><?= h($category->cat_name) ?></td>
                                           <td class="actions">
                                                       
                                <?= $this->Html->link(
                                 $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit')),
                                array('action'=>'edit', $category->id), array('class' => 'btn btn-info btn-xs', 'target' => '_self','escape' => false, 'rel'=>'tooltip', 'data-placement'=>'top', 'title'=>'Edit'))?>

                                                              
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


 
