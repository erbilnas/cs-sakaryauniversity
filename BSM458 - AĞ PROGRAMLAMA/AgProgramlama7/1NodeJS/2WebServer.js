var http = require('http'); //web sunucusu oluşturmak için gerekli modül- kütüphane


//Web sunucu oluşturularak başlatılıyor
http.createServer(function (req, res) {
  console.log(req.headers);  // istek (httprequest) başlığını  yazdır.
  res.writeHead(200, {'Content-Type': 'text/plain'}); // yanıt başlığı
  res.write('Merhaba Dünya'); // yanıt gövdesi
  res.end();  // yanıtı gönder- bağlantıyı sonlandır
}).listen(8080);

console.log('Port 8080 dinleniyor');
