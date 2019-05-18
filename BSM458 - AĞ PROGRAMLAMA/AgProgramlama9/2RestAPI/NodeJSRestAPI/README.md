# testing

http://localhost:8080/RestAPI/Ogrenciler

curl --request GET http://localhost:8080/RestAPI/Ogrenciler
curl --request GET http://localhost:8080/RestAPI/Ogrenciler/00000000003
curl --request POST http://localhost:8080/RestAPI/Ogrenciler --data 'ogrenciNo=00000002222&adi=Sena'


#phpstorm rest client - for post vars

#in request headers 
Content-Type : application/x-www-form-urlencoded.
#in Request Body
ogrenciNo=6&adi=Mehmet