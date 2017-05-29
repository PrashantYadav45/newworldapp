 <div id="wrapper">
        <!-- Navigation -->
   <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                    <h1 class="page-header"><i class="fa fa-line-chart"></i> 禮品換領狀態</h1>
                </div>

            </div>
            <div class="row spacing">
                 <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading heading_label">
                                <!-- <span class="semi-bold">Credit Card Listing</span> -->
                             
                            </div>
                            <div class="row spacing">
                        <form action="<?=HTTP_ROOT?>GiftPurchase" method="get">
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
                                      <li class="active"><a data-target="#home" data-toggle="tab">未取</a></li>
                                      <li><a data-target="#profile" data-toggle="tab">已取</a></li>
                                    </ul>

                                    <div class="tab-content">
                                      <div class="tab-pane active" id="home">
                                        <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
												<th>日期</th>
                                                <th>用戶名稱</th>
                                                <th>禮品名稱</th>
												<th></th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                        <?php 
                                        if(!empty($result)){
                                        foreach ($result as $result):
										?>
                                         <tr>
     										<td><?= $result['date']; ?></td>
											<td><?= $result['name']; ?></td>
											<td><?= $result['itemname']; ?></td> 
											<td><input type='checkbox' name='notassigned[]' class='notassigned' value='<?= $result['id']; ?>'></td> 
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
									<button name="submit" value="submit" onclick="approveproduct()">確􅨵</button>
										<button name="cancel" value="cancel" onclick="cancelfun()" >取消</button>
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
												<th>日期</th>
                                                <th>用戶名稱</th>
                                                <th>禮品名稱</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                        <?php 
							
									
                                        if(!empty($resultdata)){
                                        foreach ($resultdata as $resultdept):?>
                                         <tr>
										 <td><?= $resultdept['date'] ?></td>
                                            <td><?= $resultdept['name'] ?></td>
                                            <td><?= $resultdept['itemname'] ?></td> 
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
    <script src="js/jquery.js"></script>
<script type="text/javascript">
 function cancelfun()
        {
						
						window.location.href='';
         
		}
        function approveproduct()
        {
		var values = $('input:checkbox:checked.notassigned').map(function () {
       return this.value;
		}).get();
var urlcont= '';
	$.ajax({
                    type: 'POST',
                    url: '<?php echo HTTP_ROOT ?>GiftPurchase/index',
                    data:{NotAssigned:values},
                    success: function (msg) 
                    {
						
						window.location.href='';
                    },
                });
		
		}
</script>           

