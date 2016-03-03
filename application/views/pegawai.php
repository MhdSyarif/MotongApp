        
        <?php  echo link_tag('assets/plugins/bootstrap/bootstrap-datetimepicker.css'); ?>
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
        .glyphicon-chevron-left:before {
           content: "<<";
        }
        .glyphicon-chevron-right:before {
           content: ">>";
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
                                            <div class="col-sm-3">
                                                <input class="form-control required date" type="text" id="tgl_lahir" name="tgl_lahir" placeholder="Enter Date Birth">
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
                            </div>
                        </div>
                    </div>
                </div>
                     <!-- End Form Elements -->
                    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap/moment.js"></script>
                    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/jquery.validate.min.js"></script>
                    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap-datetimepicker.js"></script>
                    <script>  
                    $(function () {
                        $('#tgl_lahir').datetimepicker({
                            viewMode: 'years',
                            format: 'DD/MM/YYYY'
                        });
                    });
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