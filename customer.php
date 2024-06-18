<?php include('include/db_connect.php');?>
<?php if ($_SESSION['login_access'] == '0') { 
    include('error.php');
}?>
<div class="pagetitle">
    <h1>Customer</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../basicRental/index.php">Home</a></li>
            <li class="breadcrumb-item active">Customers</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Tenants</h5>
                    <form action="" id="manage-customer" class="row g-3 needs-validation" novalidate>
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="col-4">
                                <label class="form-label"for="fName">First Name:</label>
                                <input class="form-control" type="text" name="fName" required>
                                <div class="invalid-feedback">Please enter a valid Values!</div>
                            </div>
                            <div class="col-4">
                                <label class="form-label"for="mName">Middle Name:</label>
                                <input class="form-control" type="text" id="mName" name="mName">
                                <div class="invalid-feedback">Please enter a valid Values!</div>
                            </div>
                            <div class="col-4">
                                <label class="form-label"for="lName">Last Name:</label>
                                <input class="form-control" type="text" id="lName" name="lName" required>
                                <div class="invalid-feedback">Please enter a valid Values!</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label"for="address">Address:</label>
                            <textarea class="form-control" type="text" name="address" style="resize: none;" required></textarea>
                            <div class="invalid-feedback">Please enter a valid Values!</div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label"for="contactNo">Contact No:</label>
                                <input class="form-control" type="text"  name="contactNo" required>
                                <div class="invalid-feedback">Please enter a valid Values!</div>
                            </div>
                            <div class="col-6">
                                <label class="form-label"for="email">Email:</label>
                                <input class="form-control" type="email" name="email" required>
                                <div class="invalid-feedback">Please enter a valid Values!</div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-md-12">
                                <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Left side columns -->
        <!-- Right side columns -->
        <div class="col-lg-7">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Customer List</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Contact No.</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             <?php 
                             $i = 1;
                             $data = $conn->query("SELECT * FROM tbl_customer_info order by id asc");
                             while($row=$data->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center" ><?php echo $i++ ?></td>
                                    <td class="">
                                        <p><b><?php echo ucwords($row['fName']." ".$row['mName'][0].". ".$row['lName']) ?></b></p>
                                    </td>
                                    <td class="">
                                        <p><b><?php echo $row['contactNo'] ?></b></p>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-primary" id="edit" type="button" 
                                        data-id="<?php echo $row['id'] ?>"
                                        data-fName="<?php echo $row['fName'] ?>"
                                        data-mName="<?php echo $row['mName'] ?>"
                                        data-lName="<?php echo $row['lName'] ?>"
                                        data-contactNo="<?php echo $row['contactNo'] ?>"
                                        data-address="<?php echo $row['address'] ?>"
                                        data-email="<?php echo $row['email'] ?>">Edit</button>
                                        <button class="btn btn-sm btn-danger" id="delete_customer" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Right side columns -->
</div>
</section>
<script type="text/javascript">
    $('#manage-customer').submit(function(e){

var form = document.getElementById('manage-customer');
var lNameInput = document.getElementsByName('lName');
var fNameInput = document.getElementsByName('fName');
var mNameInput = document.getElementsByName('mName');
var addressInput = document.getElementsByName('address')[0];
var contactNoInput = document.getElementsByName('contactNo')[0];
var emailInput = document.getElementsByName('email')[0];

if (lNameInput.value == '' || fNameInput.value == '' ||
    mNameInput.value == '' || addressInput.value == '' ||
    contactNoInput.value == '' || emailInput.value == '') {

    alert("Some field are Empty!!")

}else{
        e.preventDefault()
        $.ajax({
            url:'ajax.php?action=save_customer',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                if(resp==1){
                    $('#success_add').modal('show');
              var duration = 3000; // 3 seconds
              setTimeout(function() {
                $('#success_add').modal('hide');
                location.reload()
            }, duration);
          }
          else if(resp==2){
            $('#success_update').modal('show');
              var duration = 3000; // 3 seconds
              setTimeout(function() {
                $('#success_update').modal('hide');
                location.reload()
            }, duration);
          }
      }
  })}
    });
    $(document).on("click","#edit", function(e){
       var cat = $('#manage-customer')
       cat.get(0).reset()
       cat.find("[name='id']").val($(this).attr('data-id'))
       cat.find("[name='fName']").val($(this).attr('data-fName'))
       cat.find("[name='mName']").val($(this).attr('data-mName'))
       cat.find("[name='lName']").val($(this).attr('data-lName'))
       cat.find("[name='contactNo']").val($(this).attr('data-contactNo'))
       cat.find("[name='email']").val($(this).attr('data-email'))
       cat.find("[name='address']").val($(this).attr('data-address'))
   });
 
    $(document).on("click","#delete_customer", function(e){
     _conf("Are you sure to delete this category?","delete_customer",[$(this).attr('data-id')])
 });
    function delete_customer($id){
        $.ajax({
         url:'ajax.php?action=del_customer',
         method:'POST',
         data:{id:$id},
         success:function(resp){
            if(resp==1){
             $('#success_delete').modal('show');
              var duration = 3000; // 3 seconds
              setTimeout(function() {
                $('#success_delete').modal('hide');
                location.reload()
            }, duration);
          }
      }
  })
    }
</script>
