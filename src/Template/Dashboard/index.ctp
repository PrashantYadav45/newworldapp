 <div id="wrapper">
<!-- Navigation -->
<?= $this->element('nav'); ?>
<div class="main-container container" id="page-wrapper">
<div class="row">
<section class="col-sm-9">            	   
<ul class="tabs--primary nav nav-tabs">        		
		</ul>
            <a id="main-content"></a>
            <h1 class="page-header">儀表板</h1>
                    <div id="content">
             
            <div style="min-height: 700px;" class="inner">
              
                 <!--BLOCK SECTION -->
                 <div class="row">
                    <div class="col-lg-12">
                        <div style="text-align: center;">
                           
                            <a href="#" class="quick-btn">
                                <i class="fa fa-dot-circle-o fa fa-2x"></i>
                                <span> 康樂棋</span>
                                <span class="label label-danger">2</span>
                            </a>

                            <a href="#" class="quick-btn">
                                <i class="fa fa-cubes fa fa-2x"></i>
                                <span>工匠活動</span>
                                <span class="label label-success">456</span>
                            </a>
                            <a href="#" class="quick-btn">
                                <i class="fa fa-signal fa fa-2x"></i>
                                <span>iWorld</span>
                                <span class="label label-warning">25</span>
                            </a>
                        
                          
                            <a href="#" class="quick-btn">
                                <i class="fa fa-question-circle fa fa-2x"></i>
                                <span>家刊問題</span>
                                <span class="label label-default">20</span>
                            </a>

                            
                            
                        </div>

                    </div>

                </div>
                  <!--END BLOCK SECTION -->
                <hr>
                   <!-- CHART & CHAT  SECTION -->
                 
                 <!--END CHAT & CHAT SECTION -->
                 <!-- COMMENT AND NOTIFICATION  SECTION -->
                
                <!-- END COMMENT AND NOTIFICATION  SECTION -->
                

                

                 <!--  STACKING CHART  SECTION   -->
              
                 <!--END STACKING CHART SCETION  -->

                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->
                          <div class="row">
                    <div class="col-lg-6">
                        <div class="box">
                           
                            <div class="body collapse in" id="sortableTable">
                                <table class="table table-bordered sortableTable responsive-table"  >
                                    <thead>
                                        <tr>
                                            <th>#/排名</th>
                                            <th>姓名</th>
                                            <th>分數</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                         
                    <?php
                    $i=1;
                     foreach ($users_score as $key => $value) { ?>
                    <tr>
                    <td><?php  echo $i; ?></td>
                    <td><?php  echo $value['user']['name']; ?></td>
                    <td><?php  echo $value['score']; ?></td>
                    </tr>
                    <?php $i++; } ?>
                                   

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-heading ">
                                Collapsible Accordion Panel Group
                            </div>
                            <div class="panel-body">
                                <div id="accordion" class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a href="#collapseOne" data-parent="#accordion" data-toggle="collapse">Collapsible Group Item #1</a>
                                            </h4>
                                        </div>
                                        <div class="panel-collapse collapse in" id="collapseOne">
                                            <div class="panel-body">
                                                Lorem ipsum dolor sit amet, luaute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a href="#collapseTwo" data-parent="#accordion" data-toggle="collapse">Collapsible Group Item #2</a>
                                            </h4>
                                        </div>
                                        <div class="panel-collapse collapse" id="collapseTwo">
                                            <div class="panel-body">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a href="#collapseThree" data-parent="#accordion" data-toggle="collapse">Collapsible Group Item #3</a>
                                            </h4>
                                        </div>
                                        <div class="panel-collapse collapse" id="collapseThree">
                                            <div class="panel-body">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                              主面板
                            </div>
                            <div class="panel-body">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum tincidunt est vitae ultrices accumsan. Aliquam ornare lacus adipiscing, posuere lectus et, fringilla augue.</p>
                            </div>
                            <div class="panel-footer">
                                Panel Footer
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Gifts
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="views-table cols-5 table table-hover table-striped table table-stripped table-bordered table-hover">
         <thead>
      <tr>
                  <th class="views-field views-field-id">
            Id          </th>
                  <th class="views-field views-field-title">
            Title          </th>
                  <th class="views-field views-field-field-image">
            Image          </th>
                  <th class="views-field views-field-edit-link">
            Edit          </th>
                  
              </tr>
    </thead>
    <tbody>
        <?php  foreach ($new_items as $key => $value) {?>
          
          <tr class="odd views-row-first">
            <td class="views-field views-field-id"><?= $value['id'] ?></td>
            <td class="views-field views-field-title"><?= $value['item_title'] ?></td>
            <td class="views-field views-field-field-image">
            <?php if(!empty($value['image'])) {?>
            <img width="50px;" src=<?php echo HTTP_ROOT.'img/uploads/'.$value['image']; ?> >
                                    <?php } ?>      </td>
                  <td class="views-field views-field-edit-link">
            <a href=<?php echo HTTP_ROOT.'items/edit/'.$value['id'] ?> >edit</a>          </td>
                 
              </tr>
             
        <?php }?>
         
      </tbody>
</table>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              Support
                            </div>
                            <div class="panel-body">
                                <button data-target="#myModal" data-toggle="modal" class="btn btn-primary btn-lg">
                                    Help
                                </button>
                                <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">�</button>
                                                <h4 id="myModalLabel" class="modal-title">Help Section</h4>
                                            </div>
                                            <div class="modal-body">
                                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                 <!--TABLE, PANEL, ACCORDION AND MODAL  -->

                
            </div>

        </div>    </section>

          <aside role="complementary" class="col-sm-3">
          <div class="region region-sidebar-second">
    <section class="block block-user clearfix" id="block-user-new">

        <h2 class="block-title">新會員</h2>
    <ul>
<?php foreach ($new_users as $key => $value) { ?>
<li><a class="username" title="View user profile." href="<?php echo HTTP_ROOT ?>users/view/<?php echo $value['id']?>"><?php echo ucfirst($value['name']); ?></a></li>
<?php } ?>
</ul>
</section>
<section class="block block-user clearfix" id="block-user-online">

        <h2 class="block-title">在線會員</h2>
    
  <p>There is currently 1 user online.</p><ul><li><a class="username" title="View user profile." href="/newworld_old/user/1">admin</a></li>
</ul>
</section>
  </div>
      </aside>  <!-- /#sidebar-second -->
    
  </div>
</div>
</div>
