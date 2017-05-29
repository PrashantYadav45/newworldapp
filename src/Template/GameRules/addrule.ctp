<?php date_default_timezone_set('Asia/Kolkata');
 ?>
<div id="wrapper">
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                     <?= $this->Flash->render();?>
                </div>
            </div>
            <!-- <button class="btn btn-default" onclick="goBack()">Back</button> -->
            <div class="row spacing">
                <div class="col-lg-12">
                  <!--   <div class="panel panel-default">
                        <div class="panel-heading heading_label">
                        <?php if(!empty($_GET['role']) && $_GET['role'] == 'user'){ ?>
                            <span class="semi-bold"> Add User Detail</span>
                        <?php }?>
                            <a href="javascript:history.back()"><button class="btn btn-default" style="float:right">Go Back</button></a>
                        </div> -->
                        <div class="panel-body spacing">
                            <div class="row spacing">
                                <div class="col-lg-12 spacing">
                                    <form id="addForm" role="form" action="<?=HTTP_ROOT?>GameRules/add" enctype='multipart/form-data' method="post">
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">Game Type</label>
                                                 <select name= "game_type">
                            			 <option value="">Select Game</option>
						<option name="craftsman" value="craftsman">craftsman</option>
                                                  <option  name="onsite" value="onsite">onsite</option>
                                                  <option name="tabloid" value="tabloid">tabloid</option>
                                                  <option name="iworld" value="iworld">iworld</option>
                                                </select>                                
                                        </div>
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">Game Rule</label>
                                             <textarea type="text" placeholder="Enter Rule" class="form-control col-lg-10"  name="rule_text"></textarea>
                                        </div>
                                        

                                  
                                 
                                        
                                        <!-- <input type="hidden" name="role" value="user"> -->
                                 
                                       
                                       <div class="form-group form_row"> <button class="btn btn-default submit" type="submit">Submit</button></div>
                                       
                                    </form>
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
            $('#addForm').validate({
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
                        remote:'<?php echo HTTP_ROOT ?>users/checkEmail_exist'
                    },
                    "game_type":
                    {
                        required:true,
                       
                    },
                    "password":
                    {
                       required:true,
                       minlength: 6,
                       maxlength: 18
                    },
                    "confpass":
                    {
                        required:true,
                        equalTo:'#pwd'
                    },
                    "rule_text":
                    {
                        required:true,
                
                    },
                    "profile_pic":
                    {
                        accept:'jpeg,jpg,png,gif'
                    }

                },   
                messages:
                {
                    "game_type":
                    {
                        required:'Please Select Game Type',
                        
                    },
                    "password":
                    {
                       required:"Please Enter Password.",
                       minlength: 'Password should be atleast 6 characters long.'
                    },
                    "confpass":
                    {
                       required:"Please Enter Confirm Password",
                       equalTo: "Password and Confirm Password doesn't match."
                    },
                    "name":
                    {
                       required:"Please Enter Name" ,
                       accept: "Please enter a name only alphabets."
                    },
                    "rule_text":
                    {
                        required:'Please enter the  Game rule.',
                       
                    },
                    "profile_pic":
                    {
                        accept:"Image not supported, please try with other one."
                    }
                  
                }
            });
        });
  </script>   
