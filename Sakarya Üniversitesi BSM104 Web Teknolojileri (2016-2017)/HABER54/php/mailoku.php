<div class="col-sm-12">
	<table class="table table-striped">
    <thead>
      <tr>
        <th>Ad</th>
        <th>Email</th>
        <th>Konu</th>
		<th>Tarih</th>
		<th>Kullanıcı</th>
		<th>Mesaj</th>
      </tr>
    </thead>
    <tbody>
		
	<?php
		$sql = mysql_query("SELECT * FROM mail");
		
		while($yorum = mysql_fetch_array($sql)){
			echo "<tr>";
			echo "<td>".$yorum["ad"]."</td>";
			echo "<td>".$yorum["email"]."</td>";
			echo "<td>".$yorum["konu"]."</td>";
			echo "<td>".$yorum["tarih"]."</td>";
			
			if($yorum["kullanici_id"] == 0){
				echo "<td>-</td>";
			}else{
				echo "<td>".$yorum["kullanici_id"]."</td>";	
			}
		
			echo "<td>".$yorum["mesaj"]."</td>";
			echo "</tr>";
		}
		
		mysql_free_result($sql);
	?>

    </tbody>
  </table>
</div>