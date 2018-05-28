
	<?php
		$sid = $_COOKIE["SID"];
		$s = mysql_query("SELECT * FROM uye WHERE session='$sid'");
		
		if($k = mysql_fetch_array($s)){
			$k_id = $k["id"];
			
			$sql = mysql_query("SELECT * FROM yorum WHERE kullanici_id='$k_id'");
		
			if(mysql_num_rows($sql) == 0){
					echo 'Yorumunuz Bulunmamaktadir. <br><br><br>';
			}else{
				
				
				echo '<table class="table table-striped">';
				echo '<thead>';
				echo '  <tr>';
				echo '	<th>Ad</th>';
				echo '	<th>Email</th>';
				echo '	<th>Tarih</th>';
				echo '	<th>Yorum</th>';
				echo '	<th></th>';
				echo '  </tr>';
				echo '</thead>';
				echo '<tbody>';
				
				while($yorum = mysql_fetch_array($sql)){
					echo "<tr>";
					echo "<td>".$yorum["ad"]."</td>";
					echo "<td>".$yorum["email"]."</td>";
					echo "<td>".$yorum["tarih"]."</td>";
					echo "<td>".$yorum["yorum"]."</td>";
					echo '<td><a href="php/yorumsil.php?i='.$yorum["id"].'" class="btn btn-danger">Sil</a></td>';
					echo "</tr>";
				}
			
			mysql_free_result($sql);
			}
			
			
		}
	?>

    </tbody>
  </table>
</div>