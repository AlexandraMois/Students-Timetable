
<div class="menu-bar">
	<div class="container">
		<div class="row">
			<div class="col-lg-4">
				<a class="active" href="students">Studenti</a>
				<a href="timetable">Orar</a>
			</div>
			<div class="col-lg-8">
				<div class="search-bar">
					<form method="get" class="cauta-bara">
						<input class="cauta-student" placeholder="Cauta student" type="text" name="name">
						<!-- <input type="hidden" name="searchForm" value="searchForm"> -->
						<input type="submit" value="Cauta">
					</form>
				</div>
			</div>

		</div>
	</div>	
</div>



<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<h3>Studenti:</h3>
			
			<?php 
			
			$booleanArray = array(0 => "NU", 1 => "DA"); ?>

			<table class='tabelul-meu'><tr><th>Id</th><th>Imagine profil</th><th>Nume</th><th>Anul</th><th>Grupa</th><th>Specializarea</th><th>Curs pedagogic</th><th>Incarcare imagine</th><th>Editare</th><th>Stergere</th></tr>
			<?php foreach ($students as $row) {
				
				?>
			    <tr>
				   	<td><?=$row['id']?></td>
				   	<td>
				   		<img src="/<?=$row['thumbnail']?>">
				   	</td>
				    <td><?=$row['name']?></td>
				    <td><?=$row['year']?></td>
				    <td><?=$row['group_number']?></td>
				    <td><?=$row['section']?></td>
				    <td><?=$booleanArray[$row['pedagogy_courses']]?></td>
				  <td>
				   <form method='post' enctype="multipart/form-data">
		    			<input type='hidden' name='upload' value='<?=$row['id']?>'>
					   	
					   	<a href="#" class="adauga-imagine"><input type='file' name="avatar" onchange="form.submit()"></a>
					   	<input type="hidden" type='submit' value='Incarca'>
					</form>
				   </td> 
				    <td><button type='button' class='btn-actiuni editeaza' data-toggle='modal' data-target='#myModal-<?=$row['id']?>'>Editeaza</button>
					    <div class='modal fade' id='myModal-<?=$row['id']?>' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
											  <div class='modal-dialog' role='document'>
											    <div class='modal-content'>
											     <div class='modal-header'>
											        <button type='button' class='close' data-dismiss='modal' aria-label='Inchide'><span aria-hidden='true'>&times;</span></button>
											        <h4 class='modal-title' id='myModalLabel'>Editare</h4>
											      </div>
											      <div class='modal-body'>
												       <form method='post' id="form-update-student-<?=$row['id']?>">
															<h5>Modificare date student:</h5>
															<input  value='<?=$row['id']?>' type='hidden' name='studentId'><br>
															<input  value='<?=$row['name']?>' type='text' name='name'><br>
															<input  value='<?=$row['year']?>' type='text' name='year'><br>
															<input  value='<?=$row['group_number']?>' type='text' name='group_number'><br>
															<input  value='<?=$row['section']?>' type='text' name='section'><br>
															<h5>Curs pedagogic: </h5>
															<input type='radio' name='pedagogy_courses' value='0'<?php if($row['pedagogy_courses'] == 0){ ?> checked = 'checked' <?php } ?> > NU &nbsp;&nbsp;
											  				<input type='radio' name='pedagogy_courses' value='1'<?php if($row['pedagogy_courses'] == 1){ ?> checked = 'checked' <?php } ?> > DA
														</form>

														<div class='hidden errors' >
														
															</div>
														
											      </div>
											      <div class='modal-footer'>
											        <button type='button' class='btn btn-default' data-dismiss='modal'>Inchide</button>
											        <button type='button' class='btn btn-primary' onclick="saveStudent(<?= $row['id']?>)" >Salveaza</button>
											      </div>
											    </div>
											  </div>
											</div>
					</td>
				    <td>
				    		<form method='post'>
				    			<input type='hidden' name='delete' value='<?=$row['id']?>'>
								<input class='btn-actiuni sterge' type='submit' value='Sterge'>
							</form>
				   </td>
			    
			    </tr>
			<?php
				} 
			?>
			</table>
			<br>

			<div class="hidden" id="status-update-student">
				
			</div>
			<div class="row">
				<div class="col-lg-5">	
					<div class="insert-btn">
						<input type="button" id="insert" value="Introducere student nou">
					</div>
					<div id="form-hidden" style="<?php if(!isset($insertResponse) or ($insertResponse['status'] == 'success')){  ?> display:none; <?php }  ?>">
						<form method="post" enctype="multipart/form-data">
							<input placeholder="Nume" type="text" name="name"><br>
							<h5>Imagine profil:</h5>
							<div class="adauga-poza-profil">
								<a href="#" class="adauga-imagine"><input type='file' name="avatar"></a>
							</div>
							<input placeholder="An" type="text" name="year"><br>
							<input placeholder="Grupa" type="text" name="group_number"><br>
							<input placeholder="Specializarea" type="text" name="section"><br>
							<h5>Curs pedagogic: </h5>
							<input type="radio" name="pedagogy_courses" value="0"> NU &nbsp;&nbsp;
							<input type="radio" name="pedagogy_courses" value="1"> DA<br><br>
							<input type="submit" value="Trimite">
						</form>
						<div class="response">
							<?php
							if (isset($insertResponse)) {

								if($insertResponse['status'] != 'success'){
								// 	echo "<div class='reusit'>";
								// 		echo "Studentul a fost introdus cu succes!";
								// 	echo "</div>";
								// }
								// else{
									foreach ($insertResponse['errors'] as  $value) {
										echo "<div class='eroare'>";
											echo $value ."<br>";
										echo "</div>";
									}
								}
								
							}

							?>
						</div>
					</div>
				</div>
			</div>
		
			
			<?php

			if (isset($insertResponse)) {

				if($insertResponse['status'] == 'success'){
					echo "<div class='reusit'>";
						echo "Studentul a fost introdus cu succes!";
					echo "</div>";
				}
			// 	else{
			// 		foreach ($insertResponse['errors'] as  $value) {
			// 			echo "<div class='eroare'>";
			// 				echo $value ."<br>";
			// 			echo "</div>";
			// 		}
			// 	}
				
			// }
			// var_dump($upload_data);
			// if(isset($upload_data)){
			// 	foreach ($upload_data as $key => $value) {
			// 		echo "<div class='reusit'>";
			// 			echo $key, $value;
			// 		echo "</div>";
			// 	}
			// }

			// if(isset($error)){
			// 	echo "<div class='eroare'>";
			// 		echo $error;
			// 	echo "</div>";
			}

	
		?>
	</div>
	</div>
</div>