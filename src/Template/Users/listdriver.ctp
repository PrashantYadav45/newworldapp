 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
 <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i> Driver Listing</h1>
                </div>

            </div>
            <div class="row spacing">
                 <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading heading_label">
                                <!--<span class="semi-bold">User Listing</span> -->
                            </div>
                            <div class="row spacing">
                                    <?php echo $this->Form->create(); ?>
                                <div class="col-md-7 right">
                                    <div class="col-xs-6">
                                    <?php echo $this->Form->input('name',array("required"=>'true',"class"=>"form-control","id"=>"filterdriver","placeholder"=>"Search By Username or Email","label"=>"")); ?>
                                    </div>
                                    <?php echo $this->Form->button('Filter', array("class"=>"btn btn-default"),['type' => 'submit']); ?>
                                    <div class="btn btn-default reset"> <?php echo $this->Html->link('Reset',array("class"=>"btn btn-default"), ['action' => 'index']); ?></div>
                                </div>
                                    <?php echo $this->Form->end(); ?>
                                    <div class="btn btn-default btn-danger"><a href="<?php echo HTTP_ROOT ?>users/add" >Add Driver</a>
                                </div>
                            
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <!-- <th><?= $this->Paginator->sort('id') ?></th> -->
                                                <th><?= $this->Paginator->sort('name') ?></th>
                                                <th><?= $this->Paginator->sort('email') ?></th>
                                               <!--  <th><?= $this->Paginator->sort('lat') ?></th>
                                                <th><?= $this->Paginator->sort('lng') ?></th> -->
                                                <th class="actions"><?= __('Actions') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($users)){
                                                foreach ($users as $user): ?>
                                        <tr>
                                            <!-- <td><?= $this->Number->format($user->id) ?></td> -->
                                            <td><?= h($user->name) ?></td>
                                            <td><?= h($user->email) ?></td>
                                           <!--  <td><?= $this->Number->format($user->lat) ?></td>
                                            <td><?= $this->Number->format($user->lng) ?></td> -->
                                            <td class="actions">
                                               
                                                   <?php // $this->Html->link(
                                //  $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-eye-open')),
                                // array('action'=>'view', $user->id), array('class' => 'btn btn-info btn-xs','rel'=>'tooltip', 'data-placement'=>'top', 'title'=>'View', 'target' => '_self','escape' => false))?>
                
                                    <?= $this->Html->link(
                                 $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit')),
                                array('action'=>'edit', $user->id), array('class' => 'btn btn-info btn-xs', 'target' => '_self','escape' => false, 'rel'=>'tooltip', 'data-placement'=>'top', 'title'=>'Edit'))?>

                                    <?= $this->Form->postLink('<i class="glyphicon glyphicon-trash"></i> ',
                                        ['action' => 'delete', $user->id], 
                                        [
                                            'escape' => false,
                                            'confirm' => __('Are you sure, you want to delete?'),
                                            'rel'=>'tooltip', 'data-placement'=>'top', 'title'=>'Delete'
                                        ]
                                    ) ?>

                                    <!-- tooltip -->
                                            <a class="a_active" statusid="<?php echo $user->id; ?>" id="status<?php echo $user->id; ?>" href="<?php echo HTTP_ROOT; ?>users/status"  status="<?php echo $user->status; ?>" > <?php if ($user->status) { ?> 
                                                     Deactivate
                                                        <?php }else{ ?>
                                                             Activate
                                                        <?php } ?>
                                                    </a>

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
    



<script type="text/javascript">

$(document).ready(function() {
  
       $(".a_active").click(function (event){ 

        //alert($(this).text());
        if(!confirm("Are You Sure ?")){
            // $(this).css({"color": "#337ab7"});
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

            //setTimeout(function(){   
             $('#status'+id).text('');
            $('#status'+id).text(json['result']);
             if(json['result'] == 'Activate'){
                $('#status'+id).css("background-color", "green");
            }else{
                $('#status'+id).css("background-color", "");
            }
            $('#status'+id).attr('status','');
            $('#status'+id).attr('status', json['status']); 
            //$(this).attr("data").text(json['status']);
             //}, 500);


            },
            error: function(e){}
        });

    });
  });
    $( ".a_active[status='0']" ).css("background-color", "green");
</script>
