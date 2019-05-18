/*
 * ./waspmoteAcceleration.pde
 * seri porttan okuyabilmek için su olarak çalıştırılmalı...
 *
 */
 var IntId ;
 
var FramesforSend = [];
var express = require('express');
var app= express();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var dateFormat = require('dateformat');
var xbee_api = require('xbee-api');
var C = xbee_api.constants;

var xbeeAPI = new xbee_api.XBeeAPI({
	api_mode: 2
});
// index.html dosyası istemcilere gönderiliyor...
app.get('/', function(req, res){
    res.sendFile(__dirname + '/mainpage.html');
});





var SerialPort = require("serialport");
var serialPort = new SerialPort("/dev/ttyUSB0", {
//var serialPort = new SerialPort("COM3", {
    baudrate: 115200,
    parser: xbeeAPI.rawParser()}
);

var should = require("should"); //  It keeps your test code clean, and your error messages helpful.
var monk = require("monk"); // a framework that makes accessing MongoDb really easy


app.use(express.static('JS'));

var db = monk('localhost/WaspMote');
should.exists(db);
var collection = db.get("Acceleration");
should.exists(collection);

var dateFormat = require('dateformat');
/*
var collection = db.get('datas');
*/

http.listen(8080, function(){
    console.log('listening  port 8080');
});



io.on('connection', function(socket)
{
    console.log('Bir kullanıcı bağlandı');
    socket.on('disconnect', function()
    {
        console.log('Kullanıcı ayrıldı...');
    });
	socket.on('digitalIO',function(SocketNo,State)
	{
		switch(State)
		{
          case 0:
               console.log("kapandı");
			   AddToSend(SocketNo,0x00);
			   //IntId = setInterval(send, 100,SocketNo,0x00);
               break;
          case 1:
               console.log("açıldı");
			   AddToSend(SocketNo,0x01);
			   //IntId = setInterval(send, 100,SocketNo,0x01);
               break;
		}
	});
});

// All frames parsed by the XBee will be emitted here
xbeeAPI.on("frame_object", function (frame) {


	
	var frameDataStr=String(frame.data);
	
	 var frame=new Frame(String(frameDataStr));
		io.emit('alldata', frame.FrameJson);
		var data = frame.getData("ACC");
		

        // Tüm istemcilere gönder
        io.emit('acceleration', data);

       // MongoDB ye kaydet...
        collection.insert(frame.FrameJson, function(err, doc)
        {
            if(err)
            {
                console.log("HATA");
            }
            else
            {
                console.log("DB ye eklendi ");
                //console.log(insert);
            }
        });
		send();
});


function AddToSend(soketNo, state)
{
//console.log("send çalıştı");
	
		var frame_obj = {
			type: 0x10, // xbee_api.constants.FRAME_TYPE.TX_REQUEST_64  
			id: 0x01, // optional, nextFrameId() is called per default 
			destination64: "0013A200402C928F",
			//destination16: "D132",
			options: 0x00, // optional, 0x00 is default 
			data: [ soketNo, state ] 
		};
		
		FramesforSend.push(frame_obj);
		send();
		

}
function send()
{
	if(FramesforSend.length==0)
		return;
	var frame_obj=FramesforSend.pop();
	serialPort.write(xbeeAPI.buildFrame(frame_obj));
	console.log('Sent to serial port.');
	console.log(frame_obj);
	console.log(xbeeAPI.buildFrame(frame_obj));
}
function Frame(frameStr){
	this.parseItems = function parseItems (){
		for(var key in this.frameItems){
		    //console.log(this.frameItems[key]);
			var jsonItem = this.frameItems[key].split(':');
			this.FrameJson["sensor"][jsonItem[0]]=jsonItem[1];
			//console.log(this.FrameJson);
		}
	};
	
	this.getData = function getData (sensorName){
		for(var key in this.FrameJson.sensor){
			if(this.FrameJson.sensor[key].sensorName == sensorName)
				return this.FrameJson.sensor[key].data;
		}
			
	};
	
	/*Constructur*/{
		this.FrameStr = frameStr;
		var date = new Date();
		
		this.FrameJson={
			sensor:{}
		}; 
		this.frameItems = this.FrameStr.split(',');
		
		this.FrameJson.time= dateFormat(date.getTime(), "yyyy-mm-dd HH:MM:ss");
		this.parseItems();
		console.log(this.FrameJson);
	}
	
}