 <?php

$date=array();
 foreach ($data[0]['startdate'] as $key => $value) {
  $date[]=$value;
 }

  $dateend=array();
 foreach ($data[0]['enddate'] as $key => $value) {
  $dateend[]=$value;

 }

 $originalDate = $date[0];
$newDate = date("Y-m-d", strtotime($originalDate));
$starttime = date("H:i:s", strtotime($originalDate));

$originalDateend = $dateend[0];
$newDateend = date("Y-m-d", strtotime($originalDateend));
$starttimeend = date("H:i:s", strtotime($originalDateend));


  ?>
<?php echo $this->Html->script('ckeditor.js');?>
 <div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
 <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i> 編輯家刊問題</h1>
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

                   <form onsubmit="return atleast_onecheckbox(event)" action="<?php echo HTTP_ROOT .'tabloid/edit/'.$data[0]['id']?>" enctype='multipart/form-data' method="post" id="sign-up_area" role="form">
                    <input name="id" type="hidden" value="<?= $data[0]['id']; ?>" >
                    <input name="question_id" type="hidden" value="<?= $data[0]['question']['id']; ?>" >

                    <div class="form-group">
                      <label for="title">活動名稱</label>
                      <input name="title" type="text" value="<?= $data[0]['title']; ?>" class="form-control" id="title">
                    </div>
                  
                    <div class="form-group">
                      <label for="type">遊戲類別</label>
                      <input name="game_type" type="text" value="tabloid" readonly="true" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="pwd">密碼:</label>
                      <input name="password" type="password" value="<?= $data[0]['password']; ?>" class="form-control" id="pwd">
                    </div>

                    <div class="form-group">
                      <label for="from">開始日期:</label>
                      <input type="text" class="form-control" value="<?= $newDate ; ?>" name="start_date" id="from"  placeholder="Enter Start Date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">開始時間:</label>
                          <input type='text' class="form-control" value="<?=  $starttime; ?>" id='from_time' name="start_time" placeholder="Enter Start Time" />
                    </div>
                    
                    <div class="form-group">
                      <label for="to">結束日期:</label>
                      <input type="text" class="form-control" value="<?= $newDateend; ?>" name="end_date" id="to" placeholder="Enter end date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">結束時間:</label>
                          <input type='text' class="form-control" value="<?=  $starttimeend ; ?>" id='to_time' name="end_time" placeholder="Enter End Time" />
                    </div>
		
<!-- Tabloid Game div --> 
    <div id="game_tabloid" > 
                  <!-- <div class="queClass" id="queId" >
                    <input type="button" value="1" class="queBtn">
                  </div>
                  <input type="button" value="+" id="addTabBtn"> -->
				
                  <div id='tabs'>
		
                      <ul>
	<?php	for ($i=0;$i<count($data);$i++){?>
			              <li id="<?= $i?>"><a href='#tab<?= $i?>'><?=$i	?></a></li>
	<?php }?>	  
	                  </ul>
					  <?php	 for ($j=0;$j<count($data);$j++){
						  ?>
                      <div id='tab<?=$j?>'>
                        <div class="form-group">
                          <label for="comment">题:</label>
                          <textarea name="question_text[<?=$j?>][]" class="form-control" rows="4"  required><?= $data[$j]['question']['question_text'];?></textarea>
                        </div>
                        <div class="form-group col-md-8 col-xs-12">
                       <label for="comment">選項</label><br>A  
                        <input type="text" class="form-control" name="option[<?=$j?>][]" value="<?= $data[$j]['question']['questionanswersoptions'][0]['answer_option_text'];?>" >
                        </div>
                        <div class="col-md-2 col-xs-12">                        
                         <label for="comment">分數</label><br>
                         <input type="text" class="form-control" name="score[<?=$j?>][]" value="<?= $data[$j]['question']['questionanswersoptions'][0]['score'];?>">
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                      B<input type="text" class="form-control" name="option[<?=$j?>][]" value="<?= $data[$j]['question']['questionanswersoptions'][1]['answer_option_text'];?>">
                        </div>
                        <div class="col-md-2 col-xs-12">
                         <input type="text" class="form-control" name="score[<?=$j?>][]" value="<?= $data[$j]['question']['questionanswersoptions'][1]['score'];?>">
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                        C <input type="text" class="form-control" name="option[<?=$j?>][]" value="<?= $data[$j]['question']['questionanswersoptions'][2]['answer_option_text'];?>">
                        </div>
                        <div class="col-md-2 col-xs-12">
                          <input type="text" class="form-control" name="score[<?=$j?>][]" value="<?= $data[$j]['question']['questionanswersoptions'][2]['score'];?>">
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                       D   <input type="text" class="form-control" name="option[<?=$j?>][]" value="<?= $data[$j]['question']['questionanswersoptions'][3]['answer_option_text'];?>">
                        </div>
                        <div class="col-md-2 col-xs-12">
                          <input type="text" class="form-control" name="score[<?=$j?>][]" value="<?= $data[$j]['question']['questionanswersoptions'][3]['score'];?>">
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                      E   <input type="text" class="form-control" name="option[<?=$j?>][]" value="<?= $data[$j]['question']['questionanswersoptions'][4]['answer_option_text'];?>">
                        </div>
                        <div class="col-md-2 col-xs-12">
                       <input type="text" class="form-control" name="score[<?=$j?>][]" value="<?= $data[$j]['question']['questionanswersoptions'][4]['score'];?>">
                        </div>
                      </div>
			<?php } ?>		  
                  </div>
