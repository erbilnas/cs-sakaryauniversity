/**
 *
 *JWT: JSON Web Token
 *Kimlik doğrulama ve iki sistem arasında güvenli olarak bilgi taşıma amacıyla kullanılır.
 *İletilen bilginin değiştirilememesi için dijital imza kullanılır
 * Header.payload.signature   bölümlerinden oluşur
 *
 *Header: Algoritma
 {
     "alg": "HS256",
     "typ": "JWT"
 }
 Payload: Taşınacak bilgi
{
        "userID": "12345",
        "name": "Faruk",
        "role": 3,
        exp: Math.floor(new Date().getTime()/1000) + 7*24*60*60; // 7 gün
}

Signature:
 data = base64urlEncode( header ) + “.” + base64urlEncode( payload );
 signature = Hash( data, secret );

 */

//Dependencies  - Modules required
var express    = require('express'); // Node.js web application framework
var monk = require("monk"); // MongoDB Driver
var bodyParser = require('body-parser'); // get parameters from a request
var morgan     = require('morgan'); // log requests to the console
var should = require("should"); //  try-catch mechanism
var jwt    = require('jsonwebtoken');

// configurations

var app = express();
app.use(morgan('dev')); //app.use()  gerekli olan middleware (fonksiyon) leri eklemek (aktif hale getirmek) için kullanılır
app.use(bodyParser.urlencoded({ extended: true })); //express middleware - parse application/x-www-form-urlencoded
app.use(bodyParser.json()); // parse application/json
var secret = "GizliIfade";

var db = monk('localhost/OgrenciBilgiSistemi');
should.exists(db);
var collection = db.get("Ogrenci");
should.exists(collection);

var router = express.Router(); //initiate a new Express Router.
// uygulamanın gelen isteklere nasıl yanıt vereceğini belirler. isteklerin nereye yönlendirileceğini tanımlar

// Tüm istekler için kök dizin tanımlanır
app.use('/RestAPI', router); // proseslere erişmek için istekler "sunucuSoketAdresi/RestAPI" ile başlayacak
                             // http://localhost:8080/RestAPI




// Start server
var port=8080;
app.listen(port);
console.log('Sunucu Başlatıldı:' + port);

// Routes

// all requests are routed here firstly, then directed to the related route
router.use(function(req, res, next) {
	console.log('Web Servisine istek geldi');
    res.header('Access-Control-Allow-Origin', '*'); //Farklı domainlerden içerik alınabilsin diye eklendi
    res.header('Access-Control-Allow-Methods', 'PUT, GET, POST, DELETE, OPTIONS');
    res.header('Access-Control-Allow-Headers', 'Content-Type');
	next();
});



//for GET http://localhost:8080/RestAPI requests

router.get('/', function(req, res) {

    res.json({ mesaj: 'Rest API Ana Dizini ' });
});


// create JWT
function generateToken(req)
{
    // Gecerlilik süresi 7 gün olarak ayarlanır
    var expiresDefault = Math.floor(new Date().getTime()/1000) + 7*24*60*60;


    var payload= {
        "userID": "12345",
        "name": "Faruk",
        "role": 3,
        exp: expiresDefault

    };

    var token = jwt.sign(payload, secret);
    console.log(token);

    return token;
}


function authSuccess(req, res) {
    var token = generateToken(req);
   // console.log(token);
   // token= jwt.compact();
    res.writeHead(200, {
        'content-type': 'text/html',
        'authorization': token
    });
    return res.end("Oluşturulan jeton->"+token);
}


//  http://localhost:8080/RestAPI/Authenticate
    //Request Header:
        //Content-Type: application/x-www-form-urlencoded
        //Request Body
         //   Text: ogrenciNo=yxz
router.route('/Authenticate')

// insert operation
    .post(function(req, res) {


        collection.find({ogrenciNo:req.body.ogrenciNo},{ }, function (err, doc){
            if(err)
                throw err;

            if(doc[0])
            {
                console.log("Kayıt bulundu");
                //res.json(doc);

                authSuccess(req,res);




            }else
                res.json({ "mesaj": "Yanlis Numara" });

        });




    });

//  http://localhost:8080/RestAPI/Authenticate/Ogrenciler/yxz
//Request Header:
    //authorization: Üretilen jeton (boşluklara dikkat!)

router.route('/Authenticate/Ogrenciler/:ogrenciNo')

    // select  operation (all rows)
    .get(function(req, res) {
        console.log(req.params.ogrenciNo);

    //http://localhost:8080/RestAPI/Authenticate/Ogrenciler/67?token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySUQiOi...
      /*  app.use(function (req, res) {
            res.cookie('token',token, { maxAge: 700000, httpOnly: true })
        });*/
        var receivedToken = req.body.token || req.query.token || req.headers['authorization'];

        if(receivedToken)
        {


            jwt.verify(receivedToken, secret, function(err, decoded) {
                if (err) {
                    return res.json({  "mesaj": "Jeton gönderiminde sorun var" });
                }

                console.log("Alinan jeton ->"+decoded.userID+" "+decoded.name);

            });


            collection.find({ogrenciNo: req.params.ogrenciNo}, {}, function (err, doc) {
                if (err)
                    res.send(err);
                //console.log(doc);
                res.json(doc);
            });
        }
        else
        {

            res.json({  "mesaj": "Geçersiz jeton" });
        }
    });



//for  http://localhost:8080/RestAPI/Ogrenciler/ogrenciNo requests
router.route('/Ogrenciler/:ogrenciNo')


    // select  operation (ogrenciNo)
	.get(function(req, res) {
        console.log(req.params.ogrenciNo);

            collection.find({ogrenciNo: req.params.ogrenciNo}, {}, function (err, doc) {
                if (err)
                    res.send(err);
                //console.log(doc);
                res.json(doc);
            });

	})

