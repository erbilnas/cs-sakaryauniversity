<!DOCTYPE html>
<html>
<head lang="en">

    <meta charset="UTF-8">

    <title>index1</title>
    <link rel="stylesheet"  type="text/css" href="CSS/Main.css" />
    <script src="JS/jquery-1.9.1.js"></script>
    <script>
        $(document).ready(function()
        {

            $('#adi').keyup(function(e)
            {
                if(e.which==16) // ignore shift key
                    return;

                // var form_data= $("#form1").serialize();

                var form_data =
                {
                    //ogrenciNo: $('#ogrenciID').val(),
                    adi: $('#adi').val()
                    //soyadi: $('#soyadi').val()
                };

                $.ajax({
                    url: "9XMLPHP1.php",
                    type: 'POST',
                    dataType: "xml",
                    data: form_data,
                    success: function(gelenVeri)
                    {	//alert(gelenVeri);
                        $('#ortaForm').empty();

                        $(gelenVeri).find('ogrenci').each(function(index) {
                            var ad = $(this).find('adi').text();
                            var soyad = $(this).find('soyadi').text();
                            //alert(ad);
                            $('#ortaForm').append(index+ ad+'--'+soyad+'<br>');

                        });

                    },
                    error: function()
                    {
                        alert("Hata meydana geldi. Lütfen tekrar deneyiniz !!!");
                    }
                });
                return false;
            });
        });

    </script>

</head>

<body>

<p>Adı: <input type="text" id="adi" name="adi"/><br /> </p>

<div id="ortaForm" style="margin-left: 200px;height: 200px">

</div>

<div id="listele2" style="display: none;margin-left: 300px"></div>

</body>
</html>

