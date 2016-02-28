{header}
<div class="modal-dialog">
    <div class="modal-content col-md-8">
        <div class="modal-header">
            <h4 class="modal-title"><i class="icon-paragraph-justify2"></i> User Login</h4>
        </div>
		<form method="post" id="login_form">
		  <div class="modal-body with-padding">                             
		    <div class="form-group">
		      <div class="row">
		        <div class="col-sm-10">
		          <label>Username *</label>
		          <input type="text" id="email" name="email" class="form-control required email">
		        </div>
		      </div>
		    </div>
		    <div class="form-group">
		      <div class="row">
		        <div class="col-sm-10">
		          <label>Password *</label>
		          <input type="password" id="password" name="password" class="form-control required" value="">
		        </div>
		      </div>
		    </div> 
		  </div>
		<div class="error" id="logerror"></div> 

		<!-- end Add popup  -->  
		<div class="modal-footer">
		  <input type="hidden" name="id" value="" id="id">
		  <button type="submit" id="btn-login" class="btn btn-primary">Submit</button>              
		</div>
		</form>          
    </div>
</div>
{footer}
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
                           window.location.href = "<?php echo site_url('welcome'); ?>";
                     else  $('#logerror').html('The email or password you entered is incorrect.');
                           $('#logerror').addClass("error");
                   }
               });
             }
        return false;
       });
});
</script>