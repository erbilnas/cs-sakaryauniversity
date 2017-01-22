#include "Urun.h"
#include <iostream> 
#include <string>
#include <fstream>
#include <cstdlib>
#include <time.h>

using namespace std;

string urunListesi[] = { "Ekran_karti","Ses_Karti","Islemci","Klavye","Fare","Monitor","Ram","Sabit_Disk","Hoparlor","SSD_Disk","Notebook","Kasa","Flash_Disk","Tablet","Cep_Telefonu","Kulaklik","Yazici","Scanner","Optik_Okuyucu","Tv_Karti" };

void Urun::urunSilme() { // Urun sinifindan kalitilarak urunSilme fonks. olusturuldu.
	string urun, uKodu, uFiyati;

	fstream urunOkuma, urunYazma;
	urunOkuma.open("Urunler.txt", ios::in); urunYazma.open("gecici.txt", ios::in | ios::app);
	if (urunOkuma.is_open() == 1) {
		if (urunYazma.is_open() == 1) { // Urunlerin silinmesinde uzerine yazma metodu kullanildi.
			while (urunOkuma >> urun >> uKodu >> uFiyati) {
				if (uKodu != mUrunKodu) {
					urunYazma << urun << " " << uKodu << " " << uFiyati << endl;
				}
			}
		}
	}
	/*DOSYALAMA BITIS*/
	urunOkuma.close(); urunYazma.close();
	remove("Urunler.txt"); rename("gecici.txt", "Urunler.txt");
}

void Urun::kaydet() { // Dosya uzerine yazma isi halledildi.
	std::fstream dosya; dosya.open("Urunler.txt", std::fstream::in | std::fstream::out | std::fstream::app);

	if (dosya.is_open() == true) {
		dosya << urunAdiGetir() << " " << urunKoduGetir() << " " << fiyatGetir() << endl;
	} dosya.close();
}

string	Urun::urunKoduUret() { // Rastgele urun kodu uretildi.
	string urunKod = "";

	for (int i = 0; i < 4; i++) { // Urun kodunun uretilmesi icin for dongusu kuruldu ve dongunun bes kere donmesi saglandi.
		urunKod += '1' + rand() % 20;
	}
	return urunKod;
}

int Urun::fiyatGetir() { // Fiyat olusturuldu.
	srand(time(NULL));
	mFiyat = 200 + rand() % 50;
	return mFiyat;
}

Urun::Urun() { // Urunlerin rastgele olarak indexten cekilmesi saglandi.
	srand(time(NULL));
	int index = rand() % 20;
	mUrunAdi = urunListesi[index];
	mUrunKodu = urunKoduUret();
	mFiyat = fiyatGetir();
}

string Urun::urunKoduGetir() {
	return mUrunKodu;
}

string Urun::urunAdiGetir() {
	return mUrunAdi;
}

void Urun::urunAdiAta(std::string urunAdi) {
	mUrunAdi = urunAdi;
}

void Urun::urunKoduAta(std::string  urunkodu) {
	mUrunKodu = urunkodu;
}

void Urun::fiyatAta(int fiyat) {
	mFiyat = fiyat;
}