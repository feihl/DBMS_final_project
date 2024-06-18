<?php include('include/db_connect.php');?>
<?php if ($_SESSION['login_access'] != '1') { 
    include('error.php');
}?>
<div class="pagetitle">
    <h1>Users</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../basicRental_bbb/index.php">Home</a></li>
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
                    <h5 class="card-title">Add Staff</h5>
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
                        <div class="row">
                          <div class="col-6">
                            <label for="yourUsername" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                            <div class="invalid-feedback">Please choose a username.</div>
                        </div>
                        <div class="col-6">
                            <label for="yourPassword" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                            <div class="invalid-feedback">Please enter your password!</div>
                        </div>
                    </div>

                        <div class="row">
                          <div class="col-6">
                        </div>
                        <div class="col-6" id="acc">
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
                         $data = $conn->query("SELECT * FROM tbl_user_information order by id asc");
                         while($row=$data->fetch_assoc()):
                            ?>
                            <?php 
                            $user_account = $conn->query("SELECT * FROM user_account WHERE `id`= " . $row['user_account_id']);
                            if ($user_account) {
                                $row_about = $user_account->fetch_assoc();
                                ?>
                                <tr>
                                    <td class="text-center" ><?php echo $i++ ?></td>
                                    <td class="">
                                        <?php
                                            $fullName = "";
                                            if (!empty($row['fName'])) {
                                                $fullName .= $row['fName'];
                                            }
                                            if (!empty($row['mName'])) {
                                                $fullName .= " " . $row['mName'][0] . ".";
                                            }
                                            if (!empty($row['lName'])) {
                                                $fullName .= " " . $row['lName'];
                                            }
                                            if (!empty($fullName)) {
                                                echo "<p><b>" . ucwords($fullName) . "</b></p>";
                                            }
                                        ?>
                                            <?php
                                            /*
                                            echo "<p><b>".ucwords($row['fName']." ".$row['mName'][0].". ".$row['lName'])."</b></p>";
                                            */
                                            ?>
                                    </td>
                                    <td class="">
                                        <p><b><?php echo $row['contactNo'] ?></b></p>
                                    </td>
                                    <td class="text-center">
                                        <button id="edit" class="btn btn-sm btn-primary" type="button" 
                                        data-id="<?php echo $row['user_account_id'] ?>"
                                        data-fName="<?php echo $row['fName'] ?>"
                                        data-mName="<?php echo $row['mName'] ?>"
                                        data-lName="<?php echo $row['lName'] ?>"
                                        data-contactNo="<?php echo $row['contactNo'] ?>"
                                        data-address="<?php echo $row['address'] ?>"
                                        data-email="<?php echo $row['email'] ?>"
                                        data-username="<?php echo $row_about['username'] ?>"
                                        data-password="<?php echo $row_about['password'] ?>"
                                    <?php }?>
                                    >Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick="delete_customer('<?php echo $row['user_account_id'] ?>')" type="button" >Delete</button>

                                    <button class="btn btn-sm btn-warning" id="role" type="button" 
                                    data-id="<?php echo $row_about['id'] ?>"
                                    data-access="<?php echo $row_about['access'] ?>"


                                    >Role</button>
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

              <div class="modal fade" id="smallModal" tabindex="-1">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Update Role</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="access-id" id="access-id">
                      <select class="form-select" name="access-val" id="access-val">
                          <option value="0">No role</option>
                          <option value="1">Administrator</option>
                          <option value="2">Staff</option>
                      </select>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary" id="sub_btn">Save changes</button>
                    </div>

                  </div>
                </div>
              </div><!-- End Small Modal-->


<script type="text/javascript">
    $('#manage-customer').submit(function(e){
        var id = document.getElementsByName('id');
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
            url:'ajax.php?action=save_user',
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

          else if(resp==14){
           $('#authority_problem').modal('show');
              var duration = 2000; // 3 seconds
              setTimeout(function() {
                $('#authority_problem').modal('hide');
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
       cat.find("[name='username']").val($(this).attr('data-username'))
       cat.find("[name='password']").val($(this).attr('data-password'))
   });
    $(document).on("click","#delete_customer", function(e){
     _conf("Are you sure to delete this category?","delete_customer",[$(this).attr('data-id')])
 });
    function delete_customer($id){
        $.ajax({
         url:'ajax.php?action=delete_user',
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
          else if(resp==14){
           $('#authority_problem').modal('show');
              var duration = 2000; // 3 seconds
              setTimeout(function() {
                $('#authority_problem').modal('hide');
                location.reload()
            }, duration);
          }
      }
  })
    }
</script>


<script type="text/javascript">
$(document).on("click","#role", function(e){


var id = $(this).data("id");
var access = $(this).data("access");
$('#access-id').val(id);
$('#access-val').val(access);
$("#smallModal").modal("show");
     })

$(document).on("click", "#sub_btn", function(e) {
    e.preventDefault();

    var role_id = $('#access-id').val();
    var role_sel = $('#access-val').val();

    var requestData = {
        id: role_id,
        access: role_sel
    };

    $.ajax({
        url: 'ajax.php?action=update_role',
        data: JSON.stringify(requestData),
        cache: false,
        contentType: 'application/json',
        method: 'POST',
        dataType: 'json',
        success: function(resp) {
            if (resp == 1) {
                $('#success_add').modal('show');
                var duration = 3000; // 3 seconds
                setTimeout(function() {
                    $('#success_add').modal('hide');
                    location.reload();
                }, duration);
            } else if (resp == 2) {
                $('#success_update').modal('show');
                var duration = 3000; // 3 seconds
                setTimeout(function() {
                    $('#success_update').modal('hide');
                    location.reload();
                }, duration);
            }
            else if(resp==14){
           $('#authority_problem').modal('show');
              var duration = 2000; // 3 seconds
              setTimeout(function() {
                $('#authority_problem').modal('hide');
                location.reload()
            }, duration);
          }
        }
    });
});







</script>


