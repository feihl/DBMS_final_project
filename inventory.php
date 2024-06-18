<?php include('include/db_connect.php');?>
<?php 
$query = $conn->query("SELECT * FROM tbl_movie_inventory_info");
if ($query->num_rows == 0) {?>
  <script type="text/javascript"> window.location.href = 'index.php?page=movies';</script>
  <?php   exit();
}
?>
<?php if ($_SESSION['login_access'] != '1' || $_SESSION['login_access'] == '0') { 
    include('error.php');
}?>
<div class="pagetitle">
    <h1>Inventory</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../basicRental/index.php">Home</a></li>
            <li class="breadcrumb-item">Movies</li>
            <li class="breadcrumb-item active">Inventory</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Inventory</h5>
                    <form action="" id="manage-inventory" class="row g-3 needs-validation" novalidate>
                        <input type="hidden" name="id">
                        <input type="hidden" name="available">
                        <div class="col-12">
                            <label for="price">Price:</label>
                            <input class="form-control" type="number" id="price" name="price" min="0" required><br>
                        </div>
                        <div class="col-12">
                            <label for="quantity">Penalty:</label>
                            <input class="form-control" type="number" id="penalty" name="penalty" min="0"required><br>
                        </div>
                        <div class="col-12">
                            <label for="quantity">Stock Quantity:</label>
                            <input class="form-control" type="number" id="quantity" name="quantity" min="0"required><br>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                                    <button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-inventory').get(0).reset()"> Cancel</button>
                                </div>
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
                        <h5 class="card-title">Genre List</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Movie Title</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Penalty</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Available</th>
                                    <th scope="col">Borrowed</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $mov_info = $conn->query("SELECT * FROM tbl_movie_inventory_info ORDER BY tbl_movie_info_id ASC");
                                while ($row = $mov_info->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $i++ ?></td>
                                        <?php 
                                        $data_about = $conn->query("SELECT * FROM tbl_movie_info WHERE `id` = " . $row['tbl_movie_info_id']);
                                        if ($data_about) {
                                            $row_about = $data_about->fetch_assoc();
                                            ?>
                                            <td class=""><p><b><?php echo $row_about['title'] ?></b></p></td>
                                            <?php
                                        }
                                        ?>
                                        <td class=""><p><b><?php echo $row['price'] ?></b></p></td>
                                        <td class=""><p><b><?php echo $row['penalty'] ?></b></p></td>
                                        <td class=""><p><b><?php echo $row['qty'] ?></b></p></td>
                                        <?php 
                                        $data_about2 = $conn->query("SELECT SUM(requestedQty) AS totalRequestedQty FROM tbl_rents_info WHERE `status` = 'RENTED' AND `tbl_movie_info_id` = " . $row['tbl_movie_info_id']);
                                        if ($data_about2) {
                                            $row_about2 = $data_about2->fetch_assoc();
                                            $totalRequestedQty = $row_about2['totalRequestedQty'];
                                        } else {
                                            $totalRequestedQty = 0;
                                        }
                                        $available = intval($row['available']) - intval($totalRequestedQty);
                                        ?>
                                        <td class=""><p><b><?php echo  $available?></b></p></td>
                                        <td class=""><p><b><?php echo $totalRequestedQty ?></b></p></td>
                                        <td class="text-center">
                                            <button id="edit" class="btn btn-sm btn-primary" type="button" 
                                            data-id="<?php echo $row['id'] ?>" 
                                            data-price="<?php echo $row['price'] ?>" 
                                            data-qty="<?php echo $row['qty'] ?>" 
                                            data-available="<?php echo $row['available'] ?>"
                                            data-borrowed="<?php echo $row['borrowed'] ?>"
                                            data-penalty="<?php echo $row['penalty'] ?>"
                                            >Edit</button>
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
    $('#manage-inventory').submit(function(e){
        e.preventDefault()
        $.ajax({
            url:'ajax.php?action=save_inventory',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success:function(resp){
                if(resp==1){
                 $('#success_update').modal('show');
              var duration = 3000; // 3 seconds
              setTimeout(function() {
                $('#success_update').modal('hide');
                location.reload()
            }, duration);
          }
          else{
             $('#authority_problem').modal('show');
              var duration = 2000; // 3 seconds
              setTimeout(function() {
                $('#authority_problem').modal('hide');
                location.reload()
            }, duration);
          }
      }})
    });
    $(document).on("click","#edit", function(e){
        var cat = $('#manage-inventory')
        cat.find("[name='id']").val($(this).attr('data-id'))
        cat.find("[name='price']").val($(this).attr('data-price'))
        cat.find("[name='quantity']").val($(this).attr('data-qty'))
        cat.find("[name='available']").val($(this).attr('data-available'))
        cat.find("[name='borrowed']").val($(this).attr('data-borrowed'))
        cat.find("[name='penalty']").val($(this).attr('data-penalty'))
    });
</script>
