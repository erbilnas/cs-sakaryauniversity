
var express = require('express');
var http = require('http');
var app = express();
var socket = require('socket.io');
//Server instance
var server = http.createServer(app);
//build a socket using the instance of the server
var io=socket(server);

var logger = require('morgan');  // isteklerle ilgili logları konsola yazmak için



//app.use()  gerekli olan middleware (fonksiyon) leri eklemek (aktif hale getirmek) için kullanılır
app.use(logger('dev'));

app.use(express.static(__dirname + '/node_modules'));

// index.html dosyası istemcilere gönderiliyor...
app.get('/', function(req, res){
  res.sendFile(__dirname + '/index.html');
});
/*app.get('/1', function(req, res){
    res.sendFile(__dirname + '/Test.html');
});*/
server.listen(8080, function(){
    console.log('8080 Portu dinleniyor...');
});


io.on('connection', function(socket) // bağlantı kurulduğunda
{
    console.log('Bir kullanıcı bağlandı');

    socket.on('mesaj', function(msg) // kullanıcı tanımlı olay
    {
        io.emit('mesaj', msg); //Gönderici de dahil tüm odalardaki herkese

    });
    socket.on('disconnect', function() //disconnect (connect, message ve kullanıcı tanımlı olaylar belirlenebiliyor) olayı gerçekleştiğinde
    {
        console.log('Kullanıcı ayrıldı...');
    });
});