<input type="button" id='delete-tab' onclick="deletequestion()" value="刪除問題"> 
                  <input type="button" id='add-tab' value="添加问题"> 

                    <!-- end sign-up_box -->
                    <div class="form-group form_row">
                      <?php echo $this->Form->input('image', ['label'=>['class'=>'col-lg-2 form_lable','text' => '圖像'],'type'=>'file','class'=>'form-control col-lg-10']); ?>
                      <?php if(!empty($data[0]['game_image']['image'])) {?>
                      <img width="50px;" src=<?php echo HTTP_ROOT.'img/uploads/'.$data[0]['game_image']['image']; ?> >
                      <?php } ?>
                    </div>     
                      <input type="hidden" name="image1" value="<?php echo $data[0]['game_image']['image']; ?>">

 
                    <input type="submit" value="提交"></input>
              </form>
            </div>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $count=count($data); 
 
			
		?>
<script type="text/javascript">
var count="<?php $count?>";
function deletequestion()
{
 var num_tabs = $("div#tabs ul li").length;
if(num_tabs==1)
{
alert('未刪除數據');
return 'false';

}
if(num_tabs!=1)
var Id = $('.ui-tabs-active').attr('id');
$('#tab'+Id).remove();

$('.ui-tabs-active').remove();
if(Id==0){
$("div#tabs").append("<div id='tab"+1+"'></div>");

  $("div#tabs").tabs("refresh");}
}
 $(document).ready(function() {
        $("div#tabs").tabs();

        $("#add-tab").click(function() {
          var num_tabs = $("div#tabs ul li").length ;
          /*if(count>1){
		  var num_tabs=count+1;
		  }else{
			  var num_tabs = $("div#tabs ul li").length + 1;
		  }*/
          $("div#tabs ul").append(
              "<li><a href='#tab" + num_tabs + "'>#" + num_tabs + "</a></li>"
          );
          $("div#tabs").append("<div id='tab"+num_tabs+"'></div>");
          $("div#tabs").tabs("refresh");

          $("#tab"+num_tabs).append('<div class="form-group"><label for="comment">题:</label><textarea name="question_text['+(num_tabs)+'][]" class="form-control" rows="5" ></textarea></div><div class="form-group col-md-8 col-xs-12"><label for="comment">選項</label><br>A<input type="text" class="form-control" name="option['+(num_tabs)+'][]" ></div><div class="col-md-2 col-xs-12"><label for="comment">分數</label><input type="text" class="form-control" name="score['+(num_tabs)+'][]" ></div><div class="form-group col-md-8 col-xs-12">B<input type="text" class="form-control" name="option['+(num_tabs)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs)+'][]" ></div><div class="form-group col-md-8 col-xs-12">C<input type="text" class="form-control" name="option['+(num_tabs)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs)+'][]" ></div><div class="form-group col-md-8 col-xs-12">D<input type="text" class="form-control" name="option['+(num_tabs)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs)+'][]" ></div><div class="form-group col-md-8 col-xs-12">E<input type="text" class="form-control" name="option['+(num_tabs)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs)+'][]" ></div>');

          $("#ui-id-"+num_tabs).click();
		 
        });
    });   
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
                        //accept:"[A-Za-z]",
                        maxlength: 50
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
                    "image":
                    {
                        accept:'jpeg,jpg,png,gif'
                    }

                },   
                messages:
                {
                    "title":
                    {
                       required:"Please Enter Title" ,
                      // accept: "Please enter a name only alphabets."
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
                        accept:"Image not supported, please try with other one."
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
   
  
