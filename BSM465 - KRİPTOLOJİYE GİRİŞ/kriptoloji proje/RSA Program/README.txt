------------------------------------------ RSA ŞİFRELEME ALGORİTMASI -------------------------------------------------------

RSA, güvenliği tam sayıları çarpanlarına ayrımanın algoritmik zorluğuna dayanan bir tür Açık anahtarlı şifreleme yöntemidir. 
1978’de Ron Rivest, Adi Shamir ve Leonard Adleman tarafından bulunmuştur. Bir RSA kullanıcısı iki büyük asal sayının çarpımını 
üretir ve seçtiği diğer bir değerle birlikte ortak anahtar olarak ilan eder. Seçilen asal çarpanları ise saklar. Ortak anahtarı 
kullanan biri herhangi bir mesajı şifreleyebilir, ancak şu anki yöntemlerle eğer ortak anahtar yeterince büyükse sadece asal 
çarpanları bilen kişi bu mesajı çözebilir. RSA şifrelemeyi kırmanın çarpanlara ayırma problemini kırmak kadar zor olup olmadığı
 hala kesinleşmemiş bir problemdir.
 
 
/////////////////////////////////////////// PROGRAMIN AMACI //////////////////////////////////////////////////////////////////

Kullanıcı tarafından girilen p, q ve e (public key) değerlerine göre, gerekli işlemleri yaparak d (private key) üreten ve 
ürettiği bu key'ler ile kullanıcın şifrelemek istediği metnin, şifrelenmiş ve çözümlenmiş hallerini gösteren, Python dilinde 
yazılmış bir program

 
////////////////////////////////////////// PROGRAMDA YAPILAN İŞLEMLER ////////////////////////////////////////////////////////

RSA için bir ortak anahtar bir de özel anahtar gerekir. Ortak anahtar herkes tarafından bilinir ve mesajı şifrelemek için 
kullanılır. Bir ortak anahtarla şifrelenmiş mesaj sadece özel anahtarla çözülebilir. RSA anahtarları şu şekilde oluşturulur:

1. İki adet birbirinden değişik asal sayı seçin, bunların adını da p  ve q koyalım.

2. n = p*q hesaplayın.

3. Bu sayıların totient'i olan ϕ(n) = (p-1)(q-1) hesaplayın.

4. Bir tam sayı üretin ve adını da e koyun. Bu sayı, 1 < e < ϕ(n) koşuluna uygun olmalı ve ϕ(n) ile en büyük ortak böleni 1 olmalıdır.
Yani başka bir deyişle ϕ(n) ve e kendi aralarında asal olmalıdır.

5. d*e = 1 (mod(ϕ(n))) olacak şekilde bir d'yi belirleyin.

Ortak anahtar mod değeri olan  n’den ve ortak üs olan e’den oluşur. Özel anahtar ise mod değeri olan
n’den ve özel üs olan ve gizli kalması gereken d’den oluşur. p, q ve ϕ(n) değerleri de gizli kalmalıdır çünkü d'yi hesaplamada kullanılırlar.

////////////////////////////////////////// ÖRNEK PROGRAM ÇIKTISI ////////////////////////////////////////////////////////////////

p değerini giriniz: 5


q değerini giriniz: 7


'Public key' değerini giriniz: 5


Şifrelemek istediğiniz metni giriniz: hello


ŞİFRELEME İŞLEMİ YAPILIYOR...

Şifrelenmiş metin:  [8, 10, 17, 17, 15]


ÇÖZÜMLEME İŞLEMİ YAPILIYOR...

Çözümlenmiş metin:  ['h', 'j', 'q', 'q', 'o']


Çıkış yapmak için ENTER tuşuna basınız.

//////////////////////////////////////////// PROGRAMDA BULUNAN HATALAR /////////////////////////////////////////////////////////

1. Kullanıcının giriş yaptığı public key sayısal değeri, eğer ki şifrelenecek metindeki harflerin birinin ascii değerinden daha
büyükse program "out of string range" hatası veriyor.

2. p, q ve e değerleri için sayı mı, değil mi diye kontrol yapılamıyor.