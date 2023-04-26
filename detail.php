<?php 
$title = 'Vies Customer Detail | ';
include "header.php"; 
$id = @$_GET['id'];
?>

  <main class="main-content">
    <section>
      <div class="page-header">
        <div class="container">
          <h4 class="main-title">Vies Customer Detail</h4>
            <div class="row">
              <div class="col-md-6 mb-3">
                <p>Name: <span id="name"></span></p>
              </div>
              <div class="col-md-6 mb-3">
                <p>Email: <span id="email"></span></p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <p>Mobile No.: <span id="mobile"></span></p>
              </div>
              <div class="col-md-6 mb-3">
                <p>Address: <span id="address"></span></p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <p>Active: <span id="isActive"></span></p>
              </div>
            </div>
            <input type="hidden" name="cid" id="cid" value="<?php echo $id; ?>">
        </div>
      </div>
    </section>
  </main>
      
<?php include "footer.php"; ?>

<script type="text/javascript">
  $(document).ready(function() { 
    id = $("#cid").val();
    $.ajax({
      url: "action.php?type=getCustomer&id="+id,
      type: "POST",
      data: '' ,
      contentType: false,
      cache: false,
      processData:false,
      success: function(data){
          //console.log(data)//return false;

          data2 = JSON.parse(data);
          console.log(data2);

          if (data2.status == "success") {  
              isActive = "";
            if (data2.data.isActive == 'Y') {
              isActive = "Yes ";
            }else{
              isActive = "No";
            }

            $("#isActive").text(isActive);
            $("#address").text(data2.data.address);
            $("#mobile").text(data2.data.mobile);
            $("#email").text(data2.data.email);
            $("#name").text(data2.data.name);
          }else{   
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: data2.message,
              showConfirmButton: false,
              timer: 1400
            })

            setTimeout(function (){
              window.location.replace("list.php");
            },1700);         
          }
      },
      error: function(e) {
        //$("#err").html(e).fadeIn();
      }          
    });
  });
  
</script>