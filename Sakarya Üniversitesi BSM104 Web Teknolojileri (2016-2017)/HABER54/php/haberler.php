<div class="col-sm-12">
	<table class="table table-striped">
    <thead>
      <tr>
		<th>Id</th>
        <th>Başlık</th>
        <th>Resim</th>
        <th>Kategori</th>
		<th></th>
		<th></th>
      </tr>
    </thead>
    <tbody>
		
	<?php
		$sql = mysql_query("SELECT id,baslik,resim,kategori FROM haber ORDER BY id desc");
		
		while($haber = mysql_fetch_array($sql)){
			echo "<tr>";
			echo "<td>".$haber["id"]."</td>";
			echo "<td>".$haber["baslik"]."</td>";
			echo "<td>".$haber["resim"]."</td>";
			echo "<td>".$haber["kategori"]."</td>";
			echo '<td><a href="php/duzelt.php?i='.$haber["id"].'" class="btn btn-success">Düzelt</a></td>';
			echo '<td><a href="php/habersil.php?i='.$haber["id"].'" class="btn btn-danger">Sil</a></td>';
			echo "</tr>";
		}
		
		mysql_free_result($sql);
	?>

    </tbody>
  </table>
</div>