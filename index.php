<!DOCTYPE html>
<html lang="en">
<?php session_start(); ?>
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <?php
  if(!isset($_SESSION['login_id']))
    header('location:login.php');
  ?>
  <?php include 'include/header.php' ?>
  <style>
    #preview {
      max-width: 150px;
      max-height:150px;
    }
  </style>
</head>
<body>
  <?php include 'include/topbar.php' ?>
  <?php include 'include/navbar.php' ?>
  <main id="main" class="main">
    <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-body text-white">
      </div>
    </div>
    <?php $page = isset($_GET['page']) ? $_GET['page'] :'dashboard'; ?>
    <?php include $page.'.php' ?>
  </main>
  <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
        </div>
        <div class="modal-body">
          <div id="delete_content"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php include 'include/footer.php' ?>
  <script type="text/javascript">
   window.alert_toast= function($msg = 'TEST',$bg = 'success'){
    $('#alert_toast').removeClass('bg-success')
    $('#alert_toast').removeClass('bg-danger')
    $('#alert_toast').removeClass('bg-info')
    $('#alert_toast').removeClass('bg-warning')
    if($bg == 'success')
      $('#alert_toast').addClass('bg-success')
    if($bg == 'danger')
      $('#alert_toast').addClass('bg-danger')
    if($bg == 'info')
      $('#alert_toast').addClass('bg-info')
    if($bg == 'warning')
      $('#alert_toast').addClass('bg-warning')
    $('#alert_toast .toast-body').html($msg)
    $('#alert_toast').toast({delay:3000}).toast('show');
  }
  window._conf = function($msg='',$func='',$params = []){
   $('#confirm_modal #confirm').attr('onclick',$func+"("+$params.join(',')+")")
   $('#confirm_modal .modal-body').html($msg)
   $('#confirm_modal').modal('show')
 }
</script>



<!-- Modal improvise -->
<div class="modal fade" id="success_rented" tabindex="-1" data-bs-backdrop="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body" style="display: flex;flex-direction: column;align-items: center;justify-content: center;text-align: center;">
        <img src="Storage/icon/insurance.png" style="height: 150px; width: 150px;">
        <h3>Thank you for your Service</h3>
      </div>
    </div>
  </div>
</div>
<!-- End Vertically centered Modal-->

<!-- Modal improvise -->
<div class="modal fade" id="success_add" tabindex="-1" data-bs-backdrop="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body" style="display: flex;flex-direction: column;align-items: center;justify-content: center;text-align: center;">
        <img src="Storage/icon/check.png" style="height: 150px; width: 150px;">
        <h3>Data successfully added</h3>
      </div>
    </div>
  </div>
</div>
<!-- End Vertically centered Modal-->

<!-- Modal improvise -->
<div class="modal fade" id="success_update" tabindex="-1" data-bs-backdrop="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body" style="display: flex;flex-direction: column;align-items: center;justify-content: center;text-align: center;">
        <img src="Storage/icon/updated.png" style="height: 150px; width: 150px;">
        <h3>Data successfully updated</h3>
      </div>
    </div>
  </div>
</div>
<!-- End Vertically centered Modal-->

<!-- Modal improvise -->
<div class="modal fade" id="success_delete" tabindex="-1" data-bs-backdrop="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body" style="display: flex;flex-direction: column;align-items: center;justify-content: center;text-align: center;">
        <img src="Storage/icon/delete.png" style="height: 150px; width: 150px;">
        <h3>Data successfully deleted</h3>
      </div>
    </div>
  </div>
</div>
<!-- End Vertically centered Modal-->



<!-- Modal improvise -->
<div class="modal fade" id="authority_problem" tabindex="-1" data-bs-backdrop="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body" style="display: flex;flex-direction: column;align-items: center;justify-content: center;text-align: center;">
        <img src="Storage/icon/unauthorized.png" style="height: 150px; width: 150px;">
        <h3>Unauthorize Person!!!</h3>
      </div>
    </div>
  </div>
</div>
<!-- End Vertically centered Modal-->

</body>
</html>