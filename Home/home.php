<?php

include('../Master/header.php');
$projects = $model->find('projects', array('status' => '1'));
$entries = $model->getAllEntry();

?>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add Entry</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form method="POST" action="../routes.php?action=addEntry">
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label">Project</label>
						<select class="form-control" name="project" id="projects">
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

                    <div class="mb-3">
						<label class="form-label">Tasks</label>
						<select class="form-control" name="task" id="tasks" required>
							<option value="">Select Task</option>
						</select>
					</div>

                    <div class="mb-3">
                        <label class="form-label">Hours</label>
                        <input type="number" class="form-control" name="hour" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="date" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" required></textarea>
                    </div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Add Entry</button>
				</div>
			</form>


		</div>
	</div>
</div>


<script>
    $(document).ready(function () {
        $('#projects').on('change', function () {
            var projectId = $(this).val();
            if (projectId) {
                $.ajax({
                    url: '../routes.php?action=getActiveTasksOptions',
                    method: 'POST',
                    data: {
                        project_id: projectId,
                    },
                    success: function (response) {
                        $('#tasks').html(response);
                    },
                });
            }
        });
    });
</script>


<div class="main mt-3">
	<div class="container">
		<div class="row">
			<div class="head-area mt-3 mb-3">
				<div class="row">
					<div class="col-md-6">
						<h1>Time Entry</h1>
					</div>
					<div class="col-md-6 task-btn-area">
						<ul>
							<li><a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Entry New Task</a></li>
							<li><a href="reports.php" class="btn btn-success">Get Reports</a></li>
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
						<th scope="col">Hours</th>
                        <th scope="col">Date</th>
                        <th scope="col">Description</th>
					</tr>
				</thead>
				<tbody>
					<?php
                        $i = 0;
                        foreach ($entries as $key => $entry) {
                        $i++;
                    ?>
					<tr>
                        <th scope="row"><?= $i ?></th>
                        <td><?= $entry['project_name'] ?></td>
                        <td><?= $entry['task_name'] ?></td>
                        <td><?= $entry['hours'] ?></td>
                        <td><?= $entry['date'] ?></td>
                        <td><?= $entry['description'] ?></td>
                    </tr>
                    <?php 
                        }
                    ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php include('../Master/footer.php') ?>