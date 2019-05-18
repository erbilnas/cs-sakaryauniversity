/***Sıcaklık, nem ve LDR (Işık Sensörü) Uygulaması ***/
#include <dht11.h> 
#include <Servo.h>



#define DHTPin 2 
#define LDRPin A0   //LDR giriş pini
#define ledPin 4    //LED pini.
   
const int LDReSIKdEGERI=400; 
dht11 DHT11;

Servo myservo;  // create servo object to control a servo

void setup()
{
  pinMode(DHTPin, INPUT);               
  pinMode(LDRPin, INPUT);               
  pinMode(ledPin, OUTPUT);    
  Serial.begin(115200); 
  myservo.attach(9);  
}

void loop()
{
  int chk = DHT11.read(DHTPin);

  Serial.print((float)DHT11.humidity, 2);
  Serial.print(":");
  Serial.print((float)DHT11.temperature, 2);
  Serial.print(":");
  int LDRDegeri = analogRead(LDRPin);
  Serial.println(LDRDegeri);
  if(LDRDegeri<LDReSIKdEGERI)
    digitalWrite(ledPin, HIGH);
  else
    digitalWrite(ledPin, LOW);

  if (Serial.available() ) 
  { //digitalWrite(ledPin, HIGH);
    if(Serial.parseInt()==1)
      myservo.write(90); 
    else
      myservo.write(0);                       
  }

  delay(7000); 
}
