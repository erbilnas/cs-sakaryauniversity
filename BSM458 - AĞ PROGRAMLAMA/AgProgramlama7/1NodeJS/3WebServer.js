/**
 * Created by wsan on 04.04.2016.
 *
 * Tarayicidan localhost:8080/3Index.html için istekte bulunmanız gerekir
 */

//http://www.tutorialspoint.com/nodejs/nodejs_web_module.htm


//Dependencies

var http = require('http');
var fs = require('fs');
var url = require('url');


//Web sunucu oluşturularak başlatılıyor
http.createServer( function (request, response) {
    //URL içerisinden istenen kaynak bilgisi alınıyor
    var pathname = url.parse(request.url).pathname;

    console.log("istenen sayfa " + pathname );

    // İstenen dosya okunuyor ve yanıt olarak gönderiliyor
    fs.readFile(__dirname+pathname, function (err, data) {
        if (err) {
            console.log("İstenen Sayfa Yok"+err);
            // HTTP Status: 404 : NOT FOUND
            // Content Type: text/plain
            response.writeHead(404, {'Content-Type': 'text/html'});
            response.write('Sayfa Yok...');
        }else{
            //Page found
            // HTTP Status: 200 : OK
            // Content Type: text/plain
            response.writeHead(200, {'Content-Type': 'text/html'});

            // Write the content of the file to response body
            response.write(data.toString());
        }
        // Send the response body
        response.end();
    });
}).listen(8080);

console.log('8080 Portu dinleniyor...');