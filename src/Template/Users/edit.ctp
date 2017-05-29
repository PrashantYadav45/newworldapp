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
                       
                            <span class="semi-bold"> 編輯成員詳情</span>
                        
                              <a href="javascript:history.back()"><button class="btn btn-default" style="float:right">返回</button></a>
                        </div>
                        <div class="panel-body spacing">
                            <div class="row spacing">
                                <div class="col-lg-12 spacing">
                                <?= $this->Form->create($user, array('id'=>'editForm','enctype'=>'multipart/form-data')) ?>
                                <div class="form-group form_row">
                                                <label class="col-lg-2 form_lable">員工編號</label>
                                                 <input type="text" placeholder="Enter Staff id" id="staffid" onfocusout="myFunction();" value="<?= $user->staffid; ?>" class="form-control col-lg-10" name="staffid" required>
                                            </div>         
                                            <?php

                                            $role=array('user'=>'user');

                                             echo $this->Form->input('姓名',['templates' => [
                                                 'inputContainer' => '<div class="form-group form_row">{{content}}</div>'
                                            ],'class'=>'form-control col-lg-10','id'=>'name','value'=>$user->name,'readonly'=>true,'label' => ['class' => 'col-lg-2 form_lable']]);
                                                echo $this->Form->input('電郵',['templates' => [
                                                 'inputContainer' => '<div class="form-group form_row">{{content}}</div>'
                                            ],'class'=>'form-control col-lg-10','pattern'=>'[a-z0-9._]+@[a-z0-9.-]+\.[a-z]{2,4}$','label' => ['class' => 'col-lg-2 form_lable'],'value'=> $user->email,'readonly'=>true]); ?>

                                            <div class="form-group form_row">
                                                <label class="col-lg-2 form_lable">聯絡電話</label>
                                                 <input type="text" placeholder="Enter Contact Number" value="<?= $user->contact_no; ?>" class="form-control col-lg-10" name="contact_no" required>
                                            </div> 
                                       
                                        
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">確認密碼</label>
                                             <input type="password" placeholder="Enter Confirm Password" class="form-control col-lg-10" name="confpass" >
                                        </div>
                                 
  <div class="form-group form_row">
       <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">密碼</label>
                                             <input type="password" placeholder="Enter Password" id="pwd" class="form-control col-lg-10" name="password" >
                                        </div>
                                        <label class="col-lg-2 form_lable">部門</label>                            
                                        <select id="department" name="department">
                                                <?php  foreach ($new_items as $key => $value) {
                                                $id= $value['id'];
                                                $dept_name= $value['dept_name'];
                                                ?>
                                                <option <?php   if ($id==$user->department_id) {  ?> selected="selected" <?php }?> value="<?php echo  $id ; ?>"><?php echo $dept_name  ?></option> 
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


                                                  //echo"<pre>";print_r($value);
                                                $id= $value['id'];
                                                $dept_name= $value['name'];
                                                ?>
                                                <option <?php if ($id==$user->role_id) {  ?> selected="selected" <?php }?> value="<?php echo  $id ; ?>"><?php echo $dept_name  ?></option>
                                                <?php
                                                # code...
                                                }
                                                ?>
                                        </select>
                                        </div>


                                       
                                              
                                    
                                        <?php if(!empty($_GET['role']) && $_GET['role'] == 'user'){ ?>
                                            <input type="hidden" name="role" value="user">
                                        <?php } ?>
                                         <!-- <input type="hidden" name="role" value="user"> -->
                                       <div class="form-group form_row">
                                         <label class="col-lg-2 form_lable">狀態</label>
                                        <input type="checkbox"
                                          <?php if($user->status=='1') { echo 'checked'; }?> value="1"
                                            name="status"> 
                                       </div>

                                       <div class="form-group form_row">
                                    <?php echo $this->Form->input('profile_pic', ['label'=>['class'=>'col-lg-2 form_lable','text' => '個人頭像'],'type'=>'file','class'=>'form-control col-lg-10']); ?>
                                    <?php if(!empty($user->profile_pic)) {?>
                                    <img width="50px;" src=<?php echo HTTP_ROOT.'img/uploads/'.$user->profile_pic; ?> >
                                    <?php } ?>
                                    </div>     
                                    <input type="hidden" name="image1" value="<?php echo $user->profile_pic; ?>">

                                         <div class="form-group form_row"> <button class="btn btn-default submit" type="submit">提交</button></div>
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
            $('#editForm').validate({
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
                        email:true
                        //remote:'<?php echo HTTP_ROOT ?>users/checkEmail_exist'
                    },
                    "name":
                    {
                        required:true,
                        accept:"[a-zA-Z]",
                        maxlength: 50
                    },
                    "password":
                    {
                       required:false,
                       minlength: 6,
                       maxlength: 18
                    },
                    "confpass":
                    {
                        required:false,
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
                        required:'Please enter a email.',
                        required:'Please enter a valid email.',
                        //remote:"Email doesn't exists."
                    },
                    "password":
                    {
                       required:"This field is required.",
                       minlength: 'Password should be atleast 6 characters long.'
                    }
                    ,
                    "confpass":
                    {
                       equalTo: "Password and Confirm Password doesn't match."
                    }
                     ,
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
                    "image":
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
