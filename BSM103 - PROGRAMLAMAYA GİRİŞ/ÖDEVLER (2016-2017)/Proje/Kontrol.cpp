#include "Kontrol.h"
#include "Musteri.h"
#include "Urun.h"
#include <iostream>
#include <Windows.h>
#include <fstream>
#include <iomanip>

using namespace std;

HANDLE hConsole = GetStdHandle(STD_OUTPUT_HANDLE);
/*CIZIM KODLARI*/
char DUZCIZGI = 205;
char SOLUSTKOSE = 201;
char SAGUSTKOSE = 187;
char DIKEYCIZGI = 186;
char ASAGIAYRAC = 203;
char SOLALTKOSE = 200;
char SAGALTKOSE = 188;
char YUKARIAYRAC = 202;
char YATAYSAGAAYRAC = 204;
char YATAYSOLAAYRAC = 185;
/*RENK KODLARI*/
enum RENKLER
{
	BLACK = 0,
	BLUE = 1,
	GREEN = 2,
	CYAN = 3,
	RED = 4,
	MAGENTA = 5,
	BROWN = 6,
	LIGHTGRAY = 7,
	DARKGRAY = 8,
	LIGHTBLUE = 9,
	LIGHTGREEN = 10,
	LIGHTCYAN = 11,
	LIGHTRED = 12,
	LIGHTMAGENTA = 13,
	YELLOW = 14,
	WHITE = 15
};

Kontrol::Kontrol() {}

void Kontrol::araCiz(int genislik, string yazi) {
	SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 10); cout << DIKEYCIZGI;
	SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 15); cout << std::left << setw(genislik) << yazi;
	SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 10); cout << DIKEYCIZGI << endl;
}

void Kontrol::ayracCiz(int genislik) {
	SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 10); cout << YATAYSAGAAYRAC;

	for (int i = 0; i < genislik; i++) { cout << DUZCIZGI; }
	cout << YATAYSOLAAYRAC << endl;
}

void Kontrol::tavanCiz(int genislik) {
	SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 10); cout << SOLUSTKOSE;

	for (int i = 0; i < genislik; i++) { cout << DUZCIZGI; }
	cout << SAGUSTKOSE << endl;
}

void Kontrol::zeminCiz(int genislik) {
	SetConsoleTextAttribute(GetStdHandle(STD_OUTPUT_HANDLE), 10); cout << SOLALTKOSE;

	for (int i = 0; i < genislik; i++) { cout << DUZCIZGI; }
	cout << SAGALTKOSE << endl;
}

void Kontrol::anaMenuCiz() {	
	int size = 50;

	tavanCiz(size);
	araCiz(size, "ANA KONTROL PANELI");
	ayracCiz(size);
	araCiz(size, "1. Musteri Paneli");
	araCiz(size, "2. Yonetici Paneli");
	araCiz(size, "3. Cikis");
	zeminCiz(size);
}

void Kontrol::musteriMenuCiz() {
	int size = 50;

	tavanCiz(size);
	araCiz(size, "MUSTERI PANELI");
	ayracCiz(size);
	araCiz(size, "1. Urun al");
	araCiz(size, "2. Islemleri listele");
	araCiz(size, "3. Islem sil");
	araCiz(size, "4. Geri");
	zeminCiz(size);
}

void Kontrol::yoneticiMenuCiz() {
	int size = 50;

	tavanCiz(size);
	araCiz(size, "YONETICI PANELI");
	ayracCiz(size);
	araCiz(size, "1. Musteri ekle");
	araCiz(size, "2. Musteri listele");
	araCiz(size, "3. Musteri sil");
	araCiz(size, "4. Urun ekle");
	araCiz(size, "5. Urunleri listele");
	araCiz(size, "6. Urun sil");
	zeminCiz(size);
}

void Kontrol::musteriCiz() {
	string isim, soyIsim, tc, tel;
	int size = 50;

	fstream dosyaOku;
	dosyaOku.open("Musteriler.txt", ios::in);

	if (dosyaOku.is_open() == 1) {
		tavanCiz(size);
		araCiz(size, "MUSTERI LISTESI");
		ayracCiz(size);
		while (dosyaOku >> isim >> soyIsim >> tc >> tel) {
			araCiz(size, isim + " " + soyIsim + " " + tc + " " + tel);
			ayracCiz(size);
		}

		araCiz(size, "LISTE SONU");
		zeminCiz(size);
	}
}

void Kontrol::islemCiz() {
	string islemKodu, urunKodu, tc;
	int size = 50;

	fstream dosyaOku;
	dosyaOku.open("Islemler.txt", ios::in);

	if (dosyaOku.is_open() == true) {
		tavanCiz(size);
		araCiz(size, "ISLEMLER LISTESI");
		ayracCiz(size);
		while (dosyaOku >> islemKodu >> urunKodu >> tc) {
			araCiz(size, islemKodu + " " + urunKodu + " " + tc);
			ayracCiz(size);
		}

		araCiz(size, "LISTE SONU");
		zeminCiz(size);
	}
}

void Kontrol::urunCiz() {
	string urunAdi, urunKodu, urunFiyati;
	int size = 50;

	fstream dosyaOku;
	dosyaOku.open("Urunler.txt", ios::in);

	if (dosyaOku.is_open() == 1) {
		tavanCiz(size);
		araCiz(size, "URUNLER LISTESI");
		ayracCiz(size);
		while (dosyaOku >> urunAdi >> urunKodu >> urunFiyati) {
			araCiz(size, urunAdi + " " + urunKodu + " " + urunFiyati);
			ayracCiz(size);
		}

		araCiz(size, "LISTE SONU");
		zeminCiz(size);
	}
}

void Kontrol::musteriList() {
	string isim, soyIsim, tc, tel;
	int size = 50;
	
	fstream dosyaOku;
	dosyaOku.open("Musteriler.txt", ios::in);

	if (dosyaOku.is_open() == 1) {
		tavanCiz(size);
		araCiz(size, "EKLENEN MUSTERI");
		ayracCiz(size);
		while (dosyaOku.eof()!=true) {
			dosyaOku >> isim >> soyIsim >> tc >> tel;
		}

		araCiz(size, "Isim: " + isim);
		araCiz(size, "Soyisim: " + soyIsim);
		araCiz(size, "TC kimlik no'su: " + tc);
		araCiz(size, "Telefon no'su: " + tel);
		ayracCiz(size);
		araCiz(size, "LISTE SONU");
		zeminCiz(size);
	}
}

void Kontrol::urunList() {
	string mUrunAdi, mUrunKodu, fiyat;
	int size = 50;
	
	fstream dosyaOku;
	dosyaOku.open("Urunler.txt", ios::in);

	if (dosyaOku.is_open() == 1) {
		tavanCiz(size);
		araCiz(size, "EKLENEN URUN");
		ayracCiz(size);
		while (dosyaOku.eof() != true) {
			dosyaOku >> mUrunAdi >> mUrunKodu >> fiyat;
		}

		araCiz(size, "Urunun ismi: " + mUrunAdi);
		araCiz(size, "Urunun kodu: " + mUrunKodu);
		araCiz(size, "Urunun fiyati: " + fiyat);
		ayracCiz(size);
		araCiz(size, "LISTE SONU");
		zeminCiz(size);
	}
}