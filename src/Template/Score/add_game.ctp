<script src="//cdn.ckeditor.com/4.5.9/full/ckeditor.js"></script>
<div id="wrapper">
        <!-- Navigation -->
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
 <?= $this->Flash->render();?>
                    <h1 class="page-header"><i class="fa fa-user"></i>添加成績範圍</h1>
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

                   <form enctype="multipart/form-data" action="<?php echo HTTP_ROOT ?>score/addGame" method="post" id="sign-up_area" role="form"  >


                    <div class="form-group">
                      <label for="startrange">起始範圍</label>
                      <input name="startrange" type="text" class="form-control" id="startrange">
                    </div>
                  
                      <div class="form-group">
                      <label for="endrange">結束範圍</label>
                      <input type="text" value="" name="endrange" class="form-control" id="endrange">
                    </div>
 
<button type="submit" value="Add Game">提交</button>



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
				"startrange":
                    {
                       required:true,
					    number:true,
                       // accept:"[0-9]",
                       //maxlength: 50
                    },
                     "endrange":
                    {
                        required:true,
						number:true,
                       //accept:"[0-9]",
                        //maxlength: 50,
                        //remote:'<?php echo HTTP_ROOT ?>chessman/checkName'
                    }
                   

                },   
                messages:
                {
                    "startrange":
                    {
                       required:"Please Enter Start Range" ,
                       accept: "Please enter a only Numeric value.",
                       remote:"Already name exist"
                    },
                    "endrange":
                    {
                        required:"Please Enter End Range" ,
                       accept: "Please enter a only Numeric value.",
                    }
                                    
                }
            });

        });
  </script>   
<style>

div.ui-datetimepicker{
 font-size:10px;
}

</style>