 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                    <h1 class="page-header"><i class="fa fa-user"></i>User Detail</h1>
                </div>

            </div>
            <button class="btn btn-default" onclick="goBack()">Back</button>
            <div class="row spacing">
                 <div class="col-lg-12">
                        <div class="panel panel-default">
   
    <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
        <tr>
            <th><?= __('Name') ?></th>
            <td><?= h($result['name']) ?></td>
        </tr>
        <tr>
            <th><?= __('Image') ?></th>
            <td><img width="100px" src=<?php echo HTTP_ROOT.'img/uploads/'.$result['image'] ?> ></td>
        </tr>
         <tr>
            <th><?= __('Member for') ?></th>
            <td><?php 
                    if($result['month']==0)
                    {
                        $result['month']='';
                    }else{
                        $result['month']=$result['month'].'months,  ';
                    }
                    if($result['year']==0)
                    {
                        $result['year']='';
                    }else{
                        $result['year']=$result['year'].'years,  ';
                    }
            echo $result['year'].$result['month'].$result['week']; ?></td>
        </tr>
                
    </table>

       </div>
            </div>
                    </div>
            </div>
            <!-- /.row -->


        </div>
</div>
    
