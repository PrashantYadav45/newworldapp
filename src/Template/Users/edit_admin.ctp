<div id="wrapper">
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                     <?= $this->Flash->render();?>
                </div>
            </div> 
            <button class="btn btn-default" onclick="goBack()">Back</button>
            <div class="row spacing">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading heading_label">
                   
                        </div>
                        <div class="panel-body spacing">
                            <div class="row spacing">
                                <div class="col-lg-12 spacing">
                       
                                        <?= $this->Form->create($user,array('id' => 'editAdmin')) ?>
                                        
                                            <?php

                                             echo $this->Form->input('name',['templates' => [
                                                 'inputContainer' => '<div class="form-group form_row">{{content}}</div>'
                                            ],'class'=>'form-control col-lg-10','label' => ['class' => 'col-lg-2 form_lable']]);
                                                echo $this->Form->input('email',['templates' => [
                                                 'inputContainer' => '<div class="form-group form_row">{{content}}</div>'
                                            ],'class'=>'form-control col-lg-10','label' => ['class' => 'col-lg-2 form_lable']]);
                                               
                                             echo $this->Form->input('password',['templates' => [
                                                 'inputContainer' => '<div class="form-group form_row">{{content}}</div>'
                                            ],'class'=>'form-control col-lg-10','required'=>'false','value'=>"",'label' => ['class' => 'col-lg-2 form_lable'],'placeholder'=>"Enter Password"]);
                                                                                                                                
                                            ?>
                                            <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">Confirm Password</label>
                                             <input type="password" placeholder="Enter Confirm Password" class="form-control col-lg-10" name="confpass" required>
                                        </div>
                                      
                                       <div class="form-group form_row"> <button class="btn btn-default submit" type="submit">Submit</button></div>
                                        <?= $this->Form->end() ?>



                                   </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>


<script type="text/javascript">
        $(document).ready(function() {
            $('#editAdmin').validate({
              onfocusout: function (element) {
                 $(element).valid();
                },
                rules:
                {
                    "email":
                    {
                        required: {
                            depends:function(){
                                $(this).val($.trim($(this).val()));
                                return true;
                            }
                        },
                        email:true,
                        //remote:'<?php echo HTTP_ROOT ?>users/checkEmail_exist'
                    },
                    "name":
                    {
                        required:true,
                        accept:"[a-zA-Z0-9]",
                        maxlength: 20
                    },
                    "password":
                    {
				       required:true,
                       minlength: 6
                    },
                    "confpass":
                    {
                        required:true,
                        equalTo:'#password'
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
                    "password":
                    {
                       required:"Please Enter Password",
                       minlength: 'Password should be atleast 6 characters long.'
                    },
                    "confpass":
                    {
                       required:"Please Enter Confirm Password",
                       equalTo: "Password and Confirm Password doesn't match."
                    }
                }
            });
        });
  </script>   

