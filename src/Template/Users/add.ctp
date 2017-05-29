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
                    <div class="panel panel-default">
                        <div class="panel-heading heading_label">
                        <?php if(!empty($_GET['role']) && $_GET['role'] == 'user'){ ?>
                            <span class="semi-bold"> Add User </span>
                        <?php }?>
                            <a href="javascript:history.back()"><button class="btn btn-default" style="float:right">返回</button></a>
                        </div>
                        <div class="panel-body spacing">
                            <div class="row spacing">
                                <div class="col-lg-12 spacing">
                                    <form id="addForm" role="form" action="<?=HTTP_ROOT?>users/add" enctype='multipart/form-data' method="post">
   <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">員工編號</label>
                                            <input type="text" id="staffid" placeholder="Enter staff id" onfocusout="myFunction();" class="form-control col-lg-10" name="staffid" required>
                                        </div>
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">姓名</label>
                                            <input type="text"  placeholder="Enter Name" id="name" class="form-control col-lg-10" name="name">
                                        </div>
                                        
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">電郵</label>
                                             <input type="email" pattern="[a-z0-9._]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Enter Email" class="form-control col-lg-10" name="email" required>
                                         
                                        </div>
                                      
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">密碼</label>
                                             <input type="password" placeholder="Enter Password" id="pwd" class="form-control col-lg-10" name="password" required>
                                        </div>
                                        
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">確認密碼</label>
                                             <input type="password" placeholder="Enter Confirm Password" class="form-control col-lg-10" name="confpass" required>
                                        </div>
  <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">聯絡電話</label>
                                             <input type="text" placeholder="Enter Phone number" class="form-control col-lg-10" name="contact_no" required>
                                        </div>
                                        
                                        <div class="form-group form_row">
                                        <label class="col-lg-2 form_lable">部門</label>                            
                                        <select id="department" name="department">
                                                <?php  foreach ($new_items as $key => $value) {
                                                echo"<pre>"; print_r($value['id']);
                                                $id= $value['id'];
                                                $dept_name= $value['dept_name'];
                                                ?>
                                                <option  value="<?php echo  $id ; ?>"><?php echo $dept_name  ?></option>
                                                <?php
                                                # code...
                                                }
                                                ?>
                                        </select>
                                        </div>
<div class="form-group form_row">
                                        <label class="col-lg-2 form_lable">身份</label>                            
                                        <select id="role_id" name="role_id">

                                        
                                                <?php  foreach ($Role as $key => $value) {
                                                echo"<pre>"; print_r($value['id']);
                                               // $id= $value['id'];
                                                $id= $value['id'];
                                                $dept_name= $value['name'];
                                                ?>
                                                <option  value="<?php echo  $id ; ?>"><?php echo $dept_name  ?></option>
                                                <?php
                                                # code...
                                                }
                                                ?>
                                        </select>
                                        </div>

                                        <!-- <input type="hidden" name="role" value="user">
                                        
                                        <input type="hidden" name="role" value="user"> -->
                                       <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">狀態</label>
                                            <input type="checkbox" name="status" value="1" checked>
                                        </div>

                                        <div class="form-group form_row">
                                        <?php echo $this->Form->input('profile_pic', ['label'=>['class'=>'col-lg-2 form_lable','text' => '個人頭像'],'type'=>'file','class'=>'form-control col-lg-10']); ?>
                                        <p> accept Format: gif| png| jpg |jpeg |JPG </p>
                                        </div> 
                                       
                                       <div class="form-group form_row"> <button class="btn btn-default submit" type="submit">提交</button></div>
                                       
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
                    "name":
                    {
                        required:true,
                        accept:"[A-Za-z]",
                        maxlength: 50
                    },

                     "department":
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
                    "contact_no":
                    {
                        required:true,
                        number:true,
                        minlength:8,
                        maxlength:8
                    },
                    "profile_pic":
                    {
                        accept:'jpeg,jpg,png,gif'
                    }

                },   
                messages:
                {
                  
                    "email":
                    {
                        required:'Please Enter Email.',
                        required:'Please enter a valid email.',
                        remote:"Email already exists."
                    },
                    "department":
                    {
                       required:"Please Select  Department.",
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
                    "contact_no":
                    {
                        required:'Contact number is required.',
                        number:"Please enter a valid contact number",
                        minlength:"Please enter a valid contact number",
                        maxlength:"Please enter a valid contact number"
                    },
                    "profile_pic":
                    {
                        accept:"圖片格式錯誤"
                    }
                  
                }
            });
        });

  </script>   
<script>
function myFunction() {
   var x = $("#staffid").val();

var count=x.length;

if(count==7)
{
var charac=0;
var numb=0;
for(var i=0;i<count;i++)
{

if(x[i].match(/[a-z]/i) && i<2)
{

charac=charac+1;
}

if(!isNaN(x[i]) && i>=2)
{

numb=numb+1;
}
/*if(x[i].match(/[a-z]/i)){
charac=charac+1;
}*/

}


if(charac==2 && numb==5)
{
  document.getElementById("name").focus();
}else{

 document.getElementById("staffid").value ="";
  document.getElementById("staffid").focus();
}
}
}
</script>

