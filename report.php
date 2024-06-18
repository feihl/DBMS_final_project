<?php if ($_SESSION['login_access'] == '0') { 
  include('error.php');
}?>
<?php include('include/db_connect.php'); ?>
<style>
  .on-print {
    display: none;
  }
</style>
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="../basicRental/index.php">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->
<section class="section">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
        </div>
        <div class="card-body">
          <h5 class="card-title">Report</h5>
          <!-- Table with stripped rows -->
          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col" class="text-center">Barcode</th>
                <th scope="col" class="text-center">Customer</th>
                <th scope="col" class="text-center">Rented Info</th>
                <th scope="col" class="text-center">Penalty Info</th>
                <th scope="col" class="text-center">Remark</th>
                <th scope="col" class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              $data = $conn->query("SELECT * FROM tbl_rents_info ORDER BY created_at DESC");
              while ($row = $data->fetch_assoc()):
                ?>
                <tr>
                  <td class="text-center"><?php echo $i++ ?></td>
                  <td class="text-center">
                    <?php echo $row['genereratedCode'] ?>
                  </td>
                  <td class="text-center">
                    <?php
                    $data_about = $conn->query("SELECT * FROM tbl_customer_info WHERE `id` =" . $row['tbl_customer_info_id']);
                    if ($data_about && $row_cust = $data_about->fetch_assoc()) {
                      echo ucwords($row_cust['fName']." ".$row_cust['mName'][0].". ".$row_cust['lName']);
                    }
                    else {
                      echo "YOU DELETED THE CUSTOMER";
                    }
                    ?>
                  </td>
                  <td class="text-center">
                    <?php 
                    $data3 = $conn->query("SELECT * FROM tbl_movie_info 
                      JOIN tbl_movie_inventory_info 
                      ON tbl_movie_inventory_info.tbl_movie_info_id = tbl_movie_info.id 
                      WHERE tbl_movie_info.id = " . $row['tbl_movie_info_id']);

                    while($row3=$data3->fetch_assoc()):
                      ?>
                      <p style="margin: 0; padding: 0;">Date Movie: <b><?php echo $row3['title'] ?></b></p>
                      <p style="margin: 0; padding: 0;">Date Rented: <b><?php echo $row['requestedDate'] ?></b></p>
                      <p style="margin: 0; padding: 0;">Date Return: <b><?php echo $row['returnDate'] ?></b></p>
                      <p style="margin: 0; padding: 0;">Quantity: <b><?php echo $row['requestedQty'] ?></b></p>
                      <p style="margin: 0; padding: 0;">Price: <b><?php echo $row['requestedAmount'] ?></b></p>
                    </td>

                    <td class="text-center">
                      <?php 
                      $data4 = $conn->query("SELECT * FROM penalty WHERE `receipt_no` = '" . $row['genereratedCode'] . "'");

                      while($row4=$data4->fetch_assoc()):
                        if (isset($row4)) { ?>
                       <p style="margin: 0; padding: 0;">Overdate?: <b><?php echo $row4['days_penalty'] ?></b></p>
                      <p style="margin: 0; padding: 0;">Penalty Price: <b><?php echo $row4['penalty_price'] ?></b></p>
                    
                        <?php }
                        ?>
                         <?php endwhile; ?>



                      </td>

                      <td class="text-center"><?php echo $row['status'] ?></td>
                      <td class="text-center">
                        <button class="btn btn-sm btn-warning print" type="button" 
                        data-id="<?php echo $row['id'] ?>"
                        data-ids="<?php echo $row['tbl_customer_info_id'] ?>"  
                        data-reqd="<?php echo $row['requestedDate'] ?>" 
                        data-retd="<?php echo $row['returnDate'] ?>" 
                        data-reqqty="<?php echo $row['requestedQty'] ?>" 
                        data-amt="<?php echo $row['requestedAmount'] ?>"
                        >Print</button>
                        <?php if ($row['status'] == 'RENTED') { ?>
                          <button class="btn btn-sm btn-info" type="button" 
                          data-id="<?php echo $row['id'] ?>" onclick="bumalik('<?php echo $row['id']."|".$row['returnDate']."|".$row3['penalty']."|".$row['genereratedCode']?>')"
                          >Returned</button>
                        <?php } ?>

                      </td>
                    </tr>
                 
                <?php endwhile; ?>
              <?php endwhile; ?>
            </tbody>
          </table>
          <!-- End Table with stripped rows -->
        </div>
      </div>
    </div>
  </div>
</div>
</section>



<div class="modal fade" id="penalty" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">PENALTY CARD</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="ids">
        <p style="margin: 0; padding: 0;"><b>Receipt no: </b><span id="rno"></span></p>
        <p style="margin: 0; padding: 0;"><b>No. of Days: </b><span id="noD"></span></p>
        <p style="margin: 0; padding: 0;"><b>Penalty Percent: </b>₱ <span id="pp"></span></p>
        <p style="margin: 0; padding: 0;"><b>Total Penalty Amount: </b>₱ <span id="tpa"></span></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" onclick="penalRetrun()">Return</button>
      </div>

    </div>
  </div>
</div><!-- End Basic Modal-->

<script type="text/javascript">
  $(document).ready(function() {
    $('.print').click(function() {
      var rowId = $(this).data('id');
      var reqdate = $(this).data('reqd');
      var retdate = $(this).data('retd');
      var reqqty = $(this).data('reqqty');
      var reqamount = $(this).data("amt");
      // var barcode = $('#barcode_' + rowId).text();
      // var customer = $('#customer_' + rowId).text();
      var rentedInfo = $('#rented_info_' + 'rowId').html();
      var _style = $('noscript').clone();
      var _content = $('<div>')
      .append($('<p>').text('Requested Date: ' + reqdate))
      .append($('<p>').text('Return: ' + retdate))
      .append($('<p>').text('Quantity: ' + reqqty))
      .append($('<p>').text('Amount: ' + reqamount))
      .append($('<div>').html(rentedInfo));
      var nw = window.open("", "_blank", "width=500,height=700");
      nw.document.write(_style.html());
      nw.document.write(_content.html());
      nw.document.close();
      nw.print();
      setTimeout(function() {
        nw.close();
      }, 500);
    });
  });
</script>
<script type="text/javascript">
  function bumalik(x){
    xarr = x.split('|');
    const penalty = parseInt(xarr[2]);
    const currentDate = new Date();
    const targetDate = new Date(xarr[1]);
    if (currentDate > targetDate) {
// Calculate the time difference in milliseconds
const timeDifference = targetDate.getTime() - currentDate.getTime();
// Convert the time difference from milliseconds to days
const daysDifference = Math.abs(Math.ceil(timeDifference / (1000 * 3600 * 24)));
document.getElementById("rno").textContent = xarr[3];
document.getElementById("noD").textContent = daysDifference;
document.getElementById("pp").textContent =penalty;
document.getElementById("tpa").textContent =(daysDifference*penalty);
document.getElementById("ids").textContent = xarr[0];
$('#penalty').modal('show');


} else {
 var requestData = {
  id: xarr[1],
};
$.ajax({
  url: 'ajax.php?action=update_rented',
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
}




}
</script>


<script type="text/javascript">

  function penalRetrun() {


    var reciept = document.querySelector('span[id="rno"]').textContent;
    var days = document.querySelector('span[id="noD"]').textContent;
    var tpa = document.querySelector('span[id="tpa"]').textContent;
    var idss = document.querySelector('input[id="ids"]').textContent;




    var requestData = {
      id:idss,
      refno: reciept,
      days: days,
      pps: tpa
    };
    $.ajax({
      url: 'ajax.php?action=add_penalty',
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
  }

</script>
