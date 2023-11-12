
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
						<th scope="col" width="20%">Total Hours</th>
					</tr>
				</thead>
				<tbody>
					<?php
                        $i = 0;
                        $prjctHours = $model->getProjectHours();
                        foreach ($prjctHours as $key => $prjctHour) {
                            $i++;
                            ?>
                                <tr>
                                    <th scope="row"><?= $i ?></th>
                                    <td>
                                    	<div class="accordion" id="accordionExample">
										  
										  <div class="accordion-item">
										    <h2 class="accordion-header">
										      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_<?= $i ?>" aria-expanded="false" aria-controls="collapse_<?= $i ?>">
										        <?= $prjctHour['project_name'] ?>
										      </button>
										    </h2>
										    <div id="collapse_<?= $i ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
										      <div class="accordion-body">
										        <table class="table table-bordered">
										        	<thead>
										        		<tr>
										        			<th>SL No</th>
											        		<th>Task Name</th>
											        		<th>Hours</th>
										        		</tr>
										        	</thead>
										        	<tbody>
										        		
										        		<?php
										        		$j = 0;
										        			$tasks = $model->getProjectTask($prjctHour['project_id']);
										        			foreach ($tasks as $key => $value) {
										        				$j++;
										        				?>

										        				<tr>
										        					<td><?= $j ?></td>
										        					<td><?= $value['task_name'] ?></td>
										        					<td><?= $value['hours']?></td>
										        				</tr>
										        				<?php
										        			}

										        		?>


										        	</tbody>
										        </table>
										      </div>
										    </div>
										  </div>
										  
										</div>

                                    </td>
              
                                    <td><?= $prjctHour['total_hours'] ?></td>
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
