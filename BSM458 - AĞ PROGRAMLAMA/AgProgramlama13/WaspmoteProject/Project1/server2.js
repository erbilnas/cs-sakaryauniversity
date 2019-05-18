//gelen x,y,z değerleri için (2000) doğrusal grafik çiziyor.

//gelen x,y,z değerleri için (200) text tabanlı  çiziyor.


//Dependencies

var express = require('express');
var app= express();
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.use(express.static('JS'));

var monk = require("monk"); // a framework that makes accessing MongoDb really easy

/*
var bodyParser = require('body-parser'); //to get the parameters
var morgan     = require('morgan'); // log requests to the console
*/
var should = require("should"); //  It keeps your test code clean, and your error messages helpful.

var SerialPort = require("serialport").SerialPort;

var dateFormat = require('dateformat');

// configurations


/*
app.use(morgan('dev'));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
*/


var serialPort = new SerialPort("/dev/ttyUSB0", {
    baudrate: 115200,
    parser: require("serialport").parsers.readline("\n")
});

var db = monk('localhost/WaspMote');
should.exists(db);
var collection = db.get("Acceleration");
should.exists(collection);


// index.html dosyası istemcilere gönderiliyor...
app.get('/', function(req, res){
   // res.sendFile(__dirname + '/index11.html'); //doğrusal grafik
    res.sendFile(__dirname + '/index2.html'); //metin tabanlı grafik
});


// Start server

var port=8080;
http.listen(port, function(){
    console.log('Listening ' + port);
});



//Web Socket

io.on('connection', function(socket)
{
    console.log('Bir kullanıcı bağlandı');

    socket.on('disconnect', function()
    {
        console.log('Kullanıcı ayrıldı...');
    });
});


//Serial Port Operations

serialPort.on("open", function ()
{
    // Seri porttan okuma
    serialPort.on('data', function(data)
    {
        console.log(data);
        var date = new Date();
        var dataArray = data.split(':');
        //console.log(dateFormat(date.getTime(), "yyyy-mm-dd HH:MM:ss")+'-->x:'+dataArray[0]+'y:'+dataArray[1]+'z:'+dataArray[2]+'k:'+dataArray[3]+'l:'+dataArray[4]);

        console.log('\n');

        var temp= dateFormat(date.getTime(), "yyyy-mm-dd HH:MM:ss")+'-->x:'+dataArray[0]+'y:'+dataArray[1]+'z:'+dataArray[2];

        var x=dataArray[0];
        // Tüm istemcilere gönder
        io.emit('alldata', data);

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







// Routes

// all requests are routed here firstly, then directed to the related route
/*router.use(function(req, res, next) {
	console.log('Web Servisine istek geldi...');
	next();
});



//for GET http://localhost:8080/RestAPI requests

router.get('/', function(req, res) {
	res.json({ message: 'Rest API çalışıyor... ' });
});

//for  http://localhost:8080/RestAPI/Ogrenciler requests
router.route('/Ogrenciler')

	// insert operation
	.post(function(req, res) {

        var kayit= {
            "ogrenciNo": req.body.ogrenciNo,
            "adi": req.body.adi,
            "soyadi": "Yılmaz",
            "telefon": {
                "ev": "12345678",
                "is": "87654321"
            }
        }


        collection.insert(kayit, function(err, doc){
            if(err)
            {
                console.log("Hata");
            }
            else
            {
                console.log("eklendi - ");
            }
        });
		
	})

    // select  operation (all rows)
	.get(function(req, res) {
        collection.find({}, { limit : 10 }, function (err, docs){
            *//*for(i=0;i<docs.length;i++)
                console.log(docs[i]);
            });*//*
		    res.json(docs);
		});
	});

//for  http://localhost:8080/RestAPI/Ogrenciler/ogrenciNo requests
router.route('/Ogrenciler/:ogrenciNo')

    // select  operation (ogrenciNo)
	.get(function(req, res) {
        console.log(req.params.ogrenciNo);
        collection.find({ogrenciNo:req.params.ogrenciNo},{ }, function (err, doc){
			if (err)
				res.send(err);
			res.json(doc);
		});
	})

    // update  operation (ogrenciNo)
	.put(function(req, res) {
        console.log(req.body.adi+' '+req.params.ogrenciNo);
        var yeniKayit= {
            "ogrenciNo": req.params.ogrenciNo,
            "adi": req.body.adi,
            "soyadi": "Sam",
            "telefon": {
                "ev": "12345678",
                "is": "87654321"
            }
        }

        collection.update({ogrenciNo:req.params.ogrenciNo}, yeniKayit);

            res.json({ message: 'Güncelleme işlemi başarılı' });
    })


    // delete  operation (ogrenciNo)
	.delete(function(req, res) {
        collection.remove({ogrenciNo:req.params.ogrenciNo}, function (err){
            if (err) throw err;

        res.json({ message: 'Silme işlemi başarılı' });
        })

});*/


