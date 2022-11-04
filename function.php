<?php

function validation_error($key = '', $error_msg = '')
{
	$error_msg_arr = [];
	if (!empty($key) && !empty($error_msg)) {
		$error_msg_arr += [
			$key => $error_msg
		];
		return;
	}
	return $error_msg_arr;
}
function required($text, $key)
{
	if (empty($text)) {
		$error_msg = ucwords(str_replace("_", " ", $key)) . " is Required";
		validation_error($key, $error_msg);
		return false;
	}
	return true;
}

function validate_email($email)
{
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return true;
	}
	$error_msg = "Email invalid format";
	validation_error('email', $error_msg);
	return false;
}

function validate_mobile($mobile)
{
	if (preg_match('/^[0-9]{10}+$/', $mobile)) {
		return true;
	}
	$error_msg = "Mobile invalid format";
	validation_error('mobile', $error_msg);
	return false;
}

function validate_date($date)
{
	if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date)) {
		return true;
	}
	$error_msg = "Date invalid format";
	validation_error('date_of_joining', $error_msg);
	return false;
}

function validate_number($number)
{
	if (is_numeric($number)) {
		return true;
	}
	$error_msg = "Invalid number";
	validation_error('salary_per_month', $error_msg);
	return false;
}

function validate_id($post_id)
{
	$id = (int)$post_id;
	if ($id <= 0) {
		$_SESSION['failure'] = "Bad user, wrong id";
		redirect("/crud");
	}
	return escape($id);
}

function redirect($location)
{
	header("Location: $location");
	exit;
}

function escape($input)
{
	global $conn;
	$input = trim($input);
	return $conn->real_escape_string($input);
}

function printMessageIfExist()
{
	if (isset($_SESSION['success'])) {
		echo "
		<div class='alert alert-success alert-dismissible'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			<strong>Success!</strong> {$_SESSION['success']}
		</div>
		";
		unset($_SESSION['success']);
	}

	if (isset($_SESSION['failure'])) {
		echo "
		<div class='alert alert-danger alert-dismissible'>
			<a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			<strong>Failure!</strong> {$_SESSION['failure']}
		</div>
		";
		unset($_SESSION['failure']);
	}
}

function email_exists($email, $id)
{
	global $conn;
	$email = escape($email);

	$where_not_id = '';
	if (!empty($id)) {
		$id = escape($id);
		$where_not_id = "AND id != {$id}";
	}
	$email = escape($email);

	$query = "SELECT 1 FROM employee WHERE email = '{$email}' {$where_not_id}";
	$result_unique_email = $conn->query($query);

	if (isset($result_unique_email)) {
		if ($result_unique_email->num_rows > 0) {
			$error_msg = "Email exist";
			validation_error('email', $error_msg);
			return true;
		}
		return false;
	}
	$error_msg = "some problem";
	validation_error('email', $error_msg);
	return true;
}

function delete_employee($delete_id)
{
	global $conn;

	$delete_id = (int) $delete_id;
	if ($delete_id <= 0) {
		$_SESSION['failure'] = "Wrong input by user!";
		return false;
	}
	$delete_id = escape($delete_id);

	$query = "DELETE FROM employee WHERE id = {$delete_id}";
	$result_delete_emp = $conn->query($query);
	
	// if id not exist, manually enter by user
	if ($conn->affected_rows == 0) {
		$_SESSION['failure'] = "Wrong input by user!, id not exist";
		return false;
	}
	
	if (!isset($result_delete_emp)) {
		$_SESSION['failure'] = "There is some problem =>{$conn->error}";
		return false;
	}
	$_SESSION['success'] = "Employee Deleted {$delete_id}";
	return true;
}

function add_update_employee($data)
{
	global $conn;
	$id = $data['id'];
	unset($data['id']);

	if (empty($id)) {
		$columns = '';
		$values = '';
		foreach ($data as $column => $value) {
			$columns .= "$column,";
			$values .= (is_numeric($value)) ? (int)$value . "," : "'$value',";
		}
		$columns = substr($columns, 0, -1);
		$values = substr($values, 0, -1);
		$query = "INSERT INTO employee({$columns}) VALUES({$values})";
		$result = $conn->query($query);

		$id_new  = $conn->insert_id;
		$_SESSION['success'] = "Employee added {$id_new}";
	} else {
		$column_values = '';
		foreach ($data as $column => $value) {
			$value_with_quote = (is_numeric($value)) ? (int)$value : "'$value'";
			$column_values .= "$column = $value_with_quote,";
		}
		$column_values = substr($column_values, 0, -1);
		$query = "UPDATE employee SET $column_values WHERE id={$id}";
		$result = $conn->query($query);

		$id_new  = $id;
		$_SESSION['success'] = "Employee updated {$id_new}";
	}
	if (isset($result)) {
		return $id_new;
	} 
	return false;
}
