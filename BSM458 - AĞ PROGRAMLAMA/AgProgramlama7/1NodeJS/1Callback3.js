/**
 * Created by wsan on 04.04.2016.
 * Non-blocking I/O
 */

var fs = require("fs");

//Dosya okuma işlemi tamamlandığında olay yayılır (event emitting) ve callback fonksiyon (bu fonksiyon (listener-Observer)) çalıştırılmak
// üzere Event Queue içerisine oradan da Call Stack içerisine gönderilir. Call Stack içerisindeki fonksiyon dosya okuma işleminin
// tamamlanmasını beklenmez (non-blocking I/O)
var callbackFoksiyon = function (err, data)
    {   console.log("Fonksiyon başlangıcı...");
        if (err) return console.error(err);
        console.log("1. Başlatilan İşlemin sonucu:\n "+ data.toString());
    }


fs.readFile(__dirname+'/1File.xml',callbackFoksiyon);

console.log("2. Başlatilan İşlem");

console.log("3. Başlatilan İşlem");

console.log("4. Başlatilan İşlem");

