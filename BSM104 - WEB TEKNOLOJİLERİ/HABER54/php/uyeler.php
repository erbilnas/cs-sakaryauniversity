<div class="col-sm-12">
	<table class="table table-striped">
    <thead>
      <tr>
		<th>Id</th>
        <th>Ad</th>
        <th>Email</th>
        <th>Yetki</th>
		<th></th>
      </tr>
    </thead>
    <tbody>
		
	<?php
		$sql = mysql_query("SELECT id,ad,email,yetki FROM uye");
		
		while($uye = mysql_fetch_array($sql)){
			echo "<tr>";
			echo "<td>".$uye["id"]."</td>";
			echo "<td>".$uye["ad"]."</td>";
			echo "<td>".$uye["email"]."</td>";
			echo "<td>".$uye["yetki"]."</td>";
			echo '<td><a href="php/uyesil.php?i='.$uye["id"].'" class="btn btn-danger">Sil</a></td>';
			echo "</tr>";
		}
		
		mysql_free_result($sql);
	?>

    </tbody>
  </table>
</div>