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

            $('#adi').keyup(function() {

                // var form_data= $("#form1").serialize();

                var form_data =
                {
                    //ogrenciNo: $('#ogrenciID').val(),
                    adi: $('#adi').val()
                    //soyadi: $('#soyadi').val()
                };

                $.ajax({
                    url: "3Ajax1.php",
                    type: 'POST',
                    //dataType: 'json',
                    data: form_data,
                    success: function(msg)
                    {	//alert("Kayıt başarıyla eklenmiştir...");
                        $("#ortaForm").html(msg);
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

<p>Adı: <input type="text" id="adi" name="adi"/><br /> </p>

<div id="ortaForm" style="margin-left: 200px;height: 200px;overflow: scroll">

</div>

<div id="listele2" style="display: none;margin-left: 300px"></div>

</body>
</html>

