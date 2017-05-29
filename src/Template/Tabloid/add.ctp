 <style>
 .score{
 margin-top:19px;}
 </style>
 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
 <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i> 添加小报游戏</h1>
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

                   <form onsubmit="return atleast_onecheckbox(event)" action="<?php echo HTTP_ROOT ?>tabloid/add" enctype='multipart/form-data' method="post" id="sign-up_area" role="form">


                    <div class="form-group">
                      <label for="title">活動名稱</label>
                      <input name="title" type="title" class="form-control" id="title">
                    </div>
                  
                    <div class="form-group">
                      <label for="title">遊戲類別</label>
                      <input name="game_type" type="text" value="tabloid" readonly="true" class="form-control">
                    </div>

               
                    <div class="form-group">
                      <label for="from">開始日期:</label>
                      <input type="text" class="form-control" name="start_date" id="from"  placeholder="Enter Start Date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">開始時間:</label>
                          <input type='text' class="form-control" id='from_time' name="start_time" placeholder="Enter Start Time" />
                    </div>
                    
                    <div class="form-group">
                      <label for="to">結束日期:</label>
                      <input type="text" class="form-control" name="end_date" id="to"  placeholder="Enter End Date" placeholder="Enter end date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">結束時間:</label>
                          <input type='text' class="form-control" id='to_time' name="end_time" placeholder="Enter End Time" />
                    </div>

                   

                   
                <!-- Tabloid Game div -->    
                <div id="game_tabloid" > 
                  <!-- <div class="queClass" id="queId" >
                    <input type="button" value="1" class="queBtn">
                  </div>
                  <input type="button" value="+" id="addTabBtn"> -->

                  <div id='tabs'>
                      <ul>
                          <li id='1'><a href='#tab1'>#1</a></li>
                      </ul>
                      <div id='tab1'>
                        <div class="form-group">
                          <label for="comment">题:</label>
                          <textarea name="question_text[0][]" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group col-md-8 col-xs-12">
                       <label for="comment">選項</label><br>A  
                        <input type="text" class="form-control" name="option[0][]" value="" required>
                        </div>
                        <div class="col-md-2 col-xs-12">                        
                         <label for="comment">分數</label><br>
                         <input type="text" class="form-control score" name="score[0][]" value="" required>
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                      B<input type="text" class="form-control" name="option[0][]" value="" required>
                        </div>
                        <div class="col-md-2 col-xs-12">
                         <input type="text" class="form-control score" name="score[0][]" value="" required>
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                        C <input type="text" class="form-control" name="option[0][]" value="" required>
                        </div>
                        <div class="col-md-2 col-xs-12">
                          <input type="text" class="form-control score" name="score[0][]" value="" required>
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                       D   <input type="text" class="form-control" name="option[0][]" value="" required>
                        </div>
                        <div class="col-md-2 col-xs-12">
                          <input type="text" class="form-control score" name="score[0][]" value="" required>
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                      E   <input type="text" class="form-control" name="option[0][]" value="" required>
                        </div>
                        <div class="col-md-2 col-xs-12">
                       <input type="text" class="form-control score" name="score[0][]" value="" required>
                        </div>
                      </div>
                  </div>
<input type="button" id='delete-tab' onclick="deletequestion()" value="刪除問題"> 
                  <input type="button" id='add-tab' value="添加问题">  
                </div>

                    <div class="form-group form_row">
                        <label class="col-lg-2 form_lable">圖像:</label>
                        <input type="file" name="image" class="form-control col-lg-10" >

   <input type="submit" value="提交"></input>
                    </div>

                 



              </form>



                                
                            </div>
                        </div>
                    </div>
            </div>
            <!-- /.row -->


        </div>
</div>

<script type="text/javascript">

