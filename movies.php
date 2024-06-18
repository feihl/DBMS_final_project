	<?php include('include/db_connect.php');?>
<?php 
$query = $conn->query("SELECT * FROM tbl_movie_genre");
if ($query->num_rows == 0) {?>
	<script type="text/javascript"> window.location.href = 'index.php?page=genre';</script>
	<?php   exit();
}
?>
<?php if ($_SESSION['login_access'] != '1' || $_SESSION['login_access'] == '0') { 
	include('error.php');
}?>
<div class="pagetitle">
	<h1>Movies</h1>
	<nav>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="../basicRental/index.php">Home</a></li>
			<li class="breadcrumb-item active">Movies</li>
		</ol>
	</nav>
</div><!-- End Page Title -->
<section class="section">
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<button type="button" class="btn btn-outline-primary " data-bs-toggle="modal" data-bs-target="#basicModal" onclick="toggleModal()">
						Add Movie
					</button>
				</div>
				<div class="card-body">
					<h5 class="card-title">Movie List</h5>
					<!-- Table with stripped rows -->
					<table class="table table-striped datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Image</th>
								<th>Overview</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							$data = $conn->query("SELECT * FROM tbl_movie_info order by title asc");
							while($row=$data->fetch_assoc()):
								?>
								<tr>
									<td scope="row"><?php echo $i++ ?></td>
									<td >
										<img src="<?php echo $row['img'] ?>" style="max-width: 200px; max-height: 200px;">
									</td>
									<td>
										<p style="margin: 0; padding: 0;">Title: <b><?php echo $row['title'] ?></b></p>
										<p style="margin: 0; padding: 0;">Cast: <b><?php echo $row['cast'] ?></b></p>
										<p style="margin: 0; padding: 0;">Director: <b><?php echo $row['director'] ?></b></p>
										<?php 
										$data2 = $conn->query("SELECT * FROM tbl_movie_about WHERE tbl_movie_info_id = {$row['id']}");
										while ($row2 = $data2->fetch_assoc()):
											$minutes = $row2['duration'];
$hours = floor($minutes / 60); // Get the number of whole hours
$remaining_minutes = $minutes % 60; // Get the remaining minutes
// Format the duration as hour:minutes:seconds
$duration = sprintf("%02d:%02d:%02d", $hours, $remaining_minutes, 0);
?>
<p style="margin: 0; padding: 0;">Year Release: <b><?php echo $row2['year_release'] ?></b></p>
<p style="margin: 0; padding: 0;">Duration: <b><?php echo $duration ?></b></p>
<p style="margin: 0; padding: 0;">Genre: <b><?php $genre_ng_movie = explode(",",$row2['tbl_movie_genre_id']); 
$genre_names = array(); // Initialize an empty array to store genre names
											
foreach ($genre_ng_movie as $genre_id) {
  $genre_data = $conn->query("SELECT * FROM tbl_movie_genre WHERE id = '$genre_id'");

  if ($genre_data) {
    $genre_row = $genre_data->fetch_assoc();

    if ($genre_row && isset($genre_row['genreType'])) {
      $genre_names[] = $genre_row['genreType']; // Store genre name in the array
    }
  }
}

if (empty($genre_names)) {
  $genre_names[] = "NO GENRE SELECTED";
}

$genre_list = implode(', ', $genre_names); // Combine genre names with a comma
echo $genre_list;
?></b></p>
</td><!-- end ng td -->
<td><?php echo $row2['description'] ?></td>
<td >
	<button class="btn btn-sm btn-primary" id="edit" type="button" 
	data-id="<?php echo $row['id'] ?>"
	data-img_path=""
	data-title="<?php echo $row['title'] ?>"
	data-cast="<?php echo $row['cast'] ?>"
	data-director="<?php echo $row['director'] ?>"
	<?php 
	$data_about = $conn->query("SELECT * FROM tbl_movie_about WHERE `tbl_movie_info_id` = " . $row['id']);
	if ($data_about) {
		$row_about = $data_about->fetch_assoc();
		?>
		data-duration="<?php echo $row_about['duration'] ?>"
		data-release_year="<?php echo $row_about['year_release'] ?>"
		data-description="<?php echo $row_about['description'] ?>"
		<?php
	}								 ?>
	>Edit</button>
	<button class="btn btn-sm btn-danger" id="delete_movie" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
