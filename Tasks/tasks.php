<?php
include('../Master/header.php');
$projects = $model->find('projects', array('status' => '1'));
$tasks = $model->getAllTasks();
?>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New Task</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form method="POST" action="../routes.php?action=addTaskProject">
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label">Task Name</label>
						<input type="text" class="form-control" name="taskName" placeholder="Enter Task Name" required>
					</div>
					<div class="mb-3">
						<label class="form-label">Project</label>
						<select class="form-control" name="projects" required>
							<option value="">Select Project</option>
							<?php
								foreach ($projects as $key => $project) {
									?>
										<option value="<?= $project['project_id'] ?>"><?= $project['project_name'] ?></option>
									<?php
								}
							?>
						</select>
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
						<h1>Tasks List</h1>
					</div>

					<div class="col-md-6 task-btn-area">
						<ul>
							<li><a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Task</a></li>
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
						<th scope="col">Task Name</th>
						<th scope="col">Status</th>
						<th scope="col">Added At</th>
						<th scope="col">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$i = 0;
						foreach ($tasks as $key => $task) {
							$i++;
							?>
								<tr>
									<th scope="row"><?= $i ?></th>
									<td><?= $task['project_name']?></td>
									<td><?= $task['task_name']?></td>
									<td>
										<div class="form-check form-switch">
											<input class="form-check-input" type="checkbox" role="switch" id="status_<?= $i ?>" <?= ($task['status']==1) ? 'checked' : '' ?>>
											<label class="form-check-label" for="status_<?= $i ?>"><?= ($task['status'] == 1) ? 'Active' : 'Inactive' ?></label>
										</div>
									</td>
									<td><?= $task['created_at']?></td>
									<td>
										<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal_<?= $i ?>">Edit</a>
										<a href="../routes.php?action=deleteTask&id=<?= base64_encode($task['task_id']) ?>" class="btn btn-danger">Delete</a>
									</td>
								</tr>

								<!-- Modal -->
								<div class="modal fade" id="updateModal_<?= $i ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">Add New Task</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>

											<form method="POST" action="../routes.php?action=updateTask">
												<div class="modal-body">
													<input type="hidden" name="task_id" value="<?= $task['task_id'] ?>" required>
													<div class="mb-3">
														<label class="form-label">Task Name</label>
														<input type="text" class="form-control" name="taskName" value="<?= $task['task_name']?>" required>
													</div>
													<div class="mb-3">
														<label class="form-label">Project</label>
														<select class="form-control" name="projects" required>
															<option value="">Select Project</option>
															<?php
																foreach ($projects as $key => $project) {
																	?>
																		<option value="<?= $project['project_id'] ?>" <?= ($project['project_id'] == $task['project_id'] ) ? 'selected' : '' ?>><?= $project['project_name'] ?></option>
																	<?php
																}
															?>
														</select>
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
												url: '../routes.php?action=changeTaskStatus',
												method: 'POST', 
												data: {
													task_id: '<?= $task["task_id"] ?>',
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