<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>New World App</title>   
	
	<?php echo $this->Html->css(['bootstrap.min.css', 'sb-admin.css', 'font-awesome/css/font-awesome.min.css','jquery-ui.css','ui.theme.css','bootstrap-datetimepicker.min.css']);?>	
    <?php echo $this->Html->script(['jquery-1.12.0.min.js','ckeditor/ckeditor.js', 'bootstrap.min.js','jquery.validate.js','jquery-ui.js','moment-with-locales.js','bootstrap-datetimepicker.min.js','bootstrap-datetimepicker.js']);?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>   
    
    <?=$this->fetch('content');?>
    <!-- /#wrapper -->
    <!-- jQuery -->

</body>

</html>
