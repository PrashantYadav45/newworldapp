<!-- <script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script> -->
<?php echo $this->Html->script('ckeditor.js');?>
<div id="wrapper">
       <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                  <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i> Add Games</h1>
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

                   <form onsubmit="return atleast_onecheckbox(event)" action="<?php echo HTTP_ROOT ?>AllGames/add" enctype='multipart/form-data' method="post" id="sign-up_area" role="form">


                    <div class="form-group">
                      <label for="title">Title</label>
                      <input name="title" type="title" class="form-control" id="title">
                    </div>

                   <div class="form-group">
                      <label for="title">Category</label>
                      <select name="cat_id" class="form-control" id="categoryId">
                        <?php foreach ($cats as $key => $cat) { ?>
                            <option value="<?= $cat['id'] ?>"><?= $cat['cat_name'] ?></option>
                        <?php }?>
                      </select>
                    </div> 
                
                <div id="dateTimeDiv">    
                    <div class="form-group">
                      <label for="from">Start Date:</label>
                      <input type="text" class="form-control" name="start_date" id="from"  placeholder="Enter Start Date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">Start Time:</label>
                          <input type='text' class="form-control" id='from_time' name="start_time" placeholder="Enter Start Time" />
                    </div>
                    
                    <div class="form-group">
                      <label for="to">End Date:</label>
                      <input type="text" class="form-control" name="end_date" id="to"  placeholder="Enter End Date" placeholder="Enter end date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">End Time:</label>
                          <input type='text' class="form-control" id='to_time' name="end_time" placeholder="Enter End Time" />
                    </div>
                </div>
                    <div class="form-group" id="descEditor">
                      <label for="from">Description</label>
                      <textarea name="editor1"></textarea>
                    </div>

                <!-- On site game div-->    
                <div id="game_on_site" style="display:none">

                    <div class="form-group">
                      <label for="pwd">Password:</label>
                      <input name="password" type="password" class="form-control" id="pwd">
                    </div>

                      
                      <div class="form-group col-md-8">
                        <label>Identity</label>
                      </div>
                      <div class="form-group col-md-2">
                        <label>Score</label>
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
                        <input type="button" id="onSiteBtnAdd" value="add section">
                        <input type="button" id="onSiteBtnDel" value="remove section above">
                    </div>
              </div><!-- end of div-->

                <!-- start of chessman div-->
                <div id="game_craftsman">
                      <div class="form-group">
                        <label for="title">Host Basic Score</label>
                        <input type="text" class="form-control" name="host_score" id="score" value="20" readonly="true" required>
                      </div>

                      <div class="form-group">
                        <label for="title">Participant Score</label>
                        <input type="text" class="form-control" name="participant_score" id="user_score" value="10" readonly="true" required>
                      </div>


                <div class="sign-up_box">
                <label><b>Marks earned by</b></label><br/>
                <div id="entry1" class="clonedInput">
                  <div class="form-group">
                    <label for="from">Rank1</label>
                    <textarea name="rank_score[]" cols="5" rows="1" required></textarea><br/>
                  </div>                 
                        
                </div><!-- end #entry1 -->

                    <div id="addDelButtons">
                        <input type="button" id="btnAdd" value="add section"> <input type="button" id="btnDel" value="remove section above">
                    </div>
                </div><!-- end sign-up_box -->
            </div> <!-- End of chessman div-->


                <!-- Tabloid Game div -->    
                <div id="game_tabloid" style="display:none"> 
                  <!-- <div class="queClass" id="queId" >
                    <input type="button" value="1" class="queBtn">
                  </div>
                  <input type="button" value="+" id="addTabBtn"> -->

                  <div id='tabs'>
                      <ul>
                          <li><a href='#tab1'>#1</a></li>
                      </ul>
                      <div id='tab1'>
                        <div class="form-group">
                          <label for="comment">Question:</label>
                          <textarea name="question_text[]" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="form-group col-md-8 col-xs-12">
                          <input type="text" class="form-control" name="option[0][]" value="" >
                        </div>
                        <div class="col-md-2 col-xs-12">
                          <input type="text" class="form-control" name="score[0][]" value="">
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                          <input type="text" class="form-control" name="option[0][]" value="">
                        </div>
                        <div class="col-md-2 col-xs-12">
                          <input type="text" class="form-control" name="score[0][]" value="">
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                          <input type="text" class="form-control" name="option[0][]" value="">
                        </div>
                        <div class="col-md-2 col-xs-12">
                          <input type="text" class="form-control" name="score[0][]" value="">
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                          <input type="text" class="form-control" name="option[0][]" value="">
                        </div>
                        <div class="col-md-2 col-xs-12">
                          <input type="text" class="form-control" name="score[0][]" value="">
                        </div>

                        <div class="form-group col-md-8 col-xs-12">
                          <input type="text" class="form-control" name="option[0][]" value="">
                        </div>
                        <div class="col-md-2 col-xs-12">
                          <input type="text" class="form-control" name="score[0][]" value="">
                        </div>
                      </div>
                  </div>
                  <input type="button" id='add-tab' value="Add tab">  
                </div>

                    <div class="form-group form_row">
                        <label class="col-lg-2 form_lable">Image:</label>
                        <input type="file" name="image" class="form-control col-lg-10" >
                    </div>

                    <input type="submit" value="Submit"></input>



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
.ui-tabs-panel.ui-widget-content.ui-corner-bottom {
    display: inline-block;
}
#appendOnSiteBtn {
    display: inline-block;
}
</style>
<script>
    CKEDITOR.replace( 'editor1' );
