/*
 * ./waspmoteAcceleration.pde
 * seri porttan okuyabilmek için su olarak çalıştırılmalı...
 *
 */

var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);


// index.html dosyası istemcilere gönderiliyor...
app.get('/', function(req, res){
    res.sendFile(__dirname + '/index.html');
});

http.listen(8080, function(){
    console.log('listening  port 8080');
});


io.on('connection', function(socket)
{
    console.log('Bir kullanıcı bağlandı');

    /*socket.on('chat message', function(msg)
    {
        io.emit('chat message', msg);
    });*/
    socket.on('disconnect', function()
    {
        console.log('Kullanıcı ayrıldı...');
    });
});



var SerialPort = require("serialport").SerialPort;
var serialPort = new SerialPort("/dev/ttyUSB0", {
    baudrate: 115200,
    parser: require("serialport").parsers.readline("\n")
});

var should = require("should"); //  It keeps your test code clean, and your error messages helpful.
var monk = require("monk"); // a framework that makes accessing MongoDb really easy


var db = monk('localhost/WaspMote');
should.exists(db);
var collection = db.get("Acceleration");
should.exists(collection);

var dateFormat = require('dateformat');
/*
var collection = db.get('datas');
*/

// Seri portu açıyor
serialPort.on("open", function ()
{
      // Seri porttan okuma
    serialPort.on('data', function(data)
    {
        //console.log(data);
        var date = new Date();
        var dataArray = data.split(':');
        console.log(dateFormat(date.getTime(), "yyyy-mm-dd HH:MM:ss")+'-->x:'+dataArray[0]+'y:'+dataArray[1]+'z:'+dataArray[2]);
        var temp= dateFormat(date.getTime(), "yyyy-mm-dd HH:MM:ss")+'-->x:'+dataArray[0]+'y:'+dataArray[1]+'z:'+dataArray[2];


        // Tüm istemcilere gönder
        io.emit('temperature', temp);

       // MongoDB ye kaydet...
        collection.insert({"time":dateFormat(date.getTime(), "yyyy-mm-dd HH:MM:ss"), "x": dataArray[0],"y": dataArray[1],"z": dataArray[2] }, function(err, doc)
        {
            if(err)
            {
                console.log("HATA");
            }
            /*else
            {
                console.log("eklendi - ");
            }*/
        });
    });


});