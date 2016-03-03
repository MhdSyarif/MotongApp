        <style>
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
        </style>
        <!--  page-wrapper -->
          <div id="page-wrapper">
            <div class="row">
                 <!-- page header -->
                <div class="col-lg-8">
                    <h1 class="page-header">Pegawai</h1>
                </div>
                <!--end page header -->
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Register
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <form role="form" method="post" id="register_form">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 form-control-label">Number KTP</label>
                                            <div class="col-sm-6">
                                                <input class="form-control required number" maxlength="16" type="text" id="no_ktp" name="no_ktp" placeholder="Enter Num KTP">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 form-control-label">Name</label>
                                            <div class="col-sm-6">
                                                <input class="form-control required" type="text" id="nama" name="nama" placeholder="Enter Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 form-control-label">Place Birth</label>
                                            <div class="col-sm-6">
                                                <input class="form-control required" type="text" id="tempat_lahir" name="tempat_lahir" placeholder="Enter Place Birth">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 form-control-label">Date Birth</label>
                                            <div class="col-sm-6">
                                                <input class="form-control required" type="text" id="tgl_lahir" name="tgl_lahir" placeholder="Enter Date Birth">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <button type="submit" id="btn-register" class="btn btn-primary">Register</button>
                                                <button type="reset" class="btn btn-success">Reset Button</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- <div class="col-lg-6">
                                    <h1>Disabled Form States</h1>
                                    <form role="form">
                                        <fieldset disabled="disabled">
                                            <div class="form-group">
                                                <label for="disabledSelect">Disabled input</label>
                                                <input class="form-control" id="disabledInput" type="text" placeholder="Disabled input" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="disabledSelect">Disabled select menu</label>
                                                <select id="disabledSelect" class="form-control">
                                                    <option>Disabled select</option>
                                                </select>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox">Disabled Checkbox
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Disabled Button</button>
                                        </fieldset>
                                    </form>
                                    <h1>Form Validation States</h1>
                                    <form role="form">
                                        <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">Input with success</label>
                                            <input type="text" class="form-control" id="inputSuccess">
                                        </div>
                                        <div class="form-group has-warning">
                                            <label class="control-label" for="inputWarning">Input with warning</label>
                                            <input type="text" class="form-control" id="inputWarning">
                                        </div>
                                        <div class="form-group has-error">
                                            <label class="control-label" for="inputError">Input with error</label>
                                            <input type="text" class="form-control" id="inputError">
                                        </div>
                                    </form>
                                    <h1>Input Groups</h1>
                                    <form role="form">
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">@</span>
                                            <input type="text" class="form-control" placeholder="Username">
                                        </div>
                                        <div class="form-group input-group">
                                            <input type="text" class="form-control">
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-eur"></i>
                                            </span>
                                            <input type="text" class="form-control" placeholder="Font Awesome Icon">
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon">$</span>
                                            <input type="text" class="form-control">
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                        <div class="form-group input-group">
                                            <input type="text" class="form-control">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button"><i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </form> -->
                                </div>
                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
                    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery.validate.min.js"></script>
                    <script>  
                      $(document).ready(function(){
                        $('#register_form').validate();
                        $(document).on('click','#btn-register',function(){
                          var url = "<?php echo site_url('login/user_login');?>";       
                            if($('#login_form').valid()){
                              $('#logerror').html('<?php echo img('assets/img/ajax.gif') ?> Please wait...');  
                              $.ajax({
                                type: "POST",
                                  url: url,
                                   data: $("#register_form").serialize(), // serializes the form's elements.
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