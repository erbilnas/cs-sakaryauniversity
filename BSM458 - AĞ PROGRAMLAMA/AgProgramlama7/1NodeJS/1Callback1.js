/**
 * Created by wsan on 04.04.2016.
 * Blocking I/O
 */

var fs = require("fs");

var data = fs.readFileSync(__dirname+'/1File.xml');  // Dosya okuma işlemi tamamlanana kadar burada bekler (blocking)

console.log("1. Başlatilan İşlemin sonucu:\n "+ data.toString());
console.log("2. Başlatilan İşlem");
console.log("3. Başlatilan İşlem");
console.log("4. Başlatilan İşlem");

