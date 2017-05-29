<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>

<div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
 <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i> 編輯康樂棋</h1>
            <a href="javascript:history.back()"><button class="btn btn-default" style="float:right">返回</button></a>
                </div>

            </div>
            <div class="row spacing">
                 <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading heading_label">
                            </div>
                            <div class="row spacing">
                                <div class="col-md-7 right">
                                    
                            <div class="panel-body">

                   <form enctype="multipart/form-data" action="<?php echo HTTP_ROOT.'chessman/editGame/'.$gameData->id ?>" method="post" id="sign-up_area"  role="form">
                    <input type="hidden" name="id" value="<?= $gameData->id ?>" />
                      <div class="form-group">
                        <label for="title">活動名稱</label>
                        <input name="title" value="<?= $gameData->title ?>" type="title" class="form-control" id="title">
                      </div>
                  
                      <div class="form-group">
                        <label for="game_type">遊戲類別</label>
                        <input type="text" readonly="true" value="Craftsman chess" class="form-control" id="game_type">
                      </div>
                      <!-- <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input name="password" type="password" value="<?= $gameData->password ?>" class="form-control" id="pwd">
                      </div> -->

                      <div class="form-group">
                      <label for="from">開始日期 :</label>
                      <input type="text" class="form-control" value="<?=  isset($gameData->startdate) ? $gameData->startdate->format('Y-m-d') : '' ?>" name="start_date" id="from"  placeholder="Enter Start Date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">開始時間:</label>
                          <input type='text' class="form-control" value="<?=  isset($gameData->startdate) ? $gameData->startdate->format('H:i:s') : '' ?>" id='from_time' name="start_time" placeholder="Enter Start Time" />
                    </div>
                    
                    <div class="form-group">
                      <label for="to">結束日期:</label>
                      <input type="text" class="form-control" value="<?=  isset($gameData->enddate) ? $gameData->enddate->format('Y-m-d') : '' ?>" name="end_date" id="to" placeholder="Enter end date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">結束時間:</label>
                          <input type='text' class="form-control" value="<?=  isset($gameData->enddate) ? $gameData->enddate->format('H:i:s') : '' ?>" id='to_time' name="end_time" placeholder="Enter End Time" />
                    </div>

                     <div class="form-group">
                      <label for="title">召集人底分</label>
                      <input type="text" class="form-control" name="host_score" id="score" value="<?= $gameData->host_score ?>"  required>
                    </div>

                    <div class="form-group">
                      <label for="title">參與者分數</label>
                      <input type="text" class="form-control" name="participant_score" id="user_score" value="<?= $gameData->participant_score ?>"  required>
                    </div>

                    <div class="form-group">
                      <label><b>排名與得分</b></label><br/>
                      <?php
                      $i = 1;
                      foreach($gameData->users_score as $k=>$val){
if($i==1){
$textno='一';
}
else if($i==2){
$textno='二';
}
else if($i==3){
$textno='三';
}
else if($i==4){
$textno='四';
}
else if($i==5){
$textno='五';
}
else if($i==6){
$textno='六';
}
else if($i==7){
$textno='七';
}
else if($i==8){
$textno='八';
}
else if($i==9){
$textno='九';
}
else if($i==10){
$textno='十';
}




                      ?>  <label for="from">第<?php echo $textno ;?>名:</label>   <textarea name="rank_score[]" cols="5" rows="1"><?= $val['score']; ?></textarea><br/>
                      <?php
                 $i++;
                      }
                      ?>
                    </div> 

                    <div class="form-group">
                        <textarea name="editor1"><?= $gameData->description ?></textarea>
                    </div>

                  <!--   <div class="form-group">
                      <label for="comment">Terms:</label>
                      <textarea name="termscondition" class="form-control" rows="5" id="comment"><?= $gameData->terms_condition ?></textarea>
                    </div> -->


         <div class="sign-up_box">
          <?php foreach ($gameData['users_score'] as $key => $rec) {?>
            <div id="entry<?= $key+1?>" class="clonedInput">
              <?php if($rec['user_id'] != $user_login_id) {?>
              <!--   <label class="label_ttl" for="title">User:</label>
                     <select  class="select_ttl form-control"  name="data[user][]" id="title">
                        <option value="">Add user</option>
                           <?php if( isset( $listusers ) && count( $listusers ) > 0 ) {
                                 foreach ($listusers as $key => $value) { ?>
                                <option <?php if($key == $rec['user_id']){?>selected="selected"<?php }?> value="<?php echo $key ?>"><?php echo $value; ?></option>
                            <?php } } ?>
                      </select>  -->
                <?php }else{?>
                  <!-- <input type="hidden" name="data[user][]" value="<?= $user_login_id ?>"> -->
                <?php } ?>
                      <!-- <div class="form-group">
                        <?php if($rec['user_id'] == $user_login_id) {?>
                        <label for="title">Admin Score</label>
                        <input type="text" class="form-control" value="<?= $rec['score']?>" name="data[score][]" value="20" readonly="true" id="score">
                        <?php }else{?>
                        <label for="title">Score</label>
                        <input type="text" class="form-control" value="<?= $rec['score']?>" name="data[score][]" value="10" readonly="true" id="user_score">
                        <?php }?>
                      </div> -->

                      <!-- <div class="form-group">
                        <?php if($rec['user_id'] == $user_login_id) {?>
                        <label for="title">Admin Position</label>
                        <?php }else{?>
                        <label for="title">Position</label>
                        <?php }?>
                        <input type="text" class="form-control" value="<?= $rec['position']?>" name="data[position][]" id="position">
                      </div> -->


                      <!-- <div class="form-group">
                        <?php if($rec['user_id'] == $user_login_id) {?>
                        <label for="title">Admin Bonous</label>
                        <?php }else{?>
                        <label for="title">Bonous</label>
                        <?php }?>
                        <input type="text" value="<?= $rec['bonus']?>" name="data[bonous][]" class="form-control" id="bonous">
                      </div>    -->
            </div><!-- end #entry1 -->
            <?php } ?>
            <!-- <div id="addDelButtons">
                <input type="button" id="btnAdd" value="add section"> <input type="button" id="btnDel" value="remove section above">
            </div> -->

            
        
    </div><!-- end sign-up_box -->

                    <!-- <div class="form-group form_row">
                      <?php echo $this->Form->input('image', ['label'=>['class'=>'col-lg-2 form_lable','text' => 'Image'], 'id'=>'sortpicture','type'=>'file','class'=>'form-control col-lg-10']); ?>
                      <?php if(!empty($gameData->game_image->image)) {?>
                      <img width="50px;" src=<?php echo HTTP_ROOT.'img/uploads/'.$gameData->game_image->image; ?> >
                      <?php } ?>
                    </div>     
                      <input type="hidden" name="image1" value="<?php if(!empty($gameData->game_image->image)) { echo $gameData->game_image->image; }?>"> -->


