/**
 *
 * Mongoose ile mongoDB işlemleri
 *
 */

var mongoose = require('mongoose');

var kisi = require('./Models/Kisi');


//mongoose.connect(config.mongodb.uri, {useNewUrlParser: true}); // config.mongodb.uri  //config.mongodb.mlab


mongoose.connect('mongodb://localhost/obs', function (err) {

    if (err) throw err;

    console.log('Veritabanına bağlanıldı');
});



    var kisi1 = new kisi({
        _id: new mongoose.Types.ObjectId(),
        kullaniciAdi:'ayseyilmaz12',
        adSoyad: {
            adi: 'Ayşe',
            soyadi: 'Yılmaz'
        },
        olusturmaTarihi:Date.now()

    });

/*kisi1.save(function(err) {
    if (err) throw err;

    console.log('Kisi kaydedildi.');
})*/

    //Ekleme
    kisi1.save().then ( function () {console.log('Kisi kaydedildi.')})
        .catch(function (reason) { console.log("hata"+reason) })


//Arama İşlemleri için   find()-Hepsi, findOne()-ilkBulunan and findById()
    kisi.find({ kullaniciAdi: 'ayseyilmaz11' //  'adSoyad.adi': 'Ayşe' //
    }).sort('-created')
        .limit(5)
        .exec(function(err, kisiler) {
            if (err) throw err;

            console.log('Arama:'+JSON.stringify(kisiler));
        });



// Güncelleme İşlemleri için
    kisi.findByIdAndUpdate('5ca1338f433f7607a579a3be', { kullaniciAdi: 'ayilmaz4' }, function(err, kisi) {
        if (err) throw err;

        console.log('Değiştirildi--->'+ JSON.stringify(kisi));
    });

    //Silme : remove() findByIdAndRemove() findOneAndRemove()
    kisi.remove({ kullaniciAdi: 'ayseyilmaz7'
    }).exec(function(err, kisi) {
        if (err) throw err;

        console.log('Silme---->'+JSON.stringify(kisi));
    });
//});
