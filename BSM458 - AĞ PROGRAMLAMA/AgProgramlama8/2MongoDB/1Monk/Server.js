var should = require("should"); //  It keeps your test code clean, and your error messages helpful.
var monk = require("monk"); // a framework that makes accessing MongoDb really easy


//var db = monk('mongodb://wsan@192.168.56.103:27017/OgrenciBilgiSistemi');
//MongoClient.connect('mongodb://'+DATABASEUSERNAME+':'+DATABASEPASSWORD+'@'+DATABASEHOST+':'DATABASEPORT+'/'+DATABASENAME,function(err, db){
/*var db = monk('mongodb://localhost/OgrenciBilgiSistemi', function (err) {
    if(err)
        console.log(err);
    else
    {
        console.log('Mongo Conn....');

    }});*/


var db = monk('localhost/OgrenciBilgiSistemi');
should.exists(db);
var collection = db.get("ogrenciler");
should.exists(collection);

// Ekleme

var kayit= {
    "ogrenciNo": "0017",
    "adi": "Meltem",
    "soyadi": "Şahin"

}


collection.insert(kayit, function(err, doc){
    if(err)
    {
        console.log("HATA");
    }
    else
    {
        console.log("eklendi - ");
    }
});




// Listeleme	    
collection.find({"ogrenciNo":"0017"}, { limit : 100 }, function (err, docs){
    for(i=0;i<docs.length;i++)
        console.log(docs[i]);
});


// Silme
collection.remove({ "ogrenciNo": "0017" }, function (err) {
    if (err) throw err;
});


// Güncelleme
var yeniKayit= {
    "ogrenciNo": "00000000001",
    "adi": "Ahsen",

}

collection.update({ogrenciNo: '0011'}, yeniKayit);

/*collection.findAndModify(
    {
        query: {ogrenciNo: req.params.ogrenciNo},

        update: { $set: {
            adi: req.body.adi,
            soyadi: req.body.soyadi
        }
        }
    },
    /!*{"new": true, "upsert": true},*!/
    function (err, doc) {
        if (err) throw err;
        console.log(doc);
    }
);*/



