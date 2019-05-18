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

            $('#adi').keyup(function(e) {

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
                    url: "8JSONPHP1.php",
                    type: 'POST',
                    dataType: 'json',
                    data: form_data,
                    success: function(gelenVeri)
                    {	//alert(msg);
                        $('#ortaForm').empty();
                        $.each(gelenVeri, function(i, ogrenci){
                            $('#ortaForm')
                                .append(i+'..'+ogrenci.adi +'--')
                                .append(ogrenci.soyadi+'<hr>')
                        });


                        //$("#ortaForm").html(msg);
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

<div id="ortaForm" style="margin-left: 200px;height: 200px">

</div>



</body>
</html>

