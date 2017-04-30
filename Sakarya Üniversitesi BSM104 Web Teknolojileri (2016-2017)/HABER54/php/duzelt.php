<?php
	if($_GET["i"] == ""){
		header('Location: ../admin.php?a=haberler');
	}
	require_once("../connect.php");
	$id = $_GET["i"];
	
	$sql = mysql_query("SELECT * FROM haber WHERE id='$id'");
	
	if(!($haber = mysql_fetch_array($sql))){
		header('Location: ../admin.php?a=haberler');		
	}
?>
				
<div class="col-sm-10">
 <form class="form-horizontal" name="haber" <?php echo 'action="d.php?i='.$id.'"'; ?> method="post" onsubmit="return check_haber()">
  <div class="form-group">
    <label class="control-label col-sm-2" for="baslik">Başlık:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="baslik" id="baslik" size="100" value="<?php echo $haber["baslik"] ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="resim">Resim:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" size="100" name="resim" id="resim" value="<?php echo $haber["resim"] ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="kategori">Kategori:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" size="100" name="kategori" id="kategori" value="<?php echo $haber["kategori"] ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="tarih">Tarih:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" size="100" name="tarih" id="tarih" value="<?php echo $haber["tarih"] ?>">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="metin">Haber:</label>
    <div class="col-sm-10">
  <textarea class="form-control" rows="20" cols="100" name="metin" id="metin">
  <?php
   echo $haber["metin"]
  ?>
  </textarea>
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
    		var baslik = document.forms["haber"]["baslik].value;
    		var resim = document.forms["haber"]["resim"].value;
    		var kategori = document.forms["haber"]["kategori"].value;
			var tarih = document.forms["haber"]["tarih"].value;
			var metin = document.forms["haber"]["metin"].value;
			
    		if (baslik == "" || resim == "" || kategori == "" || tarih == "" || metin == "") {
				alert("Lütfen bos kisim birakmayin.");
				return false;
			}

		}
</script>

<?php
	mysql_close($link);
?>