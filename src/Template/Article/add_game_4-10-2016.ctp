<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
<div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
 <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i> Add article</h1>
                       <a href="javascript:history.back()"><button class="btn btn-default" style="float:right">Go Back</button></a>
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

                   <form enctype="multipart/form-data" action="<?php echo HTTP_ROOT ?>article/addGame" method="post" id="sign-up_area" role="form"  >


                    <div class="form-group">
                      <label for="title">Title</label>
                      <input name="title" type="text" class="form-control" id="title">
                    </div>
                  
                      <div class="form-group">
                      <label for="game_type">Game Type</label>
                      <input type="text" value="article" name="game_type" class="form-control" id="game_type">
                    </div>
    <div class="form-group">
                      <label for="pwd">Password:</label>
                      <input name="password" type="password" class="form-control" id="pwd">
                    </div>

                    <div class="form-group">
                      <label for="from">Start Date:</label>
                      <input type="text" class="form-control" name="start_date" id="from"  placeholder="Enter Start Date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">Start Time:</label>
                          <input type='text' class="form-control" id='from_time' name="start_time" placeholder="Enter Start Time" required>
                    </div>
                    
                    <div class="form-group">
                      <label for="to">End Date:</label>
                      <input type="text" class="form-control" name="end_date" id="to"  placeholder="Enter End Date" placeholder="Enter end date" required>
                    </div>

                    <div class="form-group">
                      <label for="from">End Time:</label>
                          <input type='text' class="form-control" id='to_time' name="end_time" placeholder="Enter End Time" required>
                    </div>

     <div class="form-group form_row">
                        <label class="col-lg-2 form_lable">Image:</label>
                        <input type="file" name="image" class="form-control col-lg-10" >
                    </div>


<button type="submit" value="Add Game">Submit</button>



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


<style>

div.ui-datetimepicker{
 font-size:10px;
}

</style>