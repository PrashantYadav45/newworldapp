 <?php



  ?><div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
 <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i> 編輯分數範圍</h1>
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

                   <form enctype="multipart/form-data" action="<?php echo HTTP_ROOT.'score/editScore/'.$data['rangeid'] ?>" method="post" id="sign-up_area"  role="form">
                    <input type="hidden" name="id" value="<?= $data['rangeid'] ?>" />
                      <div class="form-group">
                        <label for="startrange">起始範圍</label>
                        <input name="startrange" value="<?= $data['start_range'] ?>" type="title" class="form-control" id="startrange">
                      </div>
                              
                    <div class="form-group">
                      <label for="endrange">結束範圍</label>
                      <input name="endrange" value="<?= $data['end_range'] ?>" type="text"  class="form-control">
                    </div>
                                                 
<button type="submit" value="Edit Game">提交</button>



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
                        accept:"[A-Za-z]",
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
