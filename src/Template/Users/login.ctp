<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 box-col">
       
                <div class="login-panel panel panel-default">
                    <div class="panel-heading heading_title">
                        <h3 class="panel-title"><b>登入</b></h3>
                    </div>
                    <div class="panel-body">
                    <?= $this->Flash->render();?>
                        <?= $this->Form->create(null,['id'=>'logInForm']) ?>
                            <fieldset>
                                <?=
                                    $this->Form->input('email', ['type' => 'email','autofocus','placeholder'=>"電郵地址",'required'=>'required','label'=>false,'class'=>'form-control','templates' => ['inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>' ],
                                    ]);
                                ?>
                                <?=
                                    $this->Form->input('password', ['type' => 'password','placeholder'=>"密碼",'required'=>'required','label'=>false,'autocomplete'=>"off",'class'=>'form-control','templates' => ['inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>' ],
                                    ]);
                                ?>
                                <?=
                                    $this->Form->input('remember', ['type' => 'hidden','label'=>'Remember Me','value'=>'Remember Me','templates' => ['inputContainer' => '<div class="checkbox {{type}}{{required}}">{{content}}</div>' ],
                                    ]);
                                ?>
                                <?=
                                   $this->Form->button('登入', ['type' => 'submit','class'=>'btn btn-lg btn-success btn-block login']);
                                ?>

                            </fieldset>
                        <?php   echo $this->Form->end(); ?>
                           <br>
                           <div align="center">
                                <?php   
                                   echo $this->Html->link('忘記密碼?',['controller'=>'Users', 'action'=>'forgotPass']);
                                ?>
                            </div>
                    </div>
                           
                         
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
	    $(document).ready(function() {
            $('#password').val("");
	    	$('#logInForm').validate({
	          onfocusout: function (element) {
	             $(element).valid();
	            },
	            rules:
	            {
	                "email":
	                {
	                    required:true,
	                    email:true
	                    //remote:'<?php echo HTTP_ROOT ?>users/checkEmail_exist'
	                },
	                "password":
		            {
		               required:true,
		               minlength: 6
		            }
	            },   
	            messages:
	            {
	                "email":
	                {
	                    required:'請輸入電郵地址.',
	                    email:'請輸入正確 的電郵地址'
	                    //remote:"Email doesn't exists."
	                },
	                "password":
		            {
		               required:"請輸入密碼.",
		               minlength: '密碼長度至 少為 6 個字元'
		            }
	            }
	        });
	    });
  </script>
