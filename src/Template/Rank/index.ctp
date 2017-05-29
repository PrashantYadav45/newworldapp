 <div id="wrapper">
        <!-- Navigation -->
   <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                    <h1 class="page-header"><i class="fa fa-line-chart"></i> 排行榜</h1>
                </div>

            </div>
            <div class="row spacing">
                 <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading heading_label">
                                <!-- <span class="semi-bold">Credit Card Listing</span> -->
                             
                            </div>
                            <div class="row spacing">
                                    <form action="<?=HTTP_ROOT?>rank" method="get">
                        <div class="col-md-7 right">
                            
                             <div class="col-xs-6">
                            <input type="text" name="name" class="form-control" value="<?= @$_GET['name'] ?>" placeholder="Search By Name"/>
                            </div>
                            
                            <?php echo $this->Form->button('Filter', array("class"=>"btn btn-default"),['type' => 'submit']); ?>
                            <div class="btn btn-default reset"> <?php echo $this->Html->link('Reset', ['action' => 'index']); ?></div>
                        </div>
                         <?php echo $this->Form->end(); ?>

                                    <form action="<?=HTTP_ROOT?>rank/reset" method="get" onsubmit="return confirm('Sure to reset all the score into 0?');">
                   
                            
                            <?php echo $this->Form->button('Score Reset', array("class"=>"btn btn-default"),['type' => 'submit']); ?>
                           
                      
                         <?php echo $this->Form->end(); ?>
                                                
                        </div>

                                                
                       
                            <div class="panel-body">
                                <div class="table-responsive">


                                    <ul class="nav nav-tabs" id="myTab">
                                      <li class="active"><a data-target="#home" data-toggle="tab">個人排名</a></li>
                                      <li ><a data-target="#profile" data-toggle="tab">團隊排名</a></li>
                                    </ul>

                                    <div class="tab-content">
                                      <div class="tab-pane active" id="home">
                                        <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><?= $this->Paginator->sort('name','姓名') ?></th>
  <th><?= $this->Paginator->sort('email','姓名') ?></th>
  <th><?= $this->Paginator->sort('staffid','姓名') ?></th>
                                                <th>分數</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                        <?php 
                                        if(!empty($result)){
                                        foreach ($result as $result):
										?>
                                         <tr>
                                            <td><?= $result['name']; ?></td>
 <td><?= $result['email']; ?></td>
 <td><?= $result['staffid']; ?></td>
                                            <td><?= $result['total']; ?></td> 
                                        </tr>
                                        <tr>
                                        </tr>
                                        <?php endforeach;
                                         }else{ ?>
                                            <tr> <td colspan="4"><center> No Records Found!</center></td></tr>
                                        <?php } 
                                        ?>
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
                                      <div class="tab-pane" id="profile">
                                        <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>部門名稱</th>
                                                <th>分數</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                        <?php 
							
									
                                        if(!empty($resultdata)){
                                        foreach ($resultdata as $resultdept):?>
                                         <tr>
                                            <td><?= $resultdept['dept_name'] ?></td>
                                            <td><?= $resultdept['totalscore'] ?></td> 
                                        </tr>
                                        <tr>
                                        </tr>
                                        <?php endforeach;
                                         }else{ ?>
                                            <tr> <td colspan="4"><center> No Records Found!</center></td></tr>
                                        <?php } 
                                        ?>
                                    </tbody>
                                    </table>
                                      </div>
                                    </div>
 
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /.row -->


        </div>
</div>

<script type="text/javascript">
    jQuery(function () {
   // jQuery('#myTab a:last').tab('show')
})
</script>