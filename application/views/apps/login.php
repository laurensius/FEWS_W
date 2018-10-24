
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>FEWS</title>
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/signin.css'); ?>" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/ie10.js'); ?>"></script>
  </head>
  <body>
    <div class="container">

    <form action="javascript:;" class="form-signin" method="post" id="form_daftar">
      <h2 class="form-signin-heading">Signin</h2>
      <label for="inputEmail" class="sr-only">Username</label>
      <input type="text" id="username" class="form-control" placeholder="Username" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="password" class="form-control" placeholder="Password" required>
      <input class="btn btn-primary form-control" type="submit" value="Signin" id="signin">
    </form>

    </div> <!-- /container -->

    <script>
    function signin(){
        var username = document.getElementById("username").value;
        var password = document.getElementById("password").value;
        var post = {
            "password" : password,
            "username" : username,
        };
        $.ajax({
            url : '<?php echo site_url("/api/admin_login"); ?>'  ,
            type : 'POST',
            dataType : 'json',
            data: post,
            success : function(response){
                if(response.severity == "success"){
                    alert(response.message);
                    window.location = '<?php echo site_url("/apps/dashboard/"); ?>';
                }else{
                    alert(response.message);
                    window.location = '<?php echo site_url("/apps/login/"); ?>';
                }
            },
            error : function(response){
                alert("Server Error");
            },
        });
    }

     $("#signin").click(signin);
    </script>
  </body>
</html>
