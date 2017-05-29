<?php 



//echo"<pre>";print_r($Onsitegame);die;
?>

<div id="wrapper">
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                     <?= $this->Flash->render();?>
                </div>
            </div> 
            <!-- <button class="btn btn-default" onclick="goBack()">返回</button> -->
            <div class="row spacing">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading heading_label">
                        
                            <span class="semi-bold"> 編輯部門詳情</span>
                        
                              <a href="javascript:history.back()"><button class="btn btn-default" style="float:right">返回</button></a>
                        </div>
                        <div class="panel-body spacing">
                            <div class="row spacing">
                                <div class="col-lg-12 spacing">



                              <?=  $this->Form->create($Departments, array('id'=>'editForm','enctype'=>'multipart/form-data')) ?>
                                        
                                           
                                           
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">部門名稱</label>
                                            <input type="text" value="<?= $Departments->dept_name; ?>" class="form-control col-lg-10" name="dept_name">
                                        </div>
                                                                                  

                                       <div class="form-group form_row">
                                    <?php echo $this->Form->input('image', ['label'=>['class'=>'col-lg-2 form_lable','text' => '圖像'],'type'=>'file','class'=>'form-control col-lg-10']); ?>
                                    <?php if(!empty($Departments->image)) {?>
                                    <img width="50px;" src=<?php echo HTTP_ROOT.'img/uploads/'.$Departments->image; ?> >
                                    <?php } ?>
                                    </div>     
                                    <input type="hidden" name="image1" value="<?php echo $Departments->image; ?>">

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

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
<script>
  $(function() {
var dateToday = new Date();
    $( "#datepicker" ).datepicker({


changeMonth: true,
    numberOfMonths: 1,
    maxDate: dateToday,
    onSelect: function(selectedDate) {
        var option = this.id == "from" ? "minDate" : "maxDate",
            instance = $(this).data("datepicker"),
            date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
$(this).datepicker('hide');
        dates.not(this).datepicker("option", option, date);

    }


    });


  });
  </script>
<script type="text/javascript">
        $(document).ready(function() {
            $('#editForm').validate({
              onfocusout: function (element) {
                 $(element).valid();
                },
                rules:
                {
                    "dept_name":
                    {
                        required:true,
                        maxlength: 100
                    },
                 
                                       
                    
                    "image":
                    {
                        accept:'jpeg,jpg,png,gif'
                    },
      "date":
                    {
                         required:true
                    }

                },   
                messages:
                {
                    "dept_name":
                    {
                       required:"Please Enter Dept name" ,
                    }
                   
                  ,
                    "image":
                    {
                        accept:"Image not supported, please try with other one."
                    }
      
                  
                }
            });
        });
  </script>   