</script>

<script type="text/javascript">

        if($(this).find("option:selected").text() == 'tabloid'){
            function atleast_onecheckbox(e) {
                if ($("input[type=checkbox]:checked").length === 0) {
                    e.preventDefault();
                    alert('Please Select on Right Answer');
                    return false;
                }
            }
        }else{
            function atleast_onecheckbox(){}
        }
 
        $(document).ready(function() {
          // adding validation for dates
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
                       required:true,
                       accept:'jpeg,jpg,png,gif'
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
                        required:"Please Upload Image.",
                        accept:"Image not supported, please try with other one."
                    }

                  
                }
            });

            $('input.example').on('change', function() {
                $('input.example').not(this).prop('checked', false);  
            });

            $('#categoryId').on('change', function() {
                console.log($(this).find("option:selected").text()+' clicked!');
                switch($(this).find("option:selected").text()) {
                    case 'craftsman':
                        $('#dateTimeDiv').css('display','block');
                        $('#descEditor').css('display','block');
                        $('#game_tabloid').css('display','none');
                        $('#game_on_site').css('display','none');
                        $('#game_craftsman').css('display','block');
                        break;
                    case 'onsite':
                        $('#descEditor').css('display','block');
                        $('#dateTimeDiv').css('display','none');
                        $('#game_tabloid').css('display','none');
                        $('#game_on_site').css('display','block');
                        $('#game_craftsman').css('display','none');
                        break;
                    case 'tabloid':
                        $('#dateTimeDiv').css('display','block');
                        $('#descEditor').css('display','none');
                        $('#game_tabloid').css('display','block');
                        $('#game_on_site').css('display','none');
                        $('#game_craftsman').css('display','none');
                        break;
                    case 'iworld':
                        $('#dateTimeDiv').css('display','block');
                        $('#descEditor').css('display','none');
                        $('#game_tabloid').css('display','block');
                        $('#game_on_site').css('display','none');
                        $('#game_craftsman').css('display','none');
                        break;
                    default:
                        $('#dateTimeDiv').css('display','block');
                        $('#descEditor').css('display','block');
                        $('#game_tabloid').css('display','none');
                        $('#game_on_site').css('display','none');
                        $('#game_craftsman').css('display','block');
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
  <script type="text/javascript">
 $(function () {
    $('#btnAdd').click(function () { 

        var num     = $('.clonedInput').length,    
            newNum  = new Number(num + 1),    
            newElem = $('#entry' + num).clone().find("input:text").val("").end().attr('id', 'entry' + newNum).fadeIn('slow');  
            $('#entry' + num).after(newElem);
            $('#entry' + newNum).children().children(':first').text('Rank'+newNum);
            $('#btnDel').attr('disabled', false);
   
            if (newNum == 10)
            $('#btnAdd').attr('disabled', true).prop('value', "You've reached the limit");
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

          $("#tab"+num_tabs).append('<div class="form-group"><label for="comment">Question:</label><textarea name="question_text[]" class="form-control" rows="5" ></textarea></div><div class="form-group col-md-8 col-xs-12"><input type="text" class="form-control" name="option['+(num_tabs-1)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs-1)+'][]" ></div><div class="form-group col-md-8 col-xs-12"><input type="text" class="form-control" name="option['+(num_tabs-1)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs-1)+'][]" ></div><div class="form-group col-md-8 col-xs-12"><input type="text" class="form-control" name="option['+(num_tabs-1)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs-1)+'][]" ></div><div class="form-group col-md-8 col-xs-12"><input type="text" class="form-control" name="option['+(num_tabs-1)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs-1)+'][]" ></div><div class="form-group col-md-8 col-xs-12"><input type="text" class="form-control" name="option['+(num_tabs-1)+'][]" ></div><div class="col-md-2 col-xs-12"><input type="text" class="form-control" name="score['+(num_tabs-1)+'][]" ></div>');

          $("#ui-id-"+num_tabs).click();
        });
    });
  });
</script>