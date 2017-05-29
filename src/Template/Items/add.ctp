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
                        
                            <span class="semi-bold"> 添加禮品 </span>
                       
                            <a href="javascript:history.back()"><button class="btn btn-default" style="float:right">返回</button></a>
                        </div>
                        <div class="panel-body spacing">
                            <div class="row spacing">
                                <div class="col-lg-12 spacing">
                                    <form id="addForm" role="form" action="<?=HTTP_ROOT?>items/add" enctype='multipart/form-data' method="post">
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">項目名稱</label>
                                            <input type="text" placeholder="Enter title" class="form-control col-lg-10" name="item_title">
                                        </div>
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">所需分數</label>
                                            <input type="text" placeholder="Enter Score" class="form-control col-lg-10" name="score">
                                        </div>
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">禮品庫存</label>
                                            <input type="text" placeholder="Enter Stock" class="form-control col-lg-10" name="stock">
                                        </div>
                                        <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">描述</label>
                                            <textarea type="text" placeholder="Enter description" class="form-control col-lg-10"  name="description"></textarea>
                                            </div>

                                             <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">換領方法</label>
                                            <textarea type="text" placeholder="Enter redemmption" class="form-control col-lg-10"  name="method_redemmption"></textarea>
                                            </div>
                                             <div class="form-group form_row">
                                            <label class="col-lg-2 form_lable">條款</label>
                                            <textarea type="text" placeholder="Enter term & conditions" class="form-control col-lg-10"  name="terms_conditions"></textarea>
                                            </div>
                                            
                                        
                                        <div class="form-group form_row">
                                        <?php echo $this->Form->input('image', ['label'=>['class'=>'col-lg-2 form_lable','text' => '圖像'],'type'=>'file','class'=>'form-control col-lg-10']); ?>
                                       
                                        </div> 
                                            <p> accept Format: gif| png| jpg |jpeg |JPG </p>                                             
                                       
                                       <div class="form-group form_row"> <button class="btn btn-default submit" type="submit">提交</button></div>
                                       
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
                    "item_title":
                    {
                        required:true,
                       // accept:"[A-Za-z\s0-9]",
                        maxlength: 100
                    },
                    "description":
                    {
                        required:true,
                        //accept:"[A-Za-z\s0-9]",
                        maxlength: 500
                    },
 		   "method_redemmption":
                    {
                        required:true,
                        maxlength: 500
                    },
 		"terms_conditions":
                    {
                        required:true,
                        maxlength: 500
                    },
                    "score":
                    {
                        required:true,
                        accept:"[0-9]",
                        maxlength: 50
                    },                    
                    
                    "image":
                    {   
			 required:true,
                        accept:'jpeg,jpg,png,gif'
                    }

                },   
                messages:
                {
                    "item_title":
                    {
                       required:"Please Enter Title" ,
                       accept: "Please enter a title only alphabets and number."
                    },
                    "description":
                    {
                       required:"Please Enter Description" ,
                       accept: "Please enter a title only alphabets and number."
                    },
 		   "method_redemmption":
                    {
                       required:"Please Enter Method Redemmption" ,
                    },
  		   "terms_conditions":
                    {
                       required:"Please Enter Terms Conditions" ,

                    },
                    "score":
                    {
                       required:"Please Enter Score" ,
                       accept: "Please enter a score only number."
                    },
                    "image":
                    {
			 required:"編輯康樂棋",
                        accept:"編輯康樂棋"
                    }
                  
                }
            });
        });
  </script>   
