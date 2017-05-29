<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 box-col">
       
                <div class="login-panel panel panel-default">
                    <div class="panel-heading heading_title">
                        <h3 class="panel-title"><b>Forgot Password</b></h3>
                    </div>
                    <div class="panel-body">
                    <?= $this->Flash->render();?>
                        <?= $this->Form->create(null,['id'=>'logInForm']) ?>
                            <fieldset>
                                <?=
                                    $this->Form->input('email', ['type' => 'email','autofocus','placeholder'=>"E-mail",'required'=>'required','label'=>false,'class'=>'form-control','templates' => ['inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>' ],
                                    ]);
                                ?>
                               
                                <?=
                                   $this->Form->button('submit', ['type' => 'submit','class'=>'btn btn-lg btn-success btn-block login']);
                                ?>
                                <a href="<?= HTTP_ROOT ?>" class="btn btn-lg btn-success btn-block login">Back To Login</a>
                            </fieldset>
                        <?php   echo $this->Form->end(); ?>
                          
                    </div>
                           
                         
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
	    $(document).ready(function() {
	    	$('#logInForm').validate({
	          onfocusout: function (element) {
	             $(element).valid();
	            },
	            rules:
	            {
	                "email":
	                {
	                    required:true,
	                    email:true,
	                    //remote:'<?php echo HTTP_ROOT ?>users/checkEmail_exist'
	                }
	            },   
	            messages:
	            {
	                "email":
	                {
	                    required:'Please enter a email.',
	                    required:'Please enter a valid email.',
	                    //remote:"Email doesn't exists."
	                },
	               
	            }
	        });
	    });
  </script>