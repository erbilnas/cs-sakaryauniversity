var mongoose = require('mongoose');

//Veri Tipleri: String, Number, Date, Buffer, Boolean, Mixed, Objectid, Array, Decimal128

// Şemalar veritabanında saklı nesneleri alanlar, kısıtlar, varsayılan değerler v.s. ile tanımlamayı sağlar.
var kisiSema = mongoose.Schema({
    _id: mongoose.Schema.Types.ObjectId,

    kullaniciAdi: {type:String,required:true, unique:true, lowercase: true}, //index:true

    adSoyad: { adi: { type: String, required: true}, soyadi: {type: String, required: true} },

    olusturulmaTarihi: {type: Date, default: Date.now() }
});


// Tanımlanan şemadan model oluşturuluyor. Model ile ekleme, silme, arama, güncelleme v.s. yapılabilir.
module.exports = mongoose.model('kisi', kisiSema,'Kisiler');
