<?php
	if($_GET["i"] == ""){
		header('Location: ../admin.php?a=slider');
	}
	require_once("../connect.php");
	$id = $_GET["i"];
	
	$sql = mysql_query("SELECT * FROM slider WHERE id='$id'");
	
	if(!($slider = mysql_fetch_array($sql))){
		header('Location: ../admin.php?a=slider');		
	}
?>
				
<div class="col-sm-10">
 <form class="form-horizontal" name="slider" <?php echo 'action="sd.php?i='.$id.'"'; ?> method="post" onsubmit="return check_haber()">
  <div class="form-group">
    <label class="control-label col-sm-2" for="baslik">Haber ID:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="haber_id" id="haber_id" size="100" value="<?php echo $slider["haber_id"] ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="resim">Resim:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" size="100" name="foto" id="foto" value="<?php echo $slider["foto"] ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="kategori">Başlık:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" size="100" name="baslik" id="baslik" value="<?php echo $slider["baslik"] ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="tarih">İkinci:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" size="100" name="ikinci" id="ikinci" value="<?php echo $slider["ikinci"] ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="tarih">Detay:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" size="100" name="detay" id="detay" value="<?php echo $slider["detay"] ?>">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success btn-md">Kaydet</button>
    </div>
  </div>
</form>
</div>


<script>
    	function check_haber(){
    		var baslik = document.forms["slider"]["baslik].value;
    		var resim = document.forms["slider"]["resim"].value;
    		var kategori = document.forms["slider"]["kategori"].value;
			var tarih = document.forms["slider"]["tarih"].value;
			var metin = document.forms["slider"]["metin"].value;
			
    		if (baslik == "" || resim == "" || kategori == "" || tarih == "" || metin == "") {
				alert("L�tfen bos kisim birakmayin.");
				return false;
			}

		}
</script>

<?php
	mysql_close($link);
?>