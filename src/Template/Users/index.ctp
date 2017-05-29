 
 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i> 成員</h1>
                </div>

            </div>
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                     <?= $this->Flash->render();?>
                </div>
                 <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading heading_label">
                              </div>
                            <div class="row spacing">
                                    <?php echo $this->Form->create(); ?>
                             <div class="col-md-7 ">
                                     <div class="col-xs-6 right">
                                    <?php echo $this->Form->input('name',array("required"=>'true',"class"=>"form-control","id"=>"filterdriver","placeholder"=>"Search By Username or Email","label"=>"")); ?>
                                    </div>
                                    <?php echo $this->Form->button('Filter', array("class"=>"btn btn-default","id"=>"searchForm"),['type' => 'submit']); ?>
                                    <div class="btn btn-default reset"> <?php echo $this->Html->link('Reset',array("class"=>"btn btn-default"), ['action' => 'index']); ?></div>
                                </div>
                                    <?php echo $this->Form->end(); ?>

                                    <div class="btn btn-default btn-danger"><a href="<?php echo HTTP_ROOT ?>users/add?role=user" >加入成員</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th><?= $this->Paginator->sort('name','姓名') ?></th>
                                                <th><?= $this->Paginator->sort('email','電郵') ?></th>
                                                <th><?= $this->Paginator->sort('status','狀態') ?></th>
                                                  <th><?= $this->Paginator->sort('department_id','部門') ?></th>
                                            <th><?= $this->Paginator->sort('role_id','身份') ?></th>
<!--<th>身份</th>-->
                                          
                                                
                                                <th class="actions"><?= __('操作','操作') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                            if(!empty($users)){
                                                foreach ($users as $user): 
                                                    //$user->created;
                                                 $userdate=strtotime($user->created);
                                                   /* $date1=$userdate->i18nFormat('YYYY-MM-d');
                                                    $date2=date('Y-m-d');
                                                    $diff = abs(strtotime($date2) - strtotime($date1));
                                                        $years = floor($diff / (365*60*60*24));
                                                        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
                                                        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                                        if($days>7)
                                                        {
                                                          $days=floor($days/7).' week '.floor($days%7).' days';  
                                                          
                                                        }
                                                        else{
                                                            $days=floor($days%7).' days';
                                                        }
                                                        if($months==0)
                                                        {
                                                            if($days>6)
                                                            {
                                                            $months=floor($days/7).' week ';
                                                            }
                                                            else{
                                                                $months='';
                                                            }
                                                        }
                                                        else{
                                                            $months=$months.' months ';
                                                        }*/
                                                    ?>
                                        <tr>                                          
                                            <td><?= h($user->name) ?></td>
                                            <td style="overflow:hidden;"title="<?= h($user->email) ?>"><?= h($user->email) ?></td>
                                            <td><?php if(($user->status)==1){ 
                                                echo 'active'; } 
                                                else{ echo 'blocked'; } ?></td>
                                           <td><?= h($user->department->dept_name) ?></td>
  <?php if ($user->role_id==2){
                                                ?>
                                         <td> <input type="checkbox" href="<?php echo HTTP_ROOT; ?>users/roles" statusaid="<?php echo $user->id; ?>" class="link" name="role_id" value="2" checked></td>

                                             <?php }else{
                                                ?>

                             <td> <input type="checkbox" href="<?php echo HTTP_ROOT; ?>users/roles" statusaid="<?php echo $user->id; ?>"  class="link" name="role_id" value="3" ></td>

                                     <?php         }

?>

                                          
                                            <td class="actions">
                                                       
                                <?= $this->Html->link(
                                 $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit')),
                                array('action'=>'edit', $user->id ,'?role=user'), array('class' => 'btn btn-info btn-xs', 'target' => '_self','escape' => false, 'rel'=>'tooltip', 'data-placement'=>'top', 'title'=>'Edit'))?>
                                <?= $this->Form->postLink('<i class="glyphicon glyphicon-trash"></i> ',
                                        ['action' => 'delete', $user->id], 
                                        [
                                            'escape' => false,
                                            'confirm' => __('Are you sure, you want to delete?'),
                                            'rel'=>'tooltip', 'data-placement'=>'top', 'title'=>'Delete'
                                        ]
                                    ) ?>

                                        <a class="a_active" statusid="<?php echo $user->id; ?>" id="status<?php echo $user->id; ?>" href="<?php echo HTTP_ROOT; ?>users/status"  status="<?php echo $user->status; ?>" > <?php if ($user->status) { ?> 
                                                   關閉
                                                        <?php }else{ ?>
                                                        啟動
                                                        <?php } ?>
                                                    </a>

                                    </td>
                                            
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php }else{ ?>
                                    <tr> <td colspan="6"><center>No Records Found!</center></td></tr>
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
<?php

function humanTiming ($time)
{

    $time = time() - $time; // to get the time since that moment
    $time = ($time<1)? 1 : $time;
    $tokens = array (
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
    }

}

?>

<script type="text/javascript">

$(document).ready(function() {
       $(".a_active").click(function (event){ 
        if(!confirm("Are You Sure ?")){
         return false;
        }
        event.preventDefault();
        var id=$(this).attr('statusid');
        var url = $(this).attr("href");
        var data = $(this).attr("status");

        $.ajax({
            type:"GET",
            url:url,
            data:{'status':data,'id':id},
            success: function(result){
            var json = $.parseJSON(result);
            $('#status'+id).text('');
            $('#status'+id).text(json['result']);
             if(json['result'] == 'Activate'){
                $('#status'+id).css("background-color", "green");
                location.reload();
            }else{
                $('#status'+id).css("background-color", "");
                location.reload();
            }
            $('#status'+id).attr('status','');
            $('#status'+id).attr('status', json['status']); 
            },
            error: function(e){}
        });

    });
  });
    $( ".a_active[status='0']" ).css("background-color", "green");
</script>

<script type="text/javascript">

$(document).ready(function() {
       $(".link").click(function (event){ 
        if(!confirm("Are You Sure ?")){
         return false;
        }
        event.preventDefault();
        var id=$(this).attr('statusaid');

        var url = $(this).attr("href");
    
        var data = $(this).attr("value");
      
        $.ajax({
            type:"GET",
            url:url,
            data:{'role_id':data,'id':id},
            success: function(result){
         
        location.reload();
       
            },
            error: function(e){}
        });

    });
  });
    $( ".a_active[status='0']" ).css("background-color", "green");
</script>


 
