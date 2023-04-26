<?php 
$title = 'Customer List | ';
$dataTablesLink = ' <link id="pagestyle" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />   ';
include "header.php"; 
?>

  <main class="main-content">
    <section>
      <div class="page-header">
        <div class="container">
          <h3> <?php echo "Welcome $userName"; ?></h3>
          <h4> Customer List</h4>
          <table id="example" class="display nowrap" style="width:100%">
            <thead>
              <tr>
                <th>Entry Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No.</th>
                <th>Address</th>
                <th>Active</th>
                <th></th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>Entry Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile No.</th>
                <th>Address</th>
                <th>Active</th>
                <th></th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </section>
  </main>
      
<?php include "footer.php"; ?>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">  
  $(document).ready(function () {
    $('#example').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        language: {
          searchPlaceholder: "Search records"
        },
        ajax: {
            url: 'list-ajax.php',
            type: 'POST',
        },
        columns: [
            { data: 'edate' },
            { data: 'name' },
            { data: 'email' },
            { data: 'mobile' },
            { data: 'address' },
            { data: 'isActive' },
            { data: 'btns' },
        ],
        "order": [[1, "asc"]],
        'columnDefs': [ {
          'targets': [0,5,6], // column index (start from 0)
          'orderable': false, // set orderable false for selected columns
        }]
    });
  });

  function detail(id){
    Swal.fire({
      title: 'Do you want to delete the this customer details?',
      showDenyButton: true,
      showCancelButton: false,
      confirmButtonText: 'Yes, delete it ',
      denyButtonText: `Don't delete it`,
    }).then((result) => {
      /* Read more about isConfirmed, isDenied below */
      if (result.isConfirmed) {
        $.ajax({
          url: "action.php?type=deleteCustomer&id="+id,
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
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: data2.message,
                  showConfirmButton: false,
                  timer: 1400
                })
              }else{   
                Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: data2.message,
                  showConfirmButton: false,
                  timer: 1400
                })       
              }

              setTimeout(function (){
                window.location.reload();
              },1700);  
          },
          error: function(e) {
            //$("#err").html(e).fadeIn();
          }          
        });
      } else if (result.isDenied) {
        Swal.fire('Customer detail is safe', '', 'info')
      }
    })
    
  }
</script>
