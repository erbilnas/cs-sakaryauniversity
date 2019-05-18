var express = require('express');
var app = express();
var sunucu = app.listen('3000');
var io = require('socket.io').listen(sunucu);
var yol = require('path');
var mysql = require('mysql');
var conn = mysql.createConnection({
	host: 'localhost',
	user: 'root',
	password: '',
	database: 'ag_prog_odev'
});

conn.connect();
var users = {};
var name ='';

io.sockets.on('connection', function (socket) {

	//Sisteme giriş yapan kişinin adı alınıyor ve console da gösteriliyor.
	socket.on('gonder', function(veri){
		console.log(veri + " sisteme giriş yaptı.");
		var kayit = {kullaniciAd:veri, online:1};
		//sisteme giriş yapan kullanıcı veritabanına kayıt ediliyor.
		conn.query('insert into kullanici set ?', kayit, function (hata,cevap) {			
			if (!hata) {	
				console.log('Veritabanına kayıt başarılı.');
				conn.query('Select * from mesaj where kime="herkes"', function (hata, cevap) {
					io.to(socket.id).emit('tumMesajlar', cevap);
				});
			}
			else{
				console.log(hata);
				console.log('Veritabanına kayıt başarısız.');
			}
		});

		//sisteme giriş yapan kullanıcı tüm soketlere bildiriliyor.
		io.sockets.emit('al', veri);
	});

	//tüm kullanıcılara mesaj gönderen kullanıcının mesajı alınıyor
	socket.on('mesaj', function(veri){
		console.log(veri);
		//gönderilen mesajlar veritabanına kayıt ediliyor.
		var mesaj = {mesaj:veri.mesaj, kime: 'herkes' , kimden:veri.kimden};
		conn.query('insert into mesaj set ?', mesaj, function (hata,cevap) {			
			if (!hata) {	
				console.log('Veritabanına kayıt başarılı.');
			}
			else{
				console.log('Veritabanına kayıt başarısız.');
			}
		});
		//sunucuya gönderilen mesaj tüm kullanıcılara yayınlanıyor.
		io.sockets.emit('mesajAl', veri);
	});
	
	//tüm kullanıcılara mesaj gönderen kullanıcının mesajı alınıyor
	socket.on('mesajGrup', function(veri){
		console.log(veri);
		//gönderilen mesajlar veritabanına kayıt ediliyor.
		var mesaj = {mesaj:veri.mesaj, kime: 'abc' , kimden:veri.kimden};
		conn.query('insert into mesaj set ?', mesaj, function (hata,cevap) {			
			if (!hata) {	
				console.log('Veritabanına kayıt başarılı.');
			}
			else{
				console.log('Veritabanına kayıt başarısız.');
			}
		});
		//sunucuya gönderilen mesaj tüm kullanıcılara yayınlanıyor.
		socket.broadcast.to('abc').emit('mesajAlGrup', mesaj);
	});

	socket.on('odaAc', function (data) {
		var oda= "abc";
		console.log(data);
		console.log('oda aça geldik');
		socket.join(oda);
		conn.query('Select * from mesaj where kime="abc"', function (hata, cevap) {
					io.to(socket.id).emit('grupMesajlar', cevap);
				});
		socket.broadcast.to(oda).emit('girdi',data);
	});


});

app.get("/index.html",function(talep,cevap){
	cevap.sendFile(yol.join(__dirname + "/index.html"));
});

console.log("Sunucu başarıyla aktifleştirildi.");