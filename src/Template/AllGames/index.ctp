 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                    <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-gift"></i> All Games Listing</h1>
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
                                    <?php echo $this->Form->input('name',array("required"=>'true',"class"=>"form-control","id"=>"filterdriver","placeholder"=>"Search By Title","label"=>"")); ?>
                                    </div>
                                    <?php echo $this->Form->button('Filter', array("class"=>"btn btn-default","id"=>"searchForm"),['type' => 'submit']); ?>
                                    <div class="btn btn-default reset"> <?php echo $this->Html->link('Reset',array("class"=>"btn btn-default"), ['action' => 'index']); ?></div>
                                </div>
                                    <?php echo $this->Form->end(); ?>

                                    <div class="btn btn-default btn-danger"><a href="<?php echo HTTP_ROOT ?>AllGames/add" >Add Game</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                            <th><?= $this->Paginator->sort('title','Title') ?></th>
                                            <th><?= $this->Paginator->sort('game_type','Game Type') ?></th>
                                            <th><?= $this->Paginator->sort('startdate','Start Date') ?></th>
                                            <th><?= $this->Paginator->sort('enddate','End Date') ?></th>
                                            <th class="actions"><?= __('Actions') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                      
                                        if(!empty($games)){
                                        foreach ($games as $game): ?>
                                        <tr> 
                                           <td><?= h($game->title) ?></td>
                                           <td><?= $game->game_type ?></td>
                                           <td><?= $game->startdate ?></td>
                                           <td><?= $game->enddate ?></td>
                                           <td class="actions">
                                                       
                                <?= $this->Html->link(
                                 $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit')),
                                array('action'=>'edit', $game->id), array('class' => 'btn btn-info btn-xs', 'target' => '_self','escape' => false, 'rel'=>'tooltip', 'data-placement'=>'top', 'title'=>'Edit'))?>

                                <?= $this->Form->postLink('<i class="glyphicon glyphicon-trash"></i> ',
                                        ['action' => 'delete', $game->id], 
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
                                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                        <?= $this->Paginator->numbers() ?>
                                        <?= $this->Paginator->next(__('next') . ' >') ?>
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


 
