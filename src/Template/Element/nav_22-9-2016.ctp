 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
               <a href="<?= HTTP_ROOT ?>/users" class="nav_lgo">New World <span class="semi-bold">App</span></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                
               
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?= !empty($user_name)?$user_name:'Admin' ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
			 <li>
                            <?=$this->Html->link(
                                '<i class="fa fa-pencil-square-o"></i> Edit Profile',
                                    [
                                        'controller'=>'users',
                                        'action'=>'editAdmin'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                        </li>
                       
                        <li>
							<?=$this->Html->link(
								'<i class="fa fa-fw fa-power-off"></i> Log Out',
									[
										'controller'=>'users',
										'action'=>'logout'
										
									],
									[
										'escape'=>false  
									]
							);?>
                        </li>

                       
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
               
		<div class="side-nav">
		 <div class="logo_bx">
		    <!-- <a class="navbar-brand" href="/trafficApp/admin/users"><img src="http://mastersoftwaretechnologies.com/trafficApp/img/download.png"/></a> -->
            <a title="Home" href="<?= HTTP_ROOT?>dashboard" class="logo navbar-btn pull-left">
          <img  width="100px" height="100px" alt="Home" src="<?= HTTP_ROOT ?>img/newworldlogo.png">
        </a>
		</div>
		<ul class="nav navbar-nav side-nav">
                    <!-- li <?php if($this->request->params['controller']=="Category" ){?>class="active" <?php }?>>
                        <?=$this->Html->link(
                            '<i class="fa fa-dot-circle-o"></i>
                            Manage Category',
                                [
                                    'controller'=>'category','action'=>'index'
                                ],
                                [
                                    'escape'=>false
                                ]
                        );?>
                    </li>
                    <li <?php if($this->request->params['controller']=="AllGames" ){?>class="active" <?php }?>>
                        <?=$this->Html->link(
                            '<i class="fa fa-dot-circle-o"></i>
                            All Games',
                                [
                                    'controller'=>'AllGames',
                                    'action'=>'index'
                                ],
                                [
                                    'escape'=>false
                                ]
                        );?>
                    </li -->
                    <li <?php if($this->request->params['controller']=="Dashboard" ){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(

                                '<i class="fa fa-tachometer"></i>
                                Dashboard',
                                    [
                                        'controller'=>'Dashboard',
                                        'action'=>'index'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li>
                   <li <?php if($this->request->params['controller']=="Chessman" ){?>class="active" <?php }?>>
                       
                         <?=$this->Html->link(
                                '<i class="fa fa-dot-circle-o"></i>
                                Craftsman Chess',
                                    [
                                        'controller'=>'chessman',
                                        'action'=>'index'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>

                    </li>
                   
                    <li <?php if($this->request->params['controller']=="Onsite" ){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(
                                '<i class="fa fa-cubes"></i>
                                On-site Games',
                                    [
                                        'controller'=>'Onsite',
                                        'action'=>'index'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li>
                  
                   <li <?php if($this->request->params['controller']=="Tabloid" ){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(
                                '<i class="fa fa-question-circle"></i>
                                Tabloid Quiz',
                                    [
                                        'controller'=>'Tabloid',
                                        'action'=>'index'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li>
                     <li <?php if($this->request->params['controller']=="Article" ){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(
                                '<i class="fa fa-question-circle"></i>
                                Article  ',
                                    [
                                        'controller'=>'Article',
                                        'action'=>'index'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li>
                     <li <?php if($this->request->params['controller']=="Iworld" ){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(
                                '<i class="fa fa-search-plus"></i>
                                i- world Games',
                                    [
                                        'controller'=>'Iworld',
                                        'action'=>'index'                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li>
                                      
                   <li <?php if($this->request->params['controller']=="Rank" ){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(
                                '<i class="fa fa-line-chart"></i>
                                Rank',
                                    [
                                        'controller'=>'Rank',
                                        'action'=>'index'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li>
                     <li <?php if($this->request->params['controller']=="Items" ){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(
                                '<i class="fa fa-gift"></i>
                                Gifts',
                                    [
                                        'controller'=>'Items',
                                        'action'=>'index'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li>
 <li <?php if($this->request->params['controller']=="Departments" ){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(
                                '<i class="fa fa-users"></i>
                                Departments',
                                    [
                                        'controller'=>'Departments',
                                        'action'=>'index'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li>
                     <li <?php if($this->request->params['controller']=="Users" ){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(
                                '<i class="fa fa-users"></i>
                                Members',
                                    [
                                        'controller'=>'Users',
                                        'action'=>'index'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li>
 <li <?php if($this->request->params['controller']=="Score" ){?>class="active" <?php }?>>
                       
                         <?=$this->Html->link(
                                '<i class="fa fa-dot-circle-o"></i>
                                Score Range',
                                    [
                                        'controller'=>'score',
                                        'action'=>'index'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>

                    </li>
<!--
  <li <?php if($this->request->params['controller']=="GameRules" && $this->request->params['action']=="index"){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(
                                '<i class="fa fa-users"></i>
                                Game Rule',
                                    [
                                        'controller'=>'GameRules',
                                        'action'=>'index'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li>
	 <li <?php if($this->request->params['controller']=="users" ){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(
                                '<i class="fa fa-user-secret" aria-hidden="true"></i>
                                User account',
                                    [
                                        'controller'=>'users',
                                        'action'=>'userAccount'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li> -->

                     <li <?php if($this->request->params['controller']=="Users" && $this->request->params['action']=="logout"){?>class="active" <?php }?>>
                       
                        <?=$this->Html->link(
                                '<i class="fa fa-sign-out"></i>
                                Logout',
                                    [
                                        'controller'=>'Users',
                                        'action'=>'logout'
                                        
                                    ],
                                    [
                                        'escape'=>false  
                                    ]
                            );?>
                    </li>
                    
                   
                </ul>
		</div>
            </div>
            <!-- /.navbar-collapse -->
        </nav>
<style>
.navbar-brand > img {
  display: block;
  width: 28px;
}
.logo.navbar-btn.pull-left {
    margin-left: 57px;
}
</style>
