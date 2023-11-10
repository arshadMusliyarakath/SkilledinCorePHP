
<?php

include('../Master/header.php');


?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>


<script>
    $(document).ready(function() {
    $('#myTable').DataTable();
});

</script>



<div class="main mt-3">
	<div class="container">
		<div class="row">
			<div class="head-area mt-3 mb-3">
				<div class="row">
					<div class="col-md-6">
						<h1>Reports List</h1>
					</div>
				</div>
			</div>
			<hr>
			<table class="table table-bordered display" id="myTable">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">Project Name</th>
                        <th scope="col">Task Name</th>
						<th scope="col">Total Hours</th>
					</tr>
				</thead>
				<tbody>
					<?php
                        $i = 0;
                        $prjctHours = $model->getAllEntry();
                        foreach ($prjctHours as $key => $prjctHour) {
                            $i++;
                            ?>
                                <tr>
                                    <th scope="row"><?= $i ?></th>
                                    <td><?= $prjctHour['project_name'] ?></td>
                                    <td><?= $prjctHour['task_name'] ?></td>
                                    <td><?= $prjctHour['hours'] ?></td>
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