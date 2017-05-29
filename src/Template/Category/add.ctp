<div id="wrapper">
       <?= $this->element('nav'); ?>
       <div id="page-wrapper" style="min-height: 343px;">
            <div class="row spacing">
                <div class="col-lg-12 main_heading">
                     <?= $this->Flash->render();?>
                </div>
            </div>
            <!-- <button class="btn btn-default" onclick="goBack()">Back</button> -->
            <div class="row spacing">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading heading_label">
                        
                            <span class="semi-bold"> Add Category</span>
                       
                            <a href="javascript:history.back()"><button class="btn btn-default" style="float:right">Go Back</button></a>
                        </div>
                        <div class="panel-body spacing">
                            <div class="row spacing">
                                <div class="col-lg-12 spacing">
                                    <form id="addForm" role="form" action="<?=HTTP_ROOT?>Category/add" enctype='multipart/form-data' method="post">
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">Category Name</label>
                                            <input type="text" placeholder="Enter title" class="form-control col-lg-10" name="cat_name">
                                        </div>
                                                                              
                                       
                                       <div class="form-group form_row"> <button class="btn btn-default submit" type="submit">Submit</button></div>
                                       
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
 
<script type="text/javascript">
        $(document).ready(function() {
            $('#addForm').validate({
              onfocusout: function (element) {
                 $(element).valid();
                },
                rules:
                {
                    "cat_name":
                    {
                        required:true,
                       // accept:"/^[a-zA-Z]+$/",
                        maxlength: 100
                    }

                },   
                messages:
                {
                    "cat_name":
                    {
                       required:"Please Enter Category" ,
                       accept: "Please enter a category only alphabets."
                    }
                  
                }
            });
        });
  </script>   
