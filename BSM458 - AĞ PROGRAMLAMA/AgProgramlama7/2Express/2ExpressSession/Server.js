/**
 * https://github.com/expressjs
 *
 */

//Dependencies

var express = require('express');
var path = require('path');
var session = require('express-session');  //"cookie-session" modülü tüm oturum bilgilerini istemcide saklar
var logger = require('morgan');  // isteklerle ilgili logları konsola yazmak için
//var cookieParser = require('cookie-parser');
var bodyParser = require('body-parser');  //  get parameters from a request

var app = express();


//html template engine
app.set('views', __dirname + '/views');
app.engine('html', require('ejs').renderFile);

//app.use()  gerekli olan middleware (fonksiyon) leri eklemek (aktif hale getirmek) için kullanılır
app.use(logger('dev'));
//app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: false })); //express middleware - parse application/x-www-form-urlencoded (post ile gelen verileri alabilmek için gerekli)
//app.use(cookieParser());
app.use(express.static(path.join(__dirname, 'public')));

app.use(session({
    name: 'sessionID', // platformun anlaşılmasını engeller (nodejs varsayılnı connect.sid)
    secret: 'gizli',  //sessionID çerezini imzalamak için kullanılır.(tahmin edilerek değiştirilemesin)
    // Oturum bilgileri ölçeklenebilirliği sağlamak için redis, memcached ya da veritabanlarında saklanabilir.
     //store: new redisStore({ host: 'localhost', port: 6379, ...}),
    // store: new MemcachedStore({ host: 'localhost', port: 6379, ...}),
    //store: new MongoStore({ url: "mongodb://localhost:27017/OgrenciBilgiSistemi", "collection": "OturumBilgileri" }),
    saveUninitialized: false, //
    cookie: { maxAge: 60000 } // çerezin ömrü (ms)- varsayılan null(tarayıcı kapatıldığında biter)
}));


// uygulamanın, gelen isteklere nasıl yanıt vereceği belirlenir. isteklerin nereye yönlendirileceği tanımlanıyor

app.get('/',function(req,res){
    // create new session object.
    if(req.session.baglandi) {
        // Oturum başlatılmışsa AnaSayfa ya yönlendir.
        res.redirect('/AnaSayfa');
    } else {
        // Oturum başlatılmamışsa login sayfasına yönlendir.
        res.render('index.html');
    }
});

app.get('/AnaSayfa',function(req,res){
    sess = req.session;
    if(sess.body.baglandi) {
        res.render('AnaSayfa.html', { personelNo:sess.personelNo });
    } else {
        res.write("<h1>Öncelikle Giriş Yapmalısınız.</h1>");
        res.end('<a href="/">Giriş</a>');
    }
});

app.post('/login',function(req,res){
    // Veritabanına bağlanılarak kişi doğrulanmalı
    if(req.body.personelNo==1 && req.body.sifre==1 ) {

        sess = req.session;

        sess.personelNo=req.body.personelNo;
        sess.baglandi=1; //Yetki seviyesi alınmalı
        res.end('{"sonuc":"1"}');
    }else{
        res.end('{"sonuc":"0"}');
    }
});

app.get('/logout',function(req,res){
    req.session.destroy(function(err){
        if(err){
            console.log(err);
        } else {
            res.end();
        }
    });
});

app.listen(8080,function(){
    console.log("Sunucu 8080 portunu dinliyor...");
});