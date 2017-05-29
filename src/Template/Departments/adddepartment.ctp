 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>



       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
 <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i> 添加新部門名稱</h1>
                </div>

            </div>
            <div class="row spacing">
                 <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading heading_label">
                                <!--<span class="semi-bold">User Listing</span> -->
                            </div>
                            <div class="row spacing">
                                     
                                <div class="col-md-7 right">
                                    
                              
                            
                            <div class="panel-body">

                   <form id="addForm" action="<?php echo HTTP_ROOT ?>departments/adddepartment" method="post"  enctype="multipart/form-data"  role="form">


                    <div class="form-group">
                        <label for="title">部門名稱*</label>
                        <input name="dept_name" type="title" class="form-control"  id="title">
                      </div>
               
                     <div class="form-group form_row">
                                      <?php echo $this->Form->input('image', ['label'=>['class'=>'col-lg-2 form_lable','text' => '圖像'],'type'=>'file',  'class'=>'form-control col-lg-10']); ?>
                                     
                                      </div> 

   <div class="form-group form_row"> <button class="btn btn-default submit" type="submit">提交</button></div>



</form>



                                
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /.row -->


        </div>
</div>







<script type="text/javascript">
        $(document).ready(function() {
          jQuery.validator.addMethod("checkDates", function(value, element) { 
            return  compareDates() ;
          }, "End date/time must be after start");

          function compareDates() {
              var startDate = $("#from").datepicker('getDate');
              var endDate = $("#to").datepicker('getDate');
              
              if( !startDate || !endDate){
                return false;
              }

              if(endDate > startDate) {
                  return true;
              } else {
                var endTime = endDate.getTime() + $('#to_time').parseValToNumber();
                console.log("endTime",endTime);
                var startTime = startDate.getTime() + $('#from_time').parseValToNumber();
                console.log("startTime",startTime);
                return endTime > startTime;
              }
          }
          $('select').change(function(){
            $('#start_date, #end_date').keyup()
          });
           $('#addForm').validate({

              onfocusout: function (element) {
                 $(element).valid();
                },
                rules:
                {
                    "dept_name":
                    {
                        required:true,
                        maxlength: 100
                    }
                  
                                     
                   
                    ,
                    "image":
                    {
 			                required:true,
                        accept:'jpeg,jpg,png,gif'
                    }

                },   
                messages:
                {
                    "dept_name":
                    {
                       required:"Please Enter deptarment name" ,
                    },
                  
                    "image":
                    {
			             required:"Please select image" ,
                        accept:"Image not supported, please try with other one."
                    }
                  
                }
            });
        });
  </script>   


    
