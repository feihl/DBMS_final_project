<?php include('include/db_connect.php');?>
<?php if ($_SESSION['login_access'] != '1' || $_SESSION['login_access'] == '0') { 
    include('error.php');
}?>
<div class="pagetitle">
    <h1>Genre</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../basicRental/index.php">Home</a></li>
            <li class="breadcrumb-item">Movies</li>
            <li class="breadcrumb-item active">Genre</li>
        </ol>
    </nav>
</div>
<section class="section dashboard">
    <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Genre</h5>
                    <form action="" id="manage-genre" class="row g-3 needs-validation" novalidate>
                        <input type="hidden" name="id">
                        <div class="col-12">
                            <label for="yourEmail" class="form-label">Genre type</label>
                            <input type="text" id="genre" name="genre" class="form-control" required>
                            <div class="invalid-feedback">Please enter a valid Genre!</div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                                    <button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-genre').get(0).reset()"> Cancel</button>
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
                                    <th scope="col">Genre</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $i = 1;
                                $genre = $conn->query("SELECT * FROM tbl_movie_genre");
                                while($row=$genre->fetch_assoc()):
                                    ?>
                                    <tr>
                                        <td class="text-center" ><?php echo $i++ ?></td>
                                        <td class="">
                                            <p><b><?php echo $row['genreType'] ?></b></p>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary" id="edit"  type="button"
                                            data-id="<?php echo $row['id'] ?>" 
                                            data-genreType="<?php echo $row['genreType'] ?>"
                                            >Edit</button>
                                            <button class="btn btn-sm btn-danger" id="delete_genre" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
 $(document).on("click","#edit", function(e){
  var cat = $('#manage-genre')
  cat.get(0).reset()
  cat.find("[name='id']").val($(this).attr('data-id'))
  cat.find("[name='genre']").val($(this).attr('data-genreType'))
});
 $('#manage-genre').submit(function(e){
     var genreSelect = document.getElementById('genre');
     e.preventDefault()
     if (genreSelect.value === "") {
        alert("No Genre");
    } else {
        $.ajax({
            url:'ajax.php?action=save_genre',
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
            }, duration);
          }
      }
  })
    }
});
 $(document).on("click","#delete_genre", function(e){
     _conf("Are you sure to delete this category?","delete_genre",[$(this).attr('data-id')])
 });
 function delete_genre($id){
    $.ajax({
        url:'ajax.php?action=delete_genre',
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
          }            else if(resp==14){
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