<button type="submit" value="Edit Game">提交-</button>



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
        var num     = $('.clonedInput').length,    
            newNum  = new Number(num + 1),
            newElem = $('#entry' + num).clone().find("input:text:not('#user_score')").val("").end().attr('id', 'entry' + newNum).fadeIn('slow');  
            $('#entry' + num).after(newElem);
            $('#ID' + newNum + '_title').focus();
            $(this).parent().prev().find('select option').prop("selected", false);

            $('#btnDel').attr('disabled', false);
 
            if (newNum == 10)
            $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
    });

    $('#btnDel').click(function () {
        if($('.clonedInput').length < 3){
          $('#btnDel').attr('disabled', true).prop('value', "Atleast 2 User should be in a game");
          return false;
        }
        if (confirm("Are you sure you wish to remove this section? This cannot be undone."))
            {
                var num = $('.clonedInput').length;
                
                $('#entry' + num).slideUp('slow', function () {$(this).remove(); 
               
                    if (num -1 === 1)
                $('#btnDel').attr('disabled', true);
                
                $('#btnAdd').attr('disabled', false).prop('value', "add section");});
            }
        return false;
             
        $('#btnAdd').attr('disabled', false);
    });

    // $('#btnDel').attr('disabled', true);

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
                var startTime = startDate.getTime() + $('#from_time').parseValToNumber();
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
                      //  accept:"[A-Za-z]",
                        maxlength: 50

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
                    "data[score][]":
                    {
                       required:true
                    },
                    "data[position][]":
                    {
                       required:true
                    },
                    "data[bonous][]":
                    {
                       required:true
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
                    }
                },   
                messages:
                {
                    "title":
                    {
                       required:"Please Enter Title" ,
                       accept: "Please enter a name only alphabets."
                    },
                    "password":
                    {
                       required:"Please Enter Password.",
                       minlength: 'Password should be atleast 6 characters long.'
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
                    }

                  
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
