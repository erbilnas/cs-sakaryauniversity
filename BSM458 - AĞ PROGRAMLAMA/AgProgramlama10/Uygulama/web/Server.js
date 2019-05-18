/***
*Geliştirilen uygulamada; LDR (ışık şiddeti), sıcaklık ve nem oranı verilerinin
 NodeJS ve MQTT yardımıyla bulut ortamına aktarılması ve Nesnelerin İnterneti Bulut hizmeti sağlayıcılarından
 biri olan Adafruit <https://io.adafruit.com> üzerinde oluşturulan kontrol panelinde görüntülenmesi sağlanmaktadır.
 Oluşturulan kontrol paneli üzerinden, aynı zamanda servo motor kontrolü de gerçekleştirilmektedir.
***/

//Kullanılan kütüphaneler tanımlanıyor
const SerialPort = require('serialport')
const mqtt = require('mqtt');
const mqttParameters = require('./info');

//mqtt sunucuya bağlanılıyor
var client = mqtt.connect(mqttParameters.brokerURL,{
    port: mqttParameters.port,
    username: mqttParameters.username,
    password: mqttParameters.password,
    rejectUnauthorized: false

});



//Seri port işlemleri için gerekli nesneler oluşturuluyor.
const Readline = require('@serialport/parser-readline')
const seriPort = new SerialPort("/dev/tty.usbserial-1410", { baudRate: 115200 })
const parser = new Readline()

seriPort.pipe(parser)

parser.on('data', function (gelenVeri) {
    //console.log(gelenVeri);
    var array = gelenVeri.split(":");
    console.log(array[0]);
    console.log(array[1]);
    console.log(array[2]);

    client.publish(mqttParameters.topic1, array[0]);
    client.publish(mqttParameters.topic2, array[1]);
    client.publish(mqttParameters.topic3, array[2]);


})


client.on('connect', () => {
    client.subscribe(mqttParameters.topic4);
});

// Uzaktan gelen mesajı al
client.on('message', function (topic4, message) {
    console.log(message.toString());
    if(message.toString().trim()=='On')
        seriPort.write('1');
    else
        seriPort.write('0');
});

//seriPort.write(data.toString());