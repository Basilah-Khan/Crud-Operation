<?php 

  include "config.php";

  $mobileInput = '';
  if (isset($_GET['id'])){
    $id = @$_GET['id'];
    $stmt = $pdo->prepare("SELECT mobile FROM user_info WHERE uid = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch();
    $mobile = @$result['mobile'];
    #echo $mobile;
    if (empty($mobile)) {      
      $mobileInput = '<input type="mobile" class="form-control" placeholder="Mobile No.*" aria-label="mobile" aria-describedby="mobile-addon" name="mobile" value="" minlength="10" maxlength="10">';
    }else{
      $mobileInput = '<input type="mobile" class="form-control" placeholder="Mobile No.*" aria-label="mobile" aria-describedby="mobile-addon" name="mobile" value="'.$mobile.'" readonly>';
    }
  }else{    
    $mobileInput = '<input type="mobile" class="form-control" placeholder="Mobile No.*" aria-label="mobile" aria-describedby="mobile-addon" name="mobile" value="" minlength="10" maxlength="10">';
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/fav.png">
  <link rel="icon" type="image/png" href="assets/img/fav.png">
  <title>
    Sign In | CRUD | BOSON
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/custom.css?v=0.0.1" rel="stylesheet" />
  <link id="pagestyle" href="assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body class="">
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                  <p class="mb-0">Just one last step to enjoy CRUD operations <b>Sign in</b></p>
                </div>
                <div class="card-body">
                  <form role="form" id="form2" action="action.php" method="POST">
                    <div class="mb-3">
                      <?php echo $mobileInput; ?>
                    </div>
                    <div class="mb-3">
                      <input type="password" class="form-control" placeholder="Password*" aria-label="Password" aria-describedby="password-addon" name="password" value="" minlength="3" maxlength="20">
                    </div>                    
                    <div class="text-center mt-3">
                      <button type="submit" id="submit" class="btn bg-gradient-info w-100">Sign in</button>
                    </div>
                  </form>
                  <div class="card-footer text-center pt-0 px-lg-2 px-1">
                    <p class="mb-4 text-sm mx-auto">
                      Don't have an account?
                      <a href="sign-up.php" class="text-info text-gradient font-weight-bold">Sign up</a>
                    </p>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('assets/img/curved-images/curved6.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main> 
  <!--   Core JS Files   -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script> 
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="assets/js/soft-ui-dashboard.min.js?v=1.0.3"></script>
  <!-- My JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="assets/js/jquery.validate.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
<script type="text/javascript">
  $(document).ready(function() {
    $("#form2").validate({
      rules: {
            mobile: { required:true, number: 1 }, 
            password: { required:true }
      },
      messages: {
            mobile: { required:"Enter Mobile No."}, 
            password: { required:"Enter Password"}
      }       
    });//validate
  });
  
  $(document).ready(function (e) {
    $("#form2").on('submit',(function(e) { 
      //alert('#form');//return false;   
      e.preventDefault();

      frmstatus = $("#form2").valid();
      if(frmstatus == true){
        //alert("done")
        //$("#submit").attr("disabled", true);
    
        $.ajax({
          url: "action.php?type=login",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          success: function(data){
              console.log(data)//return false;

              data2 = JSON.parse(data);
              console.log(data2);

              if (data2.status == "success") {
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: data2.message,
                  showConfirmButton: false,
                  timer: 1400
                })

                setTimeout(function (){
                  window.location.replace("list.php");
                },1700);    
              }else{   
                Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: data2.message,
                  showConfirmButton: false,
                  timer: 1400
                })

                $("#submit").attr("disabled", false);       
              }
          },
          error: function(e) {
            //$("#err").html(e).fadeIn();
          }          
        });
      }
    }));
  });
</script>