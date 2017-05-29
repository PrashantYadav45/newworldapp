<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
<div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
 <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i> 加入遊戲</h1>
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

                   <form enctype="multipart/form-data" action="<?php echo HTTP_ROOT ?>chessman/addGame" method="post" id="sign-up_area" role="form"  >


                    <div class="form-group">
                      <label for="title">活動名稱</label>
                      <input name="title" type="text" class="form-control" id="title">
                    </div>
                  
                      <div class="form-group">
                      <label for="game_type">遊戲類別</label>
                      <input type="text" readonly="true" value="Craftsman chess" class="form-control" id="game_type">
                    </div>
                   <!--  <div class="form-group">
                      <label for="pwd">密码:</label>
                      <input name="password" type="password" class="form-control" id="pwd">
                    </div>

                    <div class="form-group">
                      <label for="comment">Terms:</label>
                      <textarea name="termscondition" class="form-control" rows="5" id="comment"></textarea>
                    </div> -->

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



                    <!-- <input type="hidden" name="data[user][]" value="<?= $user_login_id ?>"> -->
                      <div class="form-group">
                        <label for="title">召集人底分</label>
                        <input type="text" class="form-control" name="host_score" id="score" value="20"  required>
                      </div>

         <!--              <div class="form-group">
                        <label for="title">Admin Position</label>
                        <input type="text" class="form-control" name="data[position][]" id="position" required>
                      </div>


                        <div class="form-group">
                        <label for="title">Admin Bonous</label>
                        <input type="text" name="data[bonous][]" class="form-control" id="bonous" required>
                      </div> -->


     


               <!--  <h2 id="reference" name="reference" class="heading-reference">Entry #1</h2> -->
                
                    <!-- <label class="label_ttl" for="title">User:</label>
                     <select  class="select_ttl form-control"  name="data[user][]" >
                            
                            
                             <option value="">Add user</option>

                           <?php

                             if( isset( $listusers ) && count( $listusers ) > 0 )
                             {
                                
                                 foreach ($listusers as $key => $value) {
                                     
                                ?>
                                <option value="<?php echo $key ?>"><?php echo $value; ?></option>

                            <?php

                               }    
                             }
                           ?>

                        </select> 
 -->



                
                      <div class="form-group">
                        <label for="title">參與者分數</label>
                        <input type="text" class="form-control" name="participant_score" id="user_score" value="10"  required>
                      </div>
<!-- 
                      <div class="form-group">
                        <label for="title">Position</label>
                        <input type="text" class="form-control" name="data[position][]" id="user_position" required>
                      </div>


                        <div class="form-group">
                        <label for="title">Bonous</label>
                        <input type="text" name="data[bonous][]" class="form-control" id="user_bonous" required>
                      </div> -->

 
               
                 
            <!-- end #entry1 -->

            <!-- <div id="addDelButtons">
                <input type="button" id="btnAdd" value="add section"> <input type="button" id="btnDel" value="remove section above">
            </div> -->
  <div class="sign-up_box">
                <label><b>排名與得分</b></label><br/>
                <div id="entry1" class="clonedInput">
                  <div class="form-group">
                    <label for="from">第一名 一</label>
                    <textarea name="rank_score[]" cols="5" rows="1" required></textarea><br/>
                  </div>                 
                        
                </div><!-- end #entry1 -->

                    <div id="addDelButtons">
                        <input type="button" id="btnAdd" value="新增玩家"> <input type="button" id="btnDel" value="移除玩家">
                    </div>
                </div><!-- end sign-up_box -->
            </div> <!-- End of chessman div-->

    
    <div class="form-group">
        <textarea name="editor1"></textarea>
    </div>
 

<button type="submit" value="Add Game">提交-</button>



</form>



                                
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /.row -->


        </div>
</div>

<style type="text/css">
#el09 {font-size:0.5em} /* Smaller text */
</style>
<script>
    CKEDITOR.replace( 'editor1' );
