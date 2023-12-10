
<!DOCTYPE html>
<html lang="en">
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="msapplication-tap-highlight" content="no">
      <meta name="description" content="">
      <meta name="keywords" content="">
      <title>Welcome to <?php echo CGS; ?></title>
      <!-- CORE CSS-->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
      <link href="<?php echo base_url('assets/css/materialize.min.css'); ?>" type="text/css" rel="stylesheet" media="screen,projection">
      <link href="<?php echo base_url('assets/css/style.min.css'); ?>" type="text/css" rel="stylesheet" media="screen,projection">
  </head>
  <body>
    <!-- Start Page Loading -->
    <div id="loader-wrapper" style="display:none;">
        <div id="loader"></div>        
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <!-- End Page Loading -->

    <div id="login-page" class="row">
      <div class="col s12 z-depth-4 card-panel">
        <form class="login-form">
          <div class="row">
            <div class="input-field col s12 center">
              <p class="center login-form-text"><?php echo CGS; ?></p>
            </div>
          </div>
          <div class="row margin">
            <div class="input-field col s12">
              <i class="material-icons prefix" style="margin-top:12px;">account_circle</i>
              <input id="username" type="text" name="username" class="validate-data" autofocus />
              <label for="username" class="center-align">Username</label>
            </div>
          </div>
          <div class="row margin">
            <div class="input-field col s12">
              <i class="material-icons prefix" style="margin-top:12px;">lock</i>
              <input id="password" type="password" name="password" class="validate-data" />
              <label for="password">Password</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <a href="javascript:;" class="btn waves-effect waves-light col s12 login-btn">Login</a>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Modal Structure -->
    <div id="alert-model" class="modal">
            <div class="modal-content">
                    <h4><?php echo CGS; ?></h4>
                    <p class="alert-text"></p>
            </div>
            <div class="modal-footer">
                    <a href="javascript:;" class="modal-action modal-close waves-effect waves-green btn-flat">OK</a>
            </div>
    </div>
    <!-- jQuery Library -->
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery-3.2.1.min.js'); ?>"></script>
    <!--materialize js-->
    <script type="text/javascript" src="<?php echo base_url('assets/js/materialize.min.js'); ?>"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        var base_url = '<?php echo base_url(); ?>';
        $('#alert-model').modal();

        $('.validate-data').on('keydown',function(e){
          if(e.keyCode == 13){
            $('.login-btn').trigger('click');
          }
        });

        $(document).on("click",".login-btn",function(){	
				  var quest_link = "";
					var err_array = new Array();
          $('.validate-data').each(function(){
            var current_name = $(this).attr('name');
            switch(current_name){
              case 'password':
              case 'username':
                if ($.trim($(this).val()).length == 0){
                  $(this).css('border-bottom','1px solid red'); 
                  err_array.push('password');
                }else{
                  $(this).css('border-bottom','1px solid #9e9e9e'); 
                }
              break;
            }
          });

          if(err_array.length ==0){
            $.ajax({
              type:'post',
              url:base_url+'Login/validate_login',
              data:{
                user_name:$.trim($('input[name="username"]').val()),
                pwd:$.trim($('input[name="password"]').val())
              },
              dataType:'json',
              success:function(val){
                if($.trim(val) == "success"){
                  location.href = base_url+'generate-bill';
                }else{
                  $(".alert-text").text(val);
                  $('#alert-model').modal('open');
                }
              }
            });
          }
        });
      });
    </script>
  </body>
</html>