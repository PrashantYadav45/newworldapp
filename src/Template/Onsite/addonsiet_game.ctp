<?php echo $this->Html->script('ckeditor.js');?>

 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>



       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
 <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i> 加入现场游戏</h1>
                       <a href="javascript:history.back()"><button class="btn btn-default" style="float:right">返回</button></a>
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

                   <form id="addForm" action="<?php echo HTTP_ROOT ?>Onsite/addonsietGame" method="post"  enctype="multipart/form-data"  role="form">


                    <div class="form-group">
                        <label for="title">活動名稱</label>
                        <input name="title" type="title" class="form-control"  id="title">
                      </div>
               
                   <div class="form-group"  style="display:none">
                      <label for="game_type">游戏类型</label>
                      <input type="text" readonly="true" value="onsite" class="form-control"  name="game_type" id="game_type">
                    </div>
<div class="form-group">
                      <label for="from">開始日期:</label>
                      <input type="text" class="form-control" name="start_date" id="from"  placeholder="Enter Start Date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">開始時間:</label>
                          <input type='text' class="form-control" id='from_time' name="start_time" placeholder="Enter Start Time" required>
                    </div>
                    
                    <div class="form-group">
                      <label for="to">結束日期:</label>
                      <input type="text" class="form-control" name="end_date" id="to"  placeholder="Enter End Date" placeholder="Enter end date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">結束時間:</label>
                          <input type='text' class="form-control" id='to_time' name="end_time" placeholder="Enter End Time" required>
                    </div>
        <div class="form-group" id="descEditor">
                      <label for="from">描述</label>
                      <textarea name="editor1"></textarea>
                    </div>

                <!-- On site game div-->    
                <div id="game_on_site" >

                    <div class="form-group">
                      <label for="pwd">密碼:</label>
                      <input name="password" type="password" class="form-control" id="pwd">
                    </div>
 
                      
                      <div class="form-group col-md-8">
                        <label>用戶</label>
                      </div>
                      <div class="form-group col-md-2">
                        <label>分數</label>
                      </div>
                      
                      <div id="onsiteCloneId1" class="onsiteCloneClass">
                        <div class="form-group col-md-8 col-xs-12">
                          <input type="text" class="form-control" name="identity[]" value="">
                        </div>

                        <div class="col-md-2 col-xs-12">
                          <input type="text" class="form-control" name="onsite_score[]" value="">
                        </div>
                      </div>

                    <div id="appendOnSiteBtn">
                        <input type="button" id="onSiteBtnAdd" value="add
identity">
                        <input type="button" id="onSiteBtnDel" value="remove
identity above">
                    </div>
              </div><!-- end of div-->
             <div class="form-group form_row">
                        <label class="col-lg-2 form_lable">圖像:</label>
                        <input type="file" name="image" class="form-control col-lg-10" >
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
<script>
    CKEDITOR.replace( 'editor1' );
</script>
  <script type="text/javascript">
 $(function () {
    $('#onSiteBtnAdd').click(function () { 

        var num     = $('.onsiteCloneClass').length,    
            newNum  = new Number(num + 1),  
            newElem = $('#onsiteCloneId' + num).clone().find("input:text").val("").end().attr('id', 'onsiteCloneId' + newNum).fadeIn('slow');  
            
            $('#onsiteCloneId' + num).after(newElem);
            
            $('#onSiteBtnDel').attr('disabled', false);
   
            if (newNum == 10)
            $('#onSiteBtnAdd').attr('disabled', true).prop('value', "You've reached the limit");
    });

    $('#onSiteBtnDel').click(function () {
        if (confirm("Are you sure you wish to remove this section? This cannot be undone.")){
                var num = $('.onsiteCloneClass').length;
                $('#onsiteCloneId' + num).slideUp('slow', function () {$(this).remove(); 
                    if (num -1 === 1)
                $('#onSiteBtnDel').attr('disabled', true);
                
                $('#onSiteBtnAdd').attr('disabled', false).prop('value', "add section");});
            }
        return false;
             
        $('#onSiteBtnAdd').attr('disabled', false);
    });

    $('#onSiteBtnDel').attr('disabled', true);

});


</script>

 
  <script type="text/javascript">
  $(function() {
    $( "#from" ).datepicker({
      defaultDate: "0",
      changeMonth: true,
      minDate: new Date(),
      numberOfMonths: 1,
      dateFormat: 'yy-mm-dd',
      onSelect:function(){
        if($(this).hasClass('error')){
          $(this).trigger('keyup')
        }
      },
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });

    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      minDate: new Date(),
      dateFormat: 'yy-mm-dd',
      onSelect:function(){
        if($(this).hasClass('error')){
          $(this).trigger('keyup')
        }
      },
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });

    $('#from_time').datetimepicker({
      format: 'HH:mm:ss',
      locale: 'ru'
    });

    $('#to_time').datetimepicker({
      format: 'HH:mm:ss',
      locale: 'ru'
    });

  });

  </script> 





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
                    "title":
                    {
                        required:true,
                        //accept:"[A-Za-z\s0-9]",
                        maxlength: 100,
                        remote:'<?php echo HTTP_ROOT ?>chessman/checkName'

                    },
                    "editor1":
                    {
                        required:true,
                     maxlength: 100

                     
                    },
                    "password":
                    {
                       required:true,
                       minlength: 6,
                       maxlength: 18
                    },
                    "venue":
                    {
                        required:true,
                        maxlength: 50
                    }                 
                    ,
                    "start_date":
                    {
                       required:true
                    },
                    "end_date":
                    {
                       required:true,
                       checkDates:true
                    },
                    "onsite_score[]":
                    {
                       required:true

                    },
                    "image":
                    {
 			                required:true,
                        accept:'jpeg,jpg,png,gif'
                    }

                },   
                messages:
                {
                    "title":
                    {
                       required:"Please Enter Title" ,
                       accept: "Please enter a title only alphabets and number.",
                      remote:"Already name exist"

                    },
                    "editor1":
                    {
                       required:"Please Enter description" 
                    },
                      "onsite_score[]":
                    {
                       required:"Please Enter score" 

                    },
                    "venue":
                    {
                       required:"Please Enter venue" ,
                    },
                    "start_date":
                    {
                       required: "Please Enter start date"
                    },
                    "password":
                    {
                       required:"Please Enter Password.",
                       minlength: 'Password should be atleast 6 characters long.'
                    },
                    "end_date":
                    {
                       required: "Please Enter start date",
                       
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


    
