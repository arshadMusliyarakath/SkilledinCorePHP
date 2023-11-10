<?php
include('../Master/header.php');
$projects = $model->all('projects');
?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New Project</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form method="POST" action="../routes.php?action=addNewProject">
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label">Project Name</label>
						<input type="text" class="form-control" name="projectName" placeholder="Enter Project Name" required>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add New</button>
				</div>
			</form>


		</div>
	</div>
</div>


<div class="main mt-3">
	<div class="container">
		<div class="row">
			<div class="head-area mt-3 mb-3">
				<div class="row">
					<div class="col-md-6">
						<h1>Projects List</h1>
					</div>

					<div class="col-md-6 task-btn-area">
						<ul>
							<li><a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Project</a></li>
						</ul>
					</div>
				</div>
			</div>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Project Name</th>
						<th scope="col">Status</th>
						<th scope="col">Added At</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 0;
					foreach ($projects as $key => $project) {
						$i++;
					?>
						<tr>
							<th scope="row"><?= $i ?></th>
							<td><?= $project['project_name'] ?></td>
							<td>
								<div class="form-check form-switch">
									<input class="form-check-input" type="checkbox" role="switch" id="status_<?= $i ?>" <?= ($project['status']==1) ? 'checked' : '' ?>>
									<label class="form-check-label" for="status_<?= $i ?>"><?= ($project['status'] == 1) ? 'Active' : 'Inactive' ?></label>
								</div>
							</td>
							<td><?= $project['created_at'] ?></td>
							<td>
								<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal_<?= $i ?>">Edit</a>
								<a href="../routes.php?action=deleteProject&id=<?= base64_encode($project['project_id']) ?>" class="btn btn-danger">Delete</a>
							</td>
						</tr>

						<!-- Modal -->
						<div class="modal fade" id="updateModal_<?= $i ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="exampleModalLabel">Update Project</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>

									<form method="POST" action="../routes.php?action=updateProject">
										<div class="modal-body">
											<input type="hidden" name="project_id" value="<?= $project['project_id'] ?>" required>
											<div class="mb-3">
												<label class="form-label">Project Name</label>
												<input type="text" class="form-control" name="projectName" value="<?= $project['project_name'] ?>" required>
											</div>

										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-primary">Update</button>
										</div>
									</form>


								</div>
							</div>
						</div>
						<script>
							$(document).ready(function() {
								$('#status_<?= $i ?>').on('change', function() {
									$.ajax({
										url: '../routes.php?action=changeProjectStatus',
										method: 'POST', 
										data: {
											project_id: '<?= $project["project_id"] ?>',
										},
										success: function(response) {
											location.reload();
										},
									});
								});
							});
						</script>
					<?php
					}
					?>

				</tbody>
			</table>
		</div>
	</div>
</div>




<?php
include('../Master/footer.php')
?>