function deletequestion()
{
 var num_tabs = $("div#tabs ul li").length;
if(num_tabs==1)
{
alert('未刪除數據');
return 'false';

}
if(num_tabs!=0)
var Id = $('.ui-tabs-active').attr('id');
$('#tab'+Id).remove();

$('.ui-tabs-active').remove();

$("div#tabs").append("<div id='tab"+(num_tabs-1)+"'></div>");

  $("div#tabs").tabs("refresh");

}

  $(document).ready(function(){

    $('#addTabBtn').click(function(){
      var num  = document.getElementById('queId').getElementsByTagName('input').length;
      if(num < 5){
        $('.queClass').children(":last").after('<input type="button" value="'+ (num+1) +'" class="queBtn">');
      }else{
        $(this).attr('disabled', true);
      }
    });

    $(document).ready(function() {
        $("div#tabs").tabs();

        $("#add-tab").click(function() {
          var num_tabs = $("div#tabs ul li").length + 1;
          
          $("div#tabs ul").append(
              "<li><a href='#tab" + num_tabs + "'>#" + num_tabs + "</a></li>"
          );
          $("div#tabs").append("<div id='tab"+num_tabs+"'></div>");
          $("div#tabs").tabs("refresh");

          $("#tab"+num_tabs).append('<div class="form-group"><label for="comment">题:</label><textarea name="question_text['+(num_tabs-1)+'][]" class="form-control" rows="5" ></textarea></div><div class="form-group col-md-8 col-xs-12"><label for="comment">選項</label><br>A <input type="text" class="form-control" name="option['+(num_tabs-1)+'][]" ></div><div class="col-md-2 col-xs-12"><label for="comment">分數</label><input type="text" class="form-control" name="score['+(num_tabs-1)+'][]" ></div><div class="form-group col-md-8 col-xs-12">B <input type="text" class="form-control" name="option['+(num_tabs-1)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs-1)+'][]" ></div><div class="form-group col-md-8 col-xs-12">C <input type="text" class="form-control" name="option['+(num_tabs-1)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs-1)+'][]" ></div><div class="form-group col-md-8 col-xs-12">D <input type="text" class="form-control" name="option['+(num_tabs-1)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs-1)+'][]" ></div><div class="form-group col-md-8 col-xs-12">E <input type="text" class="form-control" name="option['+(num_tabs-1)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs-1)+'][]" ></div>');

          $("#ui-id-"+num_tabs).click();
        });
    });
  });
</script>

<script type="text/javascript">
    function atleast_onecheckbox(e) {
      if ($("input[type=checkbox]:checked").length === 0) {
          e.preventDefault();
          alert('Please Select on Right Answer');
          return false;
      }
    }
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
          });

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
                        maxlength: 50,
                        remote:'<?php echo HTTP_ROOT ?>chessman/checkName'

                    },
                    "password":
                    {
                       required:true,
                       minlength: 6,
                       maxlength: 18
                    },
                    "terms_condition":
                    {
                       required:true
                    },
                    "question_text":
                    {
                       required:true
                    },
                    "marks":
                    {
                       required:true,
                       number:true
                    },
                    "answer_a":
                    {
                       required:true
                    },
                    "answer_b":
                    {
                       required:true
                    },
                    "answer_c":
                    {
                       required:true
                    },
                    "answer_d":
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
                     "question_text":
                    {
                       required:true
                    },
                    "score":
                    {
                       required:true,
                       number:true
                    },
                    "image":
                    {
                       required:true
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
                    },
                    "terms_condition":
                    {
                       required:"Please add Terms & Conditions."
                    },
                    "question_text":
                    {
                       required:"Please Enter Question."
                    },
                    "marks":
                    {
                       required:"Please Enter Marks."
                    },
                    "answer_a":
                    {
                       required:"Please Answer the Question."
                    },
                    "answer_b":
                    {
                       required:"Please Answer the Question."
                    },
                    "answer_c":
                    {
                       required:"Please Answer the Question."
                    },
                    "answer_d":
                    {
                       required:"Please Answer the Question."
                    },
                    "image":
                    {
                        required:"圖片格式錯誤",
                        accept:"I圖片格式錯誤"
                    }

                  
                }
            });

          $('input.example').on('change', function() {
              $('input.example').not(this).prop('checked', false);  
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
  
