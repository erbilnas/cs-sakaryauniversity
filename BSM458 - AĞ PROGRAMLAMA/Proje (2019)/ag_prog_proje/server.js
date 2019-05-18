var express = require('express');
var app = express();
var server = app.listen('3000');
var io = require('socket.io').listen(server);
var path = require('path');
var mysql = require('mysql');
var session = require('express-session');
var bodyParser = require('body-parser');
var multer = require('multer');
var storage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, '/assets/img/blog')
  },
  filename: (req, file, cb) => {
    cb(null, file.fieldname + '-' + Date.now())
  }
});
var upload = multer({storage: storage});

console.log("Sunucu başarıyla aktifleştirildi.");

app.use(session({secret: 'ssshhhhh',saveUninitialized: true,resave: true}));
app.use(bodyParser.json());      
app.use(bodyParser.urlencoded({extended: true}));
app.use(express.static(path.join(__dirname, 'assets')));

app.get("/",function(req,res){
	res.sendFile(path.join(__dirname + "/index.html"));
});

app.get('/game-single',function(req,res){
  res.sendFile(path.join(__dirname+'/game-single.html'));
});

app.get('/contact',function(req,res){
  res.sendFile(path.join(__dirname+'/contact.html'));
});

app.get('/login',function(req, res){
  res.sendFile(path.join(__dirname+'/login.html'));
});

app.get('/postcreate',function(req, res){
  res.sendFile(path.join(__dirname+'/postcreate.html'));
});

app.get('/postupdate',function(req, res){
  res.sendFile(path.join(__dirname+'/postupdate.html'));
});

app.get('/postdelete',function(req, res){
  res.sendFile(path.join(__dirname+'/postdelete.html'));
});
var sess; // global session, NOT recommended

var conn = mysql.createConnection({
	host: 'localhost',
	user: 'root',
	password: '',
	database: 'ag_prog_proje'
});
conn.connect();

console.log("Veritabanı bağlantısı başarıyla aktifleştirildi.");

io.sockets.on('connection', function (socket) {
  //E-mail subscribe to newsletter service
  socket.on('subscribeMail', function (data) {
    var dbData = {'newslist_mail': data, 'newslist_subscribe':1};
    conn.query('insert into newslist set ?', dbData, function (err, res) {      
      if (!err) {  
        io.to(socket.id).emit('subscribeStatus', 1);
        console.log(data + " subscribe to our newslist service.");
      }
      else{
        io.to(socket.id).emit('subscribeStatus', 0);
        console.log('Veritabanına kayıt başarısız.' + err);
      }
    });
  });

  socket.on('userSignUp', function (data) {
    var dbData = {'socket_id':socket.id, 'user_name':data.username_signup, 'password': data.password_signup};
    conn.query('insert into user set ?', dbData, function (err, res) {
      if (!err) {
       io.to(socket.id).emit('signUpStatus', 1);
       console.log(data.username_signup + " is registered.");
     }else{
       io.to(socket.id).emit('signUpStatus', 0);
       console.log('Veritabanına kayıt başarısız.' + err);
     }
   });
  });

  socket.on('contactForm', function (data) {
    var dbData = {'contact_name':data.contact_name, 'contact_mail':data.contact_mail, 'contact_subject': data.contact_subject, 'contact_message': data.contact_message};
    conn.query('insert into contact set ?',dbData, function (err, res) {
      if (!err) {
        io.to(socket.id).emit('contactStatus', 1);
        console.log('Mesaj gönderimi başarılı.');
      }
      else{
        io.to(socket.id).emit('contactStatus', 0);
        console.log('Veritabanına kayıt başarısız.' + err);
      }
    });
  });

  socket.on('category', function (data) {
    if (data == 1) {
      conn.query('Select * from category' , function (err, req) {
        socket.emit('categories', req);
      });
    }
  });

  socket.on('publishPost', function (data) {
    var dbData = {"user_id":1, "post_photo":data.post_photo, "post_head": data.post_head, "category_id":data.category_id, "post_content": data.post_content, "post_publish":data.post_publish};
    conn.query('insert into post set ?',dbData, function (err, res) {
      if (!err) {
        io.to(socket.id).emit('publishStatus', 1);
        console.log('Makale başarıyla yayımlandı.');
      }
      else{
        io.to(socket.id).emit('publishStatus', 0);
        console.log('Veritabanına kayıt başarısız.' + err);
      }
    });
  });

  socket.on('getPosts', function (data) {
     if (data) {
        conn.query('Select * from post', function (err, req) {          
              socket.emit('postJSON',req);          
        });
     }     
  });

  socket.on('allPosts', function (data) {
    if (data) {
      conn.query('Select id, post_head from post', function (err, req) {          
              socket.emit('postSelect',req);          
        });
    }
  });

  socket.on('articletoUpdate', function (data) {
    conn.query('Select * from post where id=?',data, function (err, req) {
      if (!err) {
        socket.emit('article', req);
      }
      else{
        console.log(err);
      }
    });
  });

  socket.on('updatePost', function (data) {
    
  });

  socket.on('retriveforDelete', function (data) {
    if (data) {
      conn.query('Select id, post_head from post' , function (err, req) {
        if (!err) {
          socket.emit('postforDelete', req);
        }
        else{
          console.log(err);
        }
      });
    }
  });

  socket.on('deletePost', function (data) {
    conn.query('Delete from post where id=?', data, function (err,req) {
      if (!err) {
        console.log('Silme işlemi başarılı');
      }
      else{
        console.log(err);
      }
    });
  });
});

