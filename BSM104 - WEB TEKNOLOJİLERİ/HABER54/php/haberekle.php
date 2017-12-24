<div class="col-sm-10">
 <form class="form-horizontal" name="haber" action="php/he.php" method="post" onsubmit="return check_haber()">
  <div class="form-group">
    <label class="control-label col-sm-2" for="baslik">Başlık:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="baslik" id="baslik" placeholder="Başlık">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="resim">Resim:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="resim" id="resim" placeholder="Resim Yolu">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="kategori">Kategori:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="kategori" id="kategori" placeholder="Kategori">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="tarih">Tarih:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" name="tarih" id="tarih" placeholder="Tarih">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-2" for="metin">Haber:</label>
    <div class="col-sm-10">
  <textarea class="form-control" rows="10" name="metin" id="metin"></textarea>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success btn-md">Ekle</button>
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
				alert("Lütfen boş kısım bırakmayın.");
				return false;
			}

		}
    </script>