</section>
<div class="modal fade" id="basicModal" tabindex="-1">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Movies</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form action="" id="manage-movies" class="row g-3 needs-validation" enctype="multipart/form-data" novalidate>
					<input type="hidden" name="id">
					<!-- Bordered Tabs -->
					<ul class="nav nav-tabs nav-tabs-bordered" id="borderedTab" role="tablist">
						<li class="nav-item" role="presentation">
							<button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#bordered-home" type="button" role="tab" aria-controls="home" aria-selected="true">Information</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#bordered-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">About</button>
						</li>
						<li class="nav-item" role="presentation">
							<button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#bordered-contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Inventory</button>
						</li>
					</ul>
					<div class="tab-content pt-2" id="borderedTabContent">
						<div class="tab-pane fade show active" id="bordered-home" role="tabpanel" aria-labelledby="home-tab">
							<div class="row">
								<div class="col-6">
									<div class="col-12">
										<label for="img_path">Image:</label>
										<input class="form-control" type="file" id="img_path" name="img_path" accept="image/*" onchange="previewImage(event)"><br>
									</div>
									<div class="col-12">
										<label for="title">Title:</label>
										<input class="form-control" type="text" id="title" name="title" required><br>
									</div>
									<div class="col-12">
										<label for="cast">Cast:</label>
										<input class="form-control" type="text" id="cast" name="cast" required><br>
									</div>
									<div class="col-12">
										<label for="director">Director:</label>
										<input class="form-control" type="text" id="director" name="director" required><br>
									</div>
								</div>
								<div class="col-6">
									<h3>Preview:</h3>
									<img id="preview" />
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="bordered-profile" role="tabpanel" aria-labelledby="profile-tab">
							<div class="row">
								<div class="col-6">
									<label for="genre">genre:</label>
									<select name="genre[]" class="form-control" multiple required>
										<option value="" selected>Select genre Here</option>
										<?php 
										$movies = $conn->query("SELECT * FROM tbl_movie_genre order by genreType asc");
										if($movies->num_rows > 0):
											while($row= $movies->fetch_assoc()) :
												?>
												<option value="<?php echo $row['id'] ?>"><?php echo $row['genreType'] ?></option>
											<?php endwhile; ?>
										<?php else: ?>
											<option selected="" value="" disabled="">Please check the movie list.</option>
										<?php endif; ?>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-6">
									<label for="duration">Duration (in minutes):</label>
									<input class="form-control" type="number" id="duration" name="duration" min="1" required><br>
								</div>
								<div class="col-6">
									<label for="release_year">Release Year:</label>
									<input class="form-control" type="number" id="release_year" name="release_year" min="1800" max="2023" required><br>
								</div>
							</div>
							<div class="col-12">
								<label for="price">Description:</label>
								<textarea id="description" class="form-control" name="description" style="resize: none;" required ></textarea>
							</div>
						</div>
						<div class="tab-pane fade" id="bordered-contact" role="tabpanel" aria-labelledby="contact-tab">
							<div class="row">
								<div class="col-6">
									<label for="price">Price:</label>
									<input value="0" class="form-control" type="number" id="price" name="price" min="0" required><br>
								</div>
								<div class="col-6">
									<label for="quantity">Stock Quantity:</label>
									<input value="0" class="form-control" type="number" id="quantity" name="quantity" min="0"required><br>
								</div>
							</div>
						</div>
					</div><!-- End Bordered Tabs -->
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div>
	</div>
</div><!-- End Basic Modal-->
<script>
	function previewImage(event) {
		const input = event.target;
		const preview = document.getElementById('preview');
		const file = input.files[0];
		const reader = new FileReader();
		reader.onload = function () {
			preview.src = reader.result;
		};
		if (file) {
			reader.readAsDataURL(file);
		} else {
			preview.src = '';
		}
	}
	$('#manage-movies').submit(function(e){
		e.preventDefault()
        // Get the form element
        var form = document.getElementById("manage-movies");
        var title = form.querySelector("#title");
        var cast = form.querySelector("#cast");
        var director = form.querySelector("#director");
        var genre = form.querySelector("#genre");
        var duration = form.querySelector("#duration");
        var releaseYear = form.querySelector("#release_year");
        var description = form.querySelector("#description");
        var price = form.querySelector("#price");
        var quantity = form.querySelector("#quantity");
        // Check if any field is empty
        if (title.value == "" || cast.value == "" || director.value == "") {
        	alert("Please fill in all the required fields.");
        	return false;
        }
        $.ajax({
        	url:'ajax.php?action=save_movie',
        	data: new FormData($(this)[0]),
        	cache: false,
        	contentType: false,
        	processData: false,
        	method: 'POST',
        	type: 'POST',
        	success:function(resp){
        		if(resp==1){
        			$('#basicModal').modal('hide');
        			$('#success_add').modal('show');
              var duration = 3000; // 3 seconds
              setTimeout(function() {
              	$('#success_add').modal('hide');
              	location.reload()
              }, duration);
            }
            else if(resp==2){
            	$('#basicModal').modal('hide');
            	$('#success_update').modal('show');
              var duration = 3000; // 3 seconds
              setTimeout(function() {
              	$('#success_update').modal('hide');
              	location.reload()
              }, duration);
            }else if(resp==14){
            	$('#authority_problem').modal('show');
              var duration = 2000; // 3 seconds
              setTimeout(function() {
              	$('#authority_problem').modal('hide');
              	location.reload()
              }, duration);
            }}
          })
      });
	$(document).on("click","#edit", function(e){
		document.getElementById("contact-tab").disabled = true;
		var cat = $('#manage-movies')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='img_path']").val($(this).attr('data-img_path'))
		cat.find("[name='title']").val($(this).attr('data-title'))
		cat.find("[name='cast']").val($(this).attr('data-cast'))
		cat.find("[name='director']").val($(this).attr('data-director'))
		cat.find("[name='genre[]']").val($(this).attr('data-genre'))
		cat.find("[name='duration']").val($(this).attr('data-duration'))
		cat.find("[name='release_year']").val($(this).attr('data-release_year'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		cat.find("[name='price']").val($(this).attr('data-price'))
		cat.find("[name='quantity']").val($(this).attr('data-quantity'))
		$('#basicModal').modal('toggle');
	});
	$(document).on("click","#delete_movie", function(e){
		_conf("Are you sure to delete this category?","delete_movie",[$(this).attr('data-id')])
	});
	function delete_movie($id){
		$.ajax({
			url:'ajax.php?action=delete_movie',
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
	function toggleModal() {
		document.getElementById("manage-movies").reset();
		document.getElementById("contact-tab").disabled = false;
		$('#basicModal').modal('toggle');
	}
</script>