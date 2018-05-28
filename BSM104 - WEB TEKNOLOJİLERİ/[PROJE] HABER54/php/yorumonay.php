<div class="col-sm-12">
	<table class="table table-striped">
    <thead>
      <tr>
		<th>Id</th>
        <th>Ad</th>
        <th>Email</th>
        <th>Kullanici Id</th>
		<th>Tarih</th>
		<th>Yorum</th>
		<th></th>
		<th></th>
      </tr>
    </thead>
    <tbody>
		
	<?php
		$sql = mysql_query("SELECT * FROM yorum WHERE onay='0'");
		
		while($yorum = mysql_fetch_array($sql)){
			echo "<tr>";
			echo "<td>".$yorum["id"]."</td>";
			echo "<td>".$yorum["ad"]."</td>";
			echo "<td>".$yorum["email"]."</td>";
			
			if($yorum["kullanici_id"] == 0){
				echo "<td>-</td>";
			}
			
			echo "<td>".$yorum["kullanici_id"]."</td>";
			echo "<td>".$yorum["tarih"]."</td>";
			echo "<td>".$yorum["yorum"]."</td>";
			echo '<td><a href="php/yorumonayla.php?i='.$yorum["id"].'" class="btn btn-success">Onayla</a></td>';
			echo '<td><a href="php/yorumsil.php?i='.$yorum["id"].'" class="btn btn-danger">Sil</a></td>';
			echo "</tr>";
		}
		
		mysql_free_result($sql);
	?>

    </tbody>
  </table>
</div>