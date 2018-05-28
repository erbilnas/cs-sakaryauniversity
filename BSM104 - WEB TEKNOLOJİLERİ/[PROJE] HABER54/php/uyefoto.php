<div class="col-sm-1"></div>
<div class="col-sm-4">
	<?php
		$sid = $_COOKIE["SID"];
		
		$sql = mysql_query("SELECT * FROM uye WHERE session='$sid'");
		
		if($uye = mysql_fetch_array($sql)){
			echo '<img src="'.$uye["foto"].'" class="girl img-responsive" height="300" width="300" alt="" />';
		}
		
	?>
</div>

<div class="col-sm-1"></div>

<div class="col-sm-6">
<br><br><br>
	 <form class="form-horizontal" action="php/uploaduye.php" method="post" enctype="multipart/form-data">
	  <div class="form-group">
		<label class="control-label col-sm-2" for="email">Yüklemek istediğiniz fotoğrafı seçiniz:</label>
		<div class="col-sm-10">
			 <input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Fotoğraf Yükle" name="submit">
		</div>
	  </div>
	</form>
<br><br><br> <br><br>
</div>