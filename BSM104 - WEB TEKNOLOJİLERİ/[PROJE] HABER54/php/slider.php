<div class="col-sm-12">
	<table class="table table-striped">
    <thead>
      <tr>
		<th>Id</th>
        <th>Haber ID</th>
        <th>Fotoğraf</th>
        <th>Başlık</th>
		<th>İkinci Başlık</th>
		<th>Detay</th>
		<th></th>
      </tr>
    </thead>
    <tbody>
		
	<?php
		$sql = mysql_query("SELECT * FROM slider");
		
		while($slider = mysql_fetch_array($sql)){
			echo "<tr>";
			echo "<td>".$slider["id"]."</td>";
			echo "<td>".$slider["haber_id"]."</td>";
			echo "<td>".$slider["foto"]."</td>";
			echo "<td>".$slider["baslik"]."</td>";
			echo "<td>".$slider["ikinci"]."</td>";
			echo "<td>".$slider["detay"]."</td>";
			echo '<td><a href="php/sliderduzelt.php?i='.$slider["id"].'" class="btn btn-success">Düzelt</a></td>';
			echo "</tr>";
		}
		
		mysql_free_result($sql);
	?>

    </tbody>
  </table>
</div>