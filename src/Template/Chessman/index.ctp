 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
 <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i>康樂棋</h1>
                </div>

            </div>
            <div class="row spacing">
                 <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading heading_label">
                                <!--<span class="semi-bold">User Listing</span> -->
                            </div>
                            <div class="row spacing">
                                     
                                <div class="col-md-7 right">
                                    
                                </div>
                                    
                                    <div class="btn btn-default btn-danger"><a href="<?php echo HTTP_ROOT ?>chessman/addGame" >加入遊戲</a>
                                </div>
                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><?= $this->Paginator->sort('title','活動名稱') ?></th>
<!--                                                <th><?= $this->Paginator->sort('game_type','遊戲類別') ?></th>-->
 <th><?php echo '遊戲類別'; ?></th>
<!--                                                 <th><?= $this//->Paginator->sort('created','Date of Establishment') ?></th>
 -->                                                
                                                <th class="actions"><?= __('操作') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($chessmanlistings)){
                                                foreach ($chessmanlistings as $list): ?>
                                        <tr>
                                            <td><?= h($list->title) ?></td>
                                            <td><?= h($list->game_type) ?></td>
<!--                                             <td><?= $list//->created ?></td>
 -->                                            <td class="actions">
                                                
                                    <?= $this->Html->link(
                                 $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit')),
                                array('action'=>'editGame', $list->id), array('class' => 'btn btn-info btn-xs', 'target' => '_self','escape' => false, 'rel'=>'tooltip', 'data-placement'=>'top', 'title'=>'Edit'))?>

                                    <?= $this->Form->postLink('<i class="glyphicon glyphicon-trash"></i> ',
                                        ['action' => 'deleteGame', $list->id], 
                                        [
                                            'escape' => false,
                                            'confirm' => __('Are you sure, you want to delete?'),
                                            'rel'=>'tooltip', 'data-placement'=>'top', 'title'=>'Delete'
                                        ]
                                    ) ?>

                                    <!-- tooltip -->
                                           

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
    
