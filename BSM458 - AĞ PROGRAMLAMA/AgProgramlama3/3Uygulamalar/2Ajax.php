<?php

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title>index1</title>
    <meta content="text/html" charset="utf-8"/>
    <link rel="stylesheet"  type="text/css" href="CSS/Main.css" />

    <script src="JS/jquery-1.9.1.js"></script>

    <script>
        $(document).ready(function()
        {

            $("#mesaj").hide();

            $('#gonder').click(function() {

                // var form_data= $("#form1").serialize();

                var form_data =
                {
                    ogrenciNo: $('#ogrenciID').val(),
                    adi: $('#adi').val(),
                    soyadi: $('#soyadi').val()
                };

                $.ajax({
                    url: "2Ajax1.php",
                    type: 'POST',
                    //dataType: 'json',
                    data: form_data,
                    success: function(msg)
                    {	alert("Kayıt başarıyla eklenmiştir...");
                        //$("#ortaForm").append(msg);
                        //$('#listele2').html(msg).fadeIn("slow");//.fadeOut("slow");
                    },
                    error: function()
                    {
                        alert("Hata meydana geldi. Lütfen tekrar deneyiniz !!!");
                    }
                });

                return false;

            });


            $('#ogrenciID').blur(function() {

                // var form_data= $("#form1").serialize();

                var form_data =
                {
                    ogrenciNo: $('#ogrenciID').val()
                };



            $.ajax({
                url: "2Ajax1.php",
                type: 'POST',
                dataType: 'json',
                data: form_data,
                success: function(data)
                {	//alert(data);

                    var sonuc = data['sonuc'];
                    if (sonuc == '1')
                    {
                        $("#mesaj").html("Öğrenci kayıtlı!!!").slideDown("1500");
                    }
                    else
                    {

                        //$("#mesaj").html("Kayıt bulunamadı!!!").slideDown("1500");

                    }



                    //$("#ortaForm").append(msg);
                    //$('#listele2').html(msg).fadeIn("slow");//.fadeOut("slow");
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

<div id="ortaForm" style="margin-left: 200px;height: 200px">


    <form action="" id="form1">
        Numara:
        <input type="text" id="ogrenciID" name="ogrenciID"/><br /><h5 id="mesaj" style="display: none"> </h5>

        Adı: <input type="text" id="adi" name="adi"/><br />

        Soyadı: <input type="text" id="soyadi" name="soyadi"/><br />


        <input type="submit" id="gonder" value="Kaydet"/>
    </form>

</div>

<div id="listele2" style="display: none;margin-left: 300px"></div>

</body>
</html>

