<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/bootstrap.css">
<link rel="stylesheet" href="/assets/css/style.css">
<script
  src="https://code.jquery.com/jquery-2.2.4.min.js"
  integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
  crossorigin="anonymous">
</script>
<script type="text/javascript" src="/assets/js/bootstrap.js"></script>	
<script type="text/JavaScript" src="/assets/js/reset.js"></script>

</head>

<body>

<div class="container">
	<div class="row">
		<div class="col-lg-4">
			<a class="logo" href="http://uvt.ro"><img src="https://www.uvt.ro/res/img/logo.26021301.png" /></a>
		</div>
	</div>
	<hr />
	<div class="row">

			<?php  

				$dayArray = array(1 => 'Luni', 2 => 'Marti', 3 => 'Miercuri', 4 => 'Joi', 5 => 'Vineri');

				$yearFilter = $this->input->get('year');
				$groupFilter = $this->input->get('group_number');
				$dayFilter = $this->input->get('day_of_week');

			?>


				<h5>Orar:</h5>
				<h5>Cautare:</h5>
				<form method='get' id="filter-form">
				
					<select name='year' id='my_select1' data-default-value=0>
						<option value="0" <?php if($yearFilter == 0){?> selected="selected"<?php } ?>>Anul</option>
						<?php for( $i=1; $i<=4; $i++){?>
						<option value="<?php echo $i;?>" <?php if($yearFilter == $i){?> selected="selected" <?php } ?>><?php echo $i;?></option>
						<?php } ?>
					</select>
					<select name='group_number' id='my_select2' data-default-value=0 >
						<option value="0" <?php if($groupFilter == 0){?> selected="selected"<?php } ?>>Grupa</option>
						<?php for( $n=1; $n<=6; $n++){?>
						<option value="<?php echo $n;?>" <?php if($groupFilter == $n){?> selected="selected" <?php } ?>><?php echo $n;?></option>
						<?php } ?>
					</select>
					<select name='day_of_week' id='my_select3' data-default-value=0>
						<option value="0" <?php if($dayFilter == 0){?> selected="selected"<?php } ?>>Ziua</option>
						<?php foreach($dayArray as $key => $value){ ?>
   						<option value="<?=$key?>" <?php if($dayFilter == $key){?> selected="selected" <?php } ?>><?php echo $value;?></option>
						<?php } ?>
					</select><br>
					<input type="submit" value="Filtreaza">
					<div id="reset">
				    	<input type="button" value="Reseteaza"/>
				   	</div>
				</form>
	<?php
		$currentDate = date("N");
		$currentHour = date("H");
	?>

	<table class='tabelul-meu'><tr><th>Id</th><th>An</th><th>Grupa</th><th>Disciplina</th><th>Zi</th><th>Ora incepere</th><th>Ora sfarsit</th><th>Sala</th></tr>


	<?php 

		foreach ($timetable as $row) {
	
		$startPart = substr($row["start"],0,-3);
		$stopPart = substr($row["stop"],0,-3);
		$hour = substr($row["start"],0,2);
		$dif = $hour-$currentHour;
		if($row["day_of_week"]==$currentDate){
			if($dif<2 && $dif>0){
				$option= 'avertisment-ora';
			}
			else{
				$option='avertisment';
			}
		}
		else{
			$option = 'tabelul-meu';
		}
	?>
		<tr class=<?=$option?>>
	   	<td><?=$row['id']?></td>
	    <td><?=$row['year']?></td>
	    <td><?=$row['group_number']?></td>
	    <td><?=$row["school_discipline"]?></td>
	    <td><?=$dayArray[$row["day_of_week"]]?></td>
	    <td><?php printf("%s",$startPart); ?></td>
	    <td><?php printf("%s",$stopPart); ?></td>
	    <td><?=$row['classroom']?></td>
	    </tr>
<?php } ?>


	</table>
		<br>

			<form method="post">
				<h5>Introducere disciplina noua:</h5>
				<input placeholder="An" type="text" name="year"><br>
				<input placeholder="Grupa" type="text" name="group_number"><br>
				<input placeholder="Disciplina" type="text" name="school_discipline"><br>
				<input placeholder="Zi" type="text" name="day_of_week"><br>
				<input placeholder="Ora incepere" type="text" name="start"><br>
				<input placeholder="Ora sfarsit" type="text" name="stop"><br>
				<input placeholder="Sala" type="text" name="classroom"><br>
				<input type="submit" value="Trimite">
			</form>
			
		<?php

			if (isset($insertResponse)) {

				if($insertResponse['status'] == 'success'){
					echo "<div class='reusit'>";
						echo "Orarul a fost introdus cu succes!";
					echo "</div>";
				}
				else{
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

</body>

</html>
