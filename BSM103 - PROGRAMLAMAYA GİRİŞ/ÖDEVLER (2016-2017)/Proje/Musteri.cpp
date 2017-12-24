#include "Musteri.h"
#include "Tarih.h"
#include <iostream> 
#include <string>
#include <fstream>
#include <cstdlib>
#include <time.h>

using namespace  std;

string isimlerListesi[] = { "Ahmet","Osman","Ali","Mehmet","Veli","Sarp","Emrah","Eser","Erbil","Oguz","Can","Murat","Sinan","Mert","Mete","Sait","Ervah","Cihat","Orhan","Fatih","Ahu","Binnur","Bilge","Candan","Cahide","Demet","Deste","Gizem","Ece","Elanur","Fatma","Fidan","Gamze","Hale","Hilal","Irmak","Jale","Kader","Kamile","Lale" };
string soyisimlerListesi[] = { "KANDEMIR","ORHON","VURAL","YAVUZ","UZ","ERDEM","DEDE","UYANIK","ASLAN","ERKURAN","ER","DAL","KARAKUM","YILMAZ","TAHTACI","KAYA","ERGE","ONUK","TOPAL","BEDER" };
string isim, soyIsim, tc, tel;

void Musteri::musteriSilme() { // Musteri silme fonksiyonu
	fstream musteriOkuma, musteriYazma;
	musteriOkuma.open("Musteriler.txt", ios::in); musteriYazma.open("gecici.txt", ios::out | ios::app);

	if (musteriOkuma.is_open() == 1) { // Uzerine yazarak silinme metodu kullanildi.
		if (musteriYazma.is_open() == 1) {
			while (musteriOkuma >> isim >> soyIsim >> tc >> tel) {
				if (tc != tcNo) {
					musteriYazma << isim << " " << soyIsim << " " << tc << " " << tel << endl;
				}
			}
		}
	}
	/*DOSYALAMA BITIS*/
	musteriOkuma.close(); musteriYazma.close();
	remove("Musteriler.txt"); rename("gecici.txt", "Musteriler.txt");
}

void Musteri::kaydet()
{
	Tarih tarih; // Tarih yazdirma ile ilgili fonksiyonlar yapilamadigi icin bos gecildi.
	std::fstream dosya; dosya.open("Musteriler.txt", std::fstream::in | std::fstream::out | std::fstream::app);

	if (dosya.is_open() == true) {
		dosya << isimGetir() << " " << soyisimGetir() << " " << " " << tcnoGetir() << " " << telnoGetir() << " " << /*tarih.gunGetir() << " " << tarih.ayGetir << " " << tarih.yilGetir <<*/ endl;
	} dosya.close();
}

string	Musteri::tcnouret() {
	string tcno = "";

	for (int i = 0; i < 4; i++) {
		tcno += '1' + rand() % 9;
	}
	return tcno;
}

std::string	Musteri::telnoUret() {
	std::string telno = "";

	for (int i = 0; i < 10; i++) {
		telno += '0' + rand() % 10;
	}
	return telno;
}

Musteri::Musteri() { // Rastgele musteri bilgisi olusturuldu.
	srand(time(NULL));
	int index1 = rand() % 40, index2 = rand() % 20;

	mIsim = isimlerListesi[index1]; mSoyisim = soyisimlerListesi[index2];
	mTcno = tcnouret();
	mTelno = telnoUret();
}

void Musteri::isimAta(std::string isim) {
	mIsim = isim;
}

void Musteri::soyisimAta(string soyIsim) {
	mSoyisim = soyIsim;
}

void Musteri::tcnoAta(string tcNo) {
	mTcno = tcNo;
}

void Musteri::telnoAta(string telNo) {
	mTelno = telNo;
}

string	Musteri::tcnoGetir() {
	return mTcno;
}

string	Musteri::telnoGetir() {
	return mTelno;
}
string	Musteri::isimGetir() {
	return mIsim;
}

std::string	Musteri::soyisimGetir() {
	return mSoyisim;
}