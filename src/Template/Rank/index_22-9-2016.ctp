 <div id="wrapper">
        <!-- Navigation -->
   <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                    <h1 class="page-header"><i class="fa fa-line-chart"></i> RANK</h1>
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
                            
                             <!--<div class="col-xs-6">
                            <input type="text" name="name" class="form-control" value="<?= @$_GET['name'] ?>" placeholder="Search By Name"/>
                            </div>
                            
                            <?php echo $this->Form->button('Filter', array("class"=>"btn btn-default"),['type' => 'submit']); ?>
                            <div class="btn btn-default reset"> <?php echo $this->Html->link('Reset', ['action' => 'index']); ?></div>-->
                        </div>
                         <?php echo $this->Form->end(); ?>
                                                
                        </div>

                            <div class="panel-body">
                                <div class="table-responsive">


                                    <ul class="nav nav-tabs" id="myTab">
                                      <li class="active"><a data-target="#home" data-toggle="tab">Personal Ranking</a></li>
                                      <li><a data-target="#profile" data-toggle="tab">Group Ranking</a></li>
                                    </ul>

                                    <div class="tab-content">
                                      <div class="tab-pane active" id="home">
                                        <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><?= $this->Paginator->sort('user_id','Name') ?></th>
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                        <?php 
                                        if(!empty($result)){
                                        foreach ($result as $result):?>
                                         <tr>
                                            <td><?= $result->user['name']; ?></td>
                                            <td><?= $result->total; ?></td> 
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
                                            <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                            <?= $this->Paginator->numbers() ?>
                                            <?= $this->Paginator->next(__('next') . ' >') ?>
                                        </ul>
                                        <p><?= $this->Paginator->counter() ?></p>
                                    </div>

                                    </div>
                                      <div class="tab-pane" id="profile">
                                        <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>Department Name</th>
                                                <th>Total Score</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                        <?php 
                                        if(!empty($deptNames)){
                                        foreach ($deptNames as $result):?>
                                         <tr>
                                            <td><?= $result['user']['department']['dept_name'] ?></td>
                                            <td><?= $result['total'] ?></td> 
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
    jQuery('#myTab a:last').tab('show')
})
</script>