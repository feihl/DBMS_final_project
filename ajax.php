<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();

if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}

if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}


//Genre
if($action == "save_genre"){
	$save = $crud->save_genre();
	if($save)
		echo $save;
}

if($action == "delete_genre"){
	$delete = $crud->delete_genre();
	if($delete)
		echo $delete;
}

//customer
if($action == "save_customer"){
	$save = $crud->save_customer();
	if($save)
		echo $save;
}

if($action == "del_customer"){
	$delete = $crud->delete_customer();
	if($delete)
		echo $delete;
}


//movies
if($action == "save_movie"){
	$save = $crud->save_movie();
	if($save)
		echo $save;
}

if($action == "delete_movie"){
	$delete = $crud->delete_movie();
	if($delete)
		echo $delete;
}


if($action == "save_inventory"){
	$save = $crud->save_inventory();
	if($save)
		echo $save;
}

if($action == "save_trans"){
	$save = $crud->save_trans();
	if($save)
echo $save;
}



if($action == "save_user"){
	$save = $crud->save_user();
	if($save)
		echo $save;
}

if($action == "delete_user"){
	$delete = $crud->delete_user();
	if($delete)
		echo $delete;
}

if($action == "update_user"){
	$update = $crud->update_user();
	if($update)
		echo $update;
}


if($action == "update_role"){
	$update = $crud->update_role();
	if($update)
		echo $update;
}

if($action == "update_rented"){
	$update = $crud->update_rented();
	if($update)
		echo $update;
}

if($action == "add_penalty"){
	$save = $crud->add_penalty();
	if($save)
		echo $save;
}

ob_end_flush();
?>