</script>
<script type="text/javascript">
    $(document).on('submit', '#sign-up_area', function() { 
      var data = $(this).serialize();
      var file_data = $('#sortpicture').prop('files')[0];   
      var form_data = new FormData();                  
      form_data.append('file', file_data);
      form_data.append('form', data); 

        $.ajax({
            url     : $(this).attr('action'),
            type    : $(this).attr('method'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data    : form_data,
            success : function(resp) {
              console.log(resp);
              if(resp.data == 'true'){
                  window.location.href= '<?= HTTP_ROOT ?>chessman';
              }else{
                  alert(resp.error);
              }
            },
            error : function( xhr, err ) {
              alert('Something went wrong please try again!.');     
            }
        });    
        return false;
    });
</script>

 <script type="text/javascript">
 $(function () {
    $('#btnAdd').click(function () { 
var textno="";
        var num     = $('.clonedInput').length,    
            newNum  = new Number(num + 1);
if(newNum==1){
textno='一';
}
else if(newNum==2){
textno='二';
}
else if(newNum==3){
textno='三';
}
else if(newNum==4){
textno='四';
}
else if(newNum==5){
textno='五';
}
else if(newNum==6){
textno='六';
}
else if(newNum==7){
textno='七';
}
else if(newNum==8){
textno='八';
}
else if(newNum==9){
textno='九';
}
else if(newNum==10){
textno='十';
}

 
            newElem = $('#entry' + num).clone().find("input:text").val("").end().attr('id', 'entry' + newNum).fadeIn('slow');  
            $('#entry' + num).after(newElem);
            $('#entry' + newNum).children().children(':first').text('第一名'+textno);
            $('#btnDel').attr('disabled', false);
   
            if (newNum == 10){

            $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
alert('現只能給予10位成員參予。');

}
    });

    $('#btnDel').click(function () {
        if (confirm("Are you sure you wish to remove this section? This cannot be undone.")){
                var num = $('.clonedInput').length;
                $('#entry' + num).slideUp('slow', function () {$(this).remove(); 
                    if (num -1 === 1)
                $('#btnDel').attr('disabled', true);
                
                $('#btnAdd').attr('disabled', false).prop('value', "add section");});
            }
        return false;
             
        $('#btnAdd').attr('disabled', false);
    });

    $('#btnDel').attr('disabled', true);

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

          $.fn.parseValToNumber = function() {
            return parseInt($(this).val().replace(':',''), 10);
          }

          $('select').change(function(){
            $('#start_date, #end_date').keyup()
          })

            $('#sign-up_area').validate({
              // onfocusout: function (element) {
              //    $(element).valid();
              //   },
                rules:
                {
                     "title":
                    {
                        required:true,
                       // accept:"[A-Za-z]",
                        maxlength: 50,
                        remote:'<?php echo HTTP_ROOT ?>chessman/checkName'
                    },
                    "password":
                    {
                       required:true,
                       minlength: 6,
                       maxlength: 18
                    },
                    "termscondition":
                    {
                       required:true
                    },
                    "rank_score":
                    {
                       required:true,
                       number:true
                    },
                    "data[position][]":
                    {
                       required:true
                    },
                    "data[bonous][]":
                    {
                       required:true,
                       number:true
                    },
                    "data[user][]":
                    {
                       required:true
                    },
                    "start_date":
                    {
                       required:true
                    },
                    "end_date":
                    {
                       required:true,
                       checkDates:true
                    },
                    "from_time":
                    {
                       required:true
                    },
                    "to_time":
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
                       accept: "Please enter a name only alphabets.",
                       remote:"Already name exist"
                    },
                    "password":
                    {
                       required:"Please Enter Password.",
                       minlength: 'Password should be atleast 6 characters long.'
                    }
                    ,
                    "image":
                    {
                       required:"Please Enter image."
                    },
                    "termscondition":
                    {
                       required:"Please add Terms & Conditions."
                    },
                    "data[score][]":
                    {
                       required:"Please Enter Score."
                    },
                    "data[position][]":
                    {
                       required:"Please Enter Position."
                    },
                    "data[bonous][]":
                    {
                       required:"Please Enter Bonus."
                    },
                    "data[user][]":
                    {
                       required:"Please Select User."
                    },

                  
                }
            });

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
