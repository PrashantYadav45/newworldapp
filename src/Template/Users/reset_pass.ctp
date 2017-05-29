<div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4 box-col">
       
                <div class="login-panel panel panel-default">
                    <div class="panel-heading heading_title">
                        <h3 class="panel-title"><b>Reset Password</b></h3>
                    </div>
                    <div class="panel-body">
                        <?= $this->Flash->render();?>
                    <form id="forgotForm" role="form" action="<?=HTTP_ROOT?>users/resetPass/?code=<?php echo $_GET['code'] ?>" method="post">
                                        
                                         <div class="form-group form_row">
                                           <input type="password" placeholder="Enter Password" id="pwd" class="form-control" name="password" required>
                                        </div>
                                        
                                        <div class="form-group form_row">
                                           <input type="password" placeholder="Enter Confirm Password" class="form-control" name="confpass" required>
                                        </div>
                                        
                                       
                                       <div class="form-group form_row"> <button class="btn btn-lg btn-success btn-block login" type="submit">Submit</button></div>
                                       
                                    </form>
                          
                    </div>
                           
                         
                </div>
            </div>
        </div>
    </div>

    
 
<script type="text/javascript">
        $(document).ready(function() {
            $('#forgotForm').validate({
              onfocusout: function (element) {
                 $(element).valid();
                },
                rules:
                {
                    "password":
                    {
                       required:true,
                       minlength: 6
                    },
                    "confpass":
                    {
                        required:true,
                        equalTo:'#pwd'
                    }
                    

                },   
                messages:
                {
                    "password":
                    {
                       required:"This field is required.",
                       minlength: 'Password should be atleast 6 characters long.'
                    }
                }
            });
        });
  </script>   




