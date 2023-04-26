
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/fav.png">
  <link rel="icon" type="image/png" href="assets/img/fav.png">
  <title>
    Sign Up | CRUD | BOSON
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="assets/css/custom.css?v=0.0.1" rel="stylesheet" />
  <link id="pagestyle" href="assets/css/soft-ui-dashboard.css?v=1.0.3" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-100">

  <section class="">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg" style="background-image: url('assets/img/curved-images/curved14.jpg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-1">Welcome!</h1>
            <p class="text-lead text-white">Sign up to enjoy CRUD operations.</p>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-m10">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
            <div class="card-header text-center p-0">
              <img src="assets/img/logo.png" class="navbar-brand-img h-100" alt="main_logo" style="width: 130px;">
            </div>
            <div class="card-body pt-1">
              <form role="form text-left" id="form1" action="action.php" method="POST">
                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="Name*" aria-label="Name" aria-describedby="email-addon" name="name" value="" minlength="3" maxlength="50">
                </div>
                <div class="mb-3">
                  <input type="email" class="form-control" placeholder="Email*" aria-label="Email" aria-describedby="email-addon" name="email" value="" minlength="3" maxlength="50">
                </div>
                <div class="mb-3">
                  <input type="mobile" class="form-control" placeholder="Mobile No.*" aria-label="Mobile No." aria-describedby="mobile-addon" name="mobile" value="" minlength="10" maxlength="10">
                </div>
                <div class="mb-3">
                  <input type="password" class="form-control" placeholder="Password*" aria-label="Password" aria-describedby="password-addon" name="password" value="" minlength="3" maxlength="20">
                </div> 
                <div class="text-center">
                  <button type="submit" id="submit" class="btn bg-gradient-dark w-100">Sign up</button>
                </div> 
              </form>
              <div class="card-footer text-center pt-0 px-lg-2 px-1">
                <p class="mb-4 text-sm mx-auto">
                  Already have an account? 
                  <a href="sign-in.php" class="text-info text-gradient font-weight-bold">Sign in</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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
    $("#form1").validate({
      rules: {
            name: { required:true }, 
            email: { required:true }, 
            mobile: { required:true, number: 1 }, 
            password: { required:true }
      },
      messages: {
            name: { required:"Enter Name"}, 
            email: { required:"Enter Email"}, 
            mobile: { required:"Enter Mobile No."}, 
            password: { required:"Enter Password"}
      }       
    });//validate
  });
  
  $(document).ready(function (e) {
    $("#form1").on('submit',(function(e) { 
      //alert('#form');//return false;   
      e.preventDefault();

      frmstatus = $("#form1").valid();
      if(frmstatus == true){
        //alert("done")
        $("#submit").attr("disabled", true);
    
        $.ajax({
          url: "action.php?type=register",
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
                  window.location.replace("sign-in.php?id="+data2.id);
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