<?php
	// initialize errors variable
	$errors = "";
	
	if (isset($_POST['submit'])) {
	if (empty($_POST['task'])) {
	$errors = "You must fill in the task."; 
	}else{
	$task = $_POST['task'];
	$sql = "INSERT INTO practice_todo (task) VALUES ('$task')";
	mysqli_query($db, $sql);
	}
	}	
	
	if (isset($_GET['del_task'])) {
	$id = $_GET['del_task'];
	
	$sql = "UPDATE practice_todo SET deleted=1 WHERE id=".$id;
	mysqli_query($db, $sql);
	}
	
	if (isset($_GET['comp_task'])) {
	$id = $_GET['comp_task'];
	
	$sql = "UPDATE practice_todo SET done=1 WHERE id=".$id;
	mysqli_query($db, $sql);
	}
	
	if (isset($_GET['uncomp_task'])) {
	$id = $_GET['uncomp_task'];
	
	$sql = "UPDATE practice_todo SET done=0 WHERE id=".$id;
	mysqli_query($db, $sql);
	}
?>
	
<h2>To-Do List</h2>

<?php  
if (isset($errors)) { echo"<p>$errors</p><br>"; } 
?>
<style>
	.table .thead-dark th {
	color: #fff;
	background-color: #1bb09b;
	border-color: #1bb09b;
	}
</style>
<form method="post" action="proj01.htm" class="input_form">
	<input type="text" name="task" class="task_input form-control" placeholder="Write the task here" style="margin-bottom:5px;" required>
	<button type="submit" name="submit" id="add_btn" class="add_btn btn btn-farel" >Add Task</button>
</form>
<br>
<table class="table table-striped">
	<thead class="thead-dark">
		<tr>
			<th scope='row'>#</th>
			<th scope='row'>Tasks</th>
			<th scope='row'>Complete?</th>
			<th scope='row'>Delete</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			// select all tasks if page is visited or refreshed
			$tasks = mysqli_query($db, "SELECT * FROM practice_todo where deleted=0");
			
			$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
		<tr>
			<th scope="row"> <span class="text"><?php echo $i; ?> </span></th>
			<td class="task"> <span class="text"><?php echo $row['task']; ?> </span></td>
			<td class="complete"> 
				<span class="text">
				<?php 
					$id=$row['id'];
					if($row['done']==0) {echo "
						<a href='proj01.htm?comp_task=$id'>&#9634;		</a>";}
					if($row['done']==1) {echo "
						<a href='proj01.htm?uncomp_task=$id' >&#10004;</a>";}
					?> 
				</span>
			</td>
			<td class="delete"> 
				<a href="proj01.htm?del_task=<?php echo $row['id'] ?>">x</a> 
			</td>
		</tr>
		<?php $i++; } ?>	
	</tbody>
</table>