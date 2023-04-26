<?php 
$title = 'Add Customer | ';
include "header.php"; 
?>

  <main class="main-content">
    <section>
      <div class="page-header">
        <div class="container">
          <h4 class="main-title">Add Customer</h4>
          <form role="form text-left" id="form1" action="action.php" method="POST">
            <div class="row">
              <div class="col-md-6 mb-3">
                <input type="text" class="form-control" placeholder="Name*" aria-label="Name" aria-describedby="email-addon" name="name" value="" minlength="3" maxlength="50">
              </div>
              <div class="col-md-6 mb-3">
                <input type="email" class="form-control" placeholder="Email*" aria-label="Email" aria-describedby="email-addon" name="email" value="" minlength="3" maxlength="50">
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                  <input type="mobile" class="form-control" placeholder="Mobile No.*" aria-label="Mobile No." aria-describedby="mobile-addon" name="mobile" value="" minlength="10" maxlength="10">
                  
                  <select class="form-control mt-3" name="isActive">
                    <option value="Y" style="display:none;">Active*</option>
                    <option value="Y">Yes</option>
                    <option value="Y">No</option>
                  </select>
              </div>
              <div class="col-md-6 mb-3">
                  <textarea class="form-control" placeholder="Address" maxlength="200" name="address" rows="4"></textarea>
              </div>
            </div>
            <div class="col-md-12 text-center">
              <button type="submit" id="submit" class="btn bg-gradient-dark w-30">Sign up</button>
            </div> 
          </form>
        </div>
      </div>
    </section>
  </main>
      
<?php include "footer.php"; ?>

<script type="text/javascript">
  $(document).ready(function() {
    $("#form1").validate({
      rules: {
            name: { required:true }, 
            email: { required:true }, 
            mobile: { required:true, number: 1 }
      },
      messages: {
            name: { required:"Enter Name"}, 
            email: { required:"Enter Email"}, 
            mobile: { required:"Enter Mobile No."}
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
          url: "action.php?type=addCustomer",
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