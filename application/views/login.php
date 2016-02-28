<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motong App</title>
    <!-- Core CSS - Include with every page -->
    <?php  echo link_tag('assets/plugins/bootstrap/bootstrap.css'); ?>
    <?php  echo link_tag('assets/font-awesome/css/font-awesome.css'); ?>
   </head>
    <style type="text/css">
    body{
        background: url(assets/img/bg.jpg) no-repeat fixed center bottom / cover transparent;
        height: 100%;
        width: 100%;
    }
    .logo-margin {
    margin-top: 80px;
    margin-bottom: 50px;
    }
    .error{
        margin-top: 6px;
        margin-bottom: 0;
        color: #D65C4F;
        /*background-color: #D65C4F;*/
        display: table;
        padding: 5px 8px;
        font-size: 11px;
        font-weight: 600;
        line-height: 14px;
    }
    .panel-login {
      margin-bottom: 20px;
      background-color: transparent;
      border: 2px solid #fff;
      border-radius: 4px;
      -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
              box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
    }
    </style>
    <body class="body-Login-back">

        <div class="container">
           
            <div class="row">
                <div class="col-md-4 col-md-offset-4 text-center logo-margin ">
                  <img src="assets/img/syarif-logo.png" alt=""/>
                    </div>
                <div class="col-md-4 col-md-offset-4">
                    <div class="login-panel panel-login panel-default">                  
                        <div class="panel-heading">
                            <h3 class="panel-title">Please Sign In</h3>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" id="login_form">
                                <fieldset>
                                    <label for="">Email *</label>
                                    <div class="form-group">
                                       <input type="text" id="email" name="email" class="form-control required email">
                                    </div>
                                    <label for="">Password *</label>
                                    <div class="form-group">
                                        <input type="password" id="password" name="password" class="form-control required" value="">
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                        </label>
                                    </div>
                                    <div class="error" id="logerror"></div> 
                                    <!-- Change this to a button or input when using this as a form -->
                                    <input type="hidden" name="id" value="" id="id">
                                    <button type="submit" id="btn-login" class="btn btn-lg btn-success btn-block">Login</button> 
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery.validate.min.js"></script>
<script>  
  $(document).ready(function(){
    $('#login_form').validate();   
    $(document).on('click','#btn-login',function(){
      var url = "<?php echo site_url('login/user_login');?>";       
        if($('#login_form').valid()){
          $('#logerror').html('<?php echo img('assets/img/ajax.gif') ?> Please wait...');  
          $.ajax({
            type: "POST",
              url: url,
               data: $("#login_form").serialize(), // serializes the form's elements.
                 success: function(data)
                   {
                     if(data==1)              
                           window.location.href = "<?php echo base_url(); ?>";
                     else  $('#logerror').html('The email or password you entered is incorrect.');
                           $('#logerror').addClass("error");
                   }
               });
             }
        return false;
       });
});
</script>