/* API */

//tüm post'ları listele
app.get('/api/post',(req, res) => {
  let sql = "SELECT * FROM post";
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
    console.log('API üzerinden postlar listelendi.');
  });
});

//tüm user'ları listele
 app.get('/api/user',(req, res) => {
  let sql = "SELECT * FROM user";
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
    console.log('API üzerinden userlar listelendi.');
  });
});

//tüm kategorileri listele
app.get('/api/category',(req, res) => {
  let sql = "SELECT * FROM category";
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
    console.log('API üzerinden kategoriler listelendi.');
  });
});

//tüm bildirimlere abone olanları listele
app.get('/api/newslist',(req, res) => {
  let sql = "SELECT * FROM post";
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
    console.log('API üzerinden aboneler listelendi.');
  });
});

//spesifik bir post'u göster
app.get('/api/post/:id',(req, res) => {
  let sql = "SELECT * FROM post WHERE id="+req.params.id;
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
    console.log('API üzerinden bir post gösterildi.');
  });
});

//bir kullanıcıya ait post(ları) göster
app.get('/api/post/user/:user_id',(req, res) => {
  let sql = "SELECT * FROM post WHERE user_id="+req.params.user_id;
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
    console.log('API üzerinden bir kullanıcıya ait tüm postlar gösterildi.');
  });
});

//bir kategoriye ait post(ları) göster
app.get('/api/post/category/:category_id',(req, res) => {
  let sql = "SELECT * FROM post WHERE category_id="+req.params.category_id;
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
    console.log('API üzerinden bir kategoriye ait tüm postlar gösterildi.');
  });
});

//yeni bir post ekle
app.post('/api/post',(req, res) => {
  let data = {"post_head": req.body.post_head, "post_content": req.body.post_content, "category_id": 1, "user_id": 1, "post_publish": 1};
  let sql = "INSERT INTO post SET ?";
  let query = conn.query(sql, data,(err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
    console.log('API üzerinden yeni bir post eklendi.');
  });
});
 
//post'u düzenle
app.put('/api/post/:id',(req, res) => {
  let sql = "UPDATE post SET post_head='"+req.body.post_head+"', post_content='"+req.body.post_content+"', category_id='"+req.body.category_id+"', user_id='"+req.body.user_id+"' WHERE id="+req.params.id;
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
    res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
    console.log('API üzerinden bir post düzenlendi.');
  });
});
 
//post'u sil
app.delete('/api/post/:id',(req, res) => {
  let sql = "DELETE FROM post WHERE id="+req.params.id+"";
  let query = conn.query(sql, (err, results) => {
    if(err) throw err;
      res.send(JSON.stringify({"status": 200, "error": null, "response": results}));
      console.log('API üzerinden bir post silindi.');
  });
});

app.use(function(req, res) {
  res.status(404).send({url: req.originalUrl + ' bulunamadı.'})
});