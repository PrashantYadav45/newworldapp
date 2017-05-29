<?php  if($this->request->params['controller'] == 'Api'){
   echo "Invalid Url";die;
}else{?>
<!DOCTYPE HTML>
<html>
<head>
<title>404 error page</title>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script> -->
<!-- <link href="css/404style.css" rel="stylesheet" type="text/css" media="all" /> -->
<?php echo $this->Html->css('404style.css') ?>
</head>
<body>
   
    <div class="wrap">
       
        <div class="content">
           
            <div class="logo">
                <h1><a href="#"><img src=<?php echo HTTP_ROOT.'images/logo.png' ?> ></a></h1>
                <span><img src=<?php echo HTTP_ROOT.'images/signal.png' ?> >Oops! The Page you requested was not found!</span>
            </div>
            
            
            <div class="buttom">
                <div class="seach_bar">
                    <p>you can go to <span><a href="<?= HTTP_ROOT ?>users">home</a></span> page </p>
                    
                    <!-- <div class="search_box">
                    <form>
                       <input type="text" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}"><input type="submit" value="">
                    </form>
                     </div> -->
                </div>
            </div>
            
        </div>
       
    </div>
    
    <!---------end-wrap---------->
</body>
</html>
<?php } ?>