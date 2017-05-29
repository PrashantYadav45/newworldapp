<?php
$date=array();
 foreach ($data['startdate'] as $key => $value) {
  $date[]=$value;
 }

  $dateend=array();
 foreach ($data['enddate'] as $key => $value) {
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
                    <h1 class="page-header"><i class="fa fa-user"></i>編輯工匠活動</h1>
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

                   <form onsubmit="return atleast_onecheckbox(event)" action="<?php echo HTTP_ROOT .'onsite/edit/'.$data['id']?>" enctype='multipart/form-data' method="post" id="sign-up_area" role="form">
                    <input name="id" type="hidden" value="<?= $data['id']; ?>" >
                     <div class="form-group">
                      <label for="title">活動名稱</label>
                      <input name="title" type="text" value="<?= $data['title']; ?>" class="form-control" id="title">
                    </div>
                  
               <div class="form-group"  style="display:none">
                      <label for="game_type">游戏类型</label>
                      <input type="text" readonly="true" value="onsite" class="form-control"  name="game_type" id="game_type">
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
                      <div class="form-group" id="descEditor">
                      <label for="from">描述</label>
                      <textarea name="editor1"><?= $data['description']; ?></textarea>
                    </div>

                    <div class="form-group">
                      <label for="pwd">密碼:</label>
                      <input name="password" type="password" value="<?= $data['password']; ?>" class="form-control" id="pwd">
                    </div>
                      
                      <div class="form-group col-md-8">
                        <label>用戶</label>
                      </div>
                      <div class="form-group col-md-2">
                        <label>分數</label>
                      </div>
                      
                      <div id="onsiteCloneId1" class="onsiteCloneClass">
                        <div class="form-group col-md-8 col-xs-12">
                        <?php foreach ($data['users_score'] as $key => $value) {
                        ?> 
                        <input type="text" class="form-control" name="identity[]" value="<?= $value['identity']; ?>">
                        <?php 
                        }
                        ?>
                      </div>

                      <div class="col-md-2 col-xs-12">
                      <?php foreach ($data['users_score'] as $key => $value) {
                      ?>       <input type="text" class="form-control" name="onsite_score[]" value="<?= $value['score']; ?>">
                      <?php 
                      }
                      ?>
                      </div>
                      </div>


                      </div><!-- end of div-->

                   <!-- end sign-up_box -->
                    <div class="form-group form_row">
                      <?php echo $this->Form->input('image', ['label'=>['class'=>'col-lg-2 form_lable','text' => '圖像'],'type'=>'file','class'=>'form-control col-lg-10']); ?>
                      <?php if(!empty($data->game_image->image)) {?>
                      <img width="50px;" src=<?php echo HTTP_ROOT.'img/uploads/'.$data->game_image->image; ?> >
                      <?php } ?>
                    </div>     
                      <input type="hidden" name="image1" value="<?php echo $data->game_image->image; ?>">


                    <input type="submit" value="提交"></input>



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
                    "image":
                    {
                        required:"Please upload image.",
                        accept:"Image not supported, please try with other one."
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
   
  
