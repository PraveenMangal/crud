<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Employee List</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
		<div class="table-responsive">
			<div class="table-wrapper">
				<div class="table-title">

					<div class="row">

						<div class="col-xs-6">
							<h2>Manage Employees</h2>
						</div>

						<div class="col-xs-6">
							<a href="form.php" class="btn btn-success">Add New Employee</a>
						</div>
					</div>

				</div>

				<?= printMessageIfExist(); ?>

				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Name</th>
							<th>Email</th>
							<th>Mobile</th>
							<th>Designation</th>
							<th>Date of Joining</th>
							<th>Salary Per Month</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($data_emp)) :?>
							<?php foreach ($data_emp as $data) : ?>

								<tr>
									<td><?= $data['id'] ?></td>
									<td><?= "{$data['first_name']} {$data['last_name']}" ?></td>
									<td><?= $data['email'] ?></td>
									<td><?= $data['mobile'] ?></td>
									<td><?= ucfirst($data['designation']) ?></td>
									<td><?= date('d-M-y', strtotime($data['date_of_joining'])) ?></td>
									<td><?= $data['salary_per_month'] ?></td>
									<td>
										<a href="form.php?id=<?= $data['id'] ?>" class="edit"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
										<a href="index.php?delete=<?= $data['id'] ?>" class="delete"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
									</td>
								</tr>

							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>

				<div class="clearfix">
					<div class="hint-text">Showing <b><?= $emp_count_in_a_page ?></b> out of <b><?= $total_emp ?></b> entries</div>
					<ul class="pagination">
						<?php for($i = 1; $i<= $total_page; $i++): ?>
							<?php $active_page = ($i == $_GET['page']) ? 'active' : '' ; ?>

							<li class="page-item <?= $active_page ?>"><a href="index.php?page=<?= $i ?>" class="page-link"><?= $i ?></a></li>
						<?php endfor; ?>
					</ul>
				</div>

			</div>
		</div>
	</div>
</body>

</html>