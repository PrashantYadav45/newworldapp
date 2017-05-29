 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                    <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-gift"></i> 禮品清單</h1>
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
                             <div class="col-xs-2">
                            <form action="<?php echo HTTP_ROOT;?>items" method="post" >
                                <select class="form-control" name="range" onchange="this.form.submit()">
                                    <option>選擇禮品類別</option>
                                    <option>3500-10000</option>
                                    <option>1000-2000</option>
                                    <option>500-1000</option>
                                    <option>0-500</option>
                                </select>
                            </form>
                            </div>
                                    <?php echo $this->Form->create(); ?>
                                <div class="col-md-7 right">
                                      <!--<div class="col-xs-6">
                                    <?php echo $this->Form->input('item_title',array("required"=>'true',"class"=>"form-control","id"=>"filterdriver","placeholder"=>"Search By Title","label"=>"")); ?>
                                    </div>
                                    <?php echo $this->Form->button('Filter', array("class"=>"btn btn-default","id"=>"searchForm"),['type' => 'submit']); ?>
                                    <div class="btn btn-default reset"> <?php echo $this->Html->link('Reset',array("class"=>"btn btn-default"), ['action' => 'index']); ?></div> -->
                                </div>
                                    <?php echo $this->Form->end(); ?>

                                    <div class="btn btn-default btn-danger"><a href="<?php echo HTTP_ROOT ?>items/add" >加入禮品</a>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead>
                                            <tr>
                                             <!--<th><?= $this->Paginator->sort('id') ?></th>-->
                                            <th><?php echo '項目名稱'; ?></th>
                                            <th><?php echo '描述'; ?></th>
					    <th><?php echo '換領方法'; ?></th>
                                            <th><?php echo '條款'; ?></th>
                                            <th><?php echo '所需分數'; ?></th>
                                            <th><?php echo '圖像'; ?></th>
                                            <th class="actions"><?= __('操作') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                      
                                        if(!empty($item)){
                                        foreach ($item as $item): ?>
                                        <tr> 
                                            <!-- <td><?= h($item->id) ?></td> -->                       
                                           <td><?= h($item->item_title) ?></td>
                                            <td><?= h($item->description) ?></td>
					<?php 
                                            if(strlen($item->method_redemmption) >= 15)
                                            {
                                            ?>
                                            <td>  <?php echo "" .substr($item->method_redemmption, 0, 15) . '...'; ?></td>
                                            <?php
                                            }else{ ?>
                                            <td>  <?php echo "" .$item->method_redemmption; ?></td>
                                            <?php
                                            }

                                            ?>

                                            <?php 
                                            if(strlen($item->terms_conditions) >= 15)
                                            {
                                            ?>
                                            <td>  <?php echo "" .substr($item->terms_conditions, 0, 15) . '...'; ?></td>
                                            <?php
                                            }else{ ?>
                                            <td>  <?php echo "" .$item->terms_conditions; ?></td>
                                            <?php
                                            }

                                            ?>
                                            <td><?= h($item->score) ?></td>
                                            <td>
                                             <?php if(!empty($item->image)) {?>
                                    <img width="50px;" src=<?php echo HTTP_ROOT.'img/uploads/'.$item->image; ?> >
                                    <?php } ?>
                                </td>

                                            <td class="actions">
                                                       
                                <?= $this->Html->link(
                                 $this->Html->tag('span', '', array('class' => 'glyphicon glyphicon-edit')),
                                array('action'=>'edit', $item->id), array('class' => 'btn btn-info btn-xs', 'ta