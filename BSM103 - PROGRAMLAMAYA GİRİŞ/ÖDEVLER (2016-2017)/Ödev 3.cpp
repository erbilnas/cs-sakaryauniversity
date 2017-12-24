/********************************************************************************************************************
** SAKARYA ÜNİVERSİTESİ
** BİLGİSAYAR VE BİLİŞİM BİLİMLERİ FAKÜLTESİ
** BİLGİSAYAR MÜHENDİSLİĞİ BÖLÜMÜ
** PROGRAMLAMAYA GİRİŞ DERSİ
** 2016-2017 GÜZ DÖNEMİ
**
** ÖDEV NUMARASI..........: 03
** ÖĞRENCİ ADI............: ERBİL NAS
** ÖĞRENCİ NUMARASI.......: B151210053
** DERSİN ALINDIĞI GRUP...: D GRUBU
**
** ÖDEVİN KONUSU..........: BİR DİZİYE RASTGELE OLARAK ELEMAN EKLEME VE ÇIKARMA YAPABİLEN PROGRAM (POİNTER İLE)
********************************************************************************************************************/

#include <iostream>
#include <stdlib.h>
#include <time.h>
#include <Windows.h>

using namespace std;

HANDLE hConsole = GetStdHandle(STD_OUTPUT_HANDLE); // Renklerin ekranda gözükmesi için gerekli fonksiyon

enum RENKLER // Renk kodları
{
	LIGHTBLUE = 9,
	LIGHTGREEN = 10,
	LIGHTCYAN = 11,
	LIGHTRED = 12,
	LIGHTMAGENTA = 13,
	YELLOW = 14,
};

class Hucre {
public:
	char karakter;
	int renk;
	int adet;

	Hucre() { // Hücre sınıfından oluşturulan kurucu fonksiyon
	
	}

};

class Dizi {
public:
	Dizi() { // Dizi sınıfından oluşturulan kurucu fonksiyon
		hucreSayisi = 0;
	}

	int hucreEkle() {
		RENKLER renk = RENKLER((rand() % 6) + 9); // Renklerin rastgele seçilmesi sağlandı
		hucreler[hucreSayisi] = Hucre();
		hucreler[hucreSayisi].renk	= renk;
		hucreler[hucreSayisi].karakter	= (rand() % 25) + 65; // Karakterlerin rastgele seçilmesi sağlandı
		hucreler[hucreSayisi].adet	= (rand() % 10); // Oluşacak olan hücre sayısının rastgele olması sağlandı
		hucreSayisi++;
		return 0;
	}

	int hucreCikar() {
		if (hucreSayisi <= 0) {
			cout << "Cikartilacak hucre kalmadi!" << endl;
			return 0;
		}else {
			hucreler[--hucreSayisi] = hucreler[99]; // Çıkarılan hücrenin değeri dizideki boş bir hücrenin değerine atandı (sıfıra)
		}
		
		return 0;
	}

	void ciz() {
		if (hucreSayisi <= 0) {
			cout << endl << "Hucre Sayisi: 0" << endl;
		}else {
			cout << SOLUSTKOSE;
			// Çizgilerin oluşturulması hücre sayısına bağlı olduğu için for döngüsü kullanıldı
			for (int i = 0; i < hucreSayisi; i++) {
				cout << DUZCIZGI << DUZCIZGI << DUZCIZGI << ASAGIAYRAC;
			}
			cout << SAGUSTKOSE << endl;

			for (int i = 0; i < hucreSayisi; i++) {
				cout << DIKEYCIZGI << " ";
				SetConsoleTextAttribute(hConsole, hucreler[i].renk);
				cout << hucreler[i].adet << " ";
				SetConsoleTextAttribute(hConsole, 15);
			}

			cout << DIKEYCIZGI << endl;

			for (int i = 0; i < hucreSayisi; i++) {
				cout << DIKEYCIZGI << " ";
				SetConsoleTextAttribute(hConsole, hucreler[i].renk);
				cout << hucreler[i].karakter << " ";
				SetConsoleTextAttribute(hConsole, 15);
			}

			cout << DIKEYCIZGI << endl << SOLALTKOSE;

			for (int i = 0; i < hucreSayisi; i++) {
				cout << DUZCIZGI << DUZCIZGI << DUZCIZGI << YUKARIAYRAC;
			}

			cout << SAGALTKOSE;
		}
	}

private:
	int hucreSayisi;
	char DUZCIZGI = 205;
	char SOLUSTKOSE = 201;
	char SAGUSTKOSE = 187;
	char DIKEYCIZGI = 186;
	char ASAGIAYRAC = 203;
	char SOLALTKOSE = 200;
	char SAGALTKOSE = 188;
	char YUKARIAYRAC = 202;
	Hucre hucreler[100]; // 100 elemanlı bir hücreler dizisi oluşturuldu
};

int main()
{
	int secim = 1;

	srand(time(NULL));
	Dizi *dizi = new Dizi(); // Dizi sınıfından adres tutan dizi nesnesi oluşturuldu (pointer)

	for (int i = 0; i < (rand() % 5 + 5); i++) {
		dizi->hucreEkle(); // Diziye eklenen yeni hücrenin rastgele oluşması sağlandı
	}

	dizi->ciz(); // Çiz fonksiyonu çağrılıyor

	// Ana menü
	while(true){
		cout << endl <<  "1-EKLE\n2-CIKAR\n3-Programdan Cikis\nSecim :";
		cin >> secim;

		switch (secim) {
		case 1:
			dizi->hucreEkle();
			dizi->ciz();
			cout << endl << endl;
			continue;
		case 2:
			dizi->hucreCikar();
			dizi->ciz();
			cout << endl << endl;
			continue;
		case 3:
			delete dizi;
			return 0;
		default:
			cout << endl << endl << "Lutfen menudeki bir secenegi seciniz." << endl;
			continue;
		}

	}


    return 0;
}