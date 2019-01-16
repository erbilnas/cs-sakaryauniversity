import math
import string

print("---------- ÖRNEK RSA ŞİFRELEME ALGORİTMASINA HOŞGELDİNİZ! ---------- \n")

p = int(input("p değerini giriniz: "))
print("\n")
q = int(input("q değerini giriniz: "))
print("\n")

modulus_n = p*q # Buradaki n sayısı iki asal sayının çarpımıdır ve hem public, hem de private key için taban (modulus) olarak kabul edilir.
totient = (p-1)*(q-1) # Totient fonksiyonu hesaplanır.

e = int(input("'Public key' değerini giriniz: "))
print("\n")

# Private key'imiz (d) hesaplanır. Math kütüphanesinde extended euclid olmadığı için, 
# d'nin 0'dan küçük olma ihtimaline karşı d ve totient sayısı toplanarak, d'nin pozitif olması sağlanır.
d = math.gcd(totient,e)
if (d<0): d += totient  

def main():
    plaintext = input("Şifrelemek istediğiniz metni giriniz: ")
    print("\n")
    plaintext = plaintext.lower() # Girilen metnin küçük harf değerleri alınır.
    output = []
    
    for character in plaintext:
        number = ord(character) - 96
        output.append(number)
        
    decryptText= encryptionFunction(output)
    decryptionFunction(decryptText)

def encryptionFunction(encryptText): # Şifreleme fonksiyonu
    print("ŞİFRELEME İŞLEMİ YAPILIYOR... \n")
    enc_list = []
    for i in range (0,encryptText.__len__(),1): # Şifrelenecek metnin karakterleri birer birer alınır.
        encrypted_plaintext = int((encryptText[i]**e) % (modulus_n)) # Her karakterin sayısal değerinin e üssü, sonra da n'e göre modu alınır.
        enc_list.append(encrypted_plaintext) # Modu alınan değerler yeni oluşturulan listeye eklenir.
    print("Şifrelenmiş metin: ", enc_list)
    print("\n")
    return enc_list

def decryptionFunction(decryptText): # Şifreli metni çözme fonksiyonu
    print("ÇÖZÜMLEME İŞLEMİ YAPILIYOR... \n")
    dec_list = []
    for i in range (0,decryptText.__len__(),1): # Şifrelenmiş metnin karakterleri birer birer alınır.
        decrypted_plaintext = (int(decryptText[i]**d) % (modulus_n)) # Her karakterin sayısal değerinin d üssü, sonra da n'e göre modu alınır.
        dec_list.append(string.ascii_lowercase[decrypted_plaintext-1]) # Modu alınan değerler ASCII'ye göre harflere dönüştürülür ve yeni listeye eklenir.
    print("Çözümlenmiş metin: ", dec_list)

main()
print("\n")
input("Çıkış yapmak için ENTER tuşuna basınız.")