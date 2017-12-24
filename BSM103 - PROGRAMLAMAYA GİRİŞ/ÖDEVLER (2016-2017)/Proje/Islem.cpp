#include "Islem.h"
#include <iostream> 
#include <string>
#include <fstream>
#include <cstdlib>
#include <time.h>

using namespace std;

void Islem::islemSilme() { // Yapilan islemlerin silinmesi icin uzerine yazilma metodu kullanildi. Gecici text dosyasi olusturuldu ve silinmeyen islemler buraya aktarildi. Daha sonra ana dosya silinerek, gecici text dosyasinin adi degistirildi ve ana dosya olmasi saglandi.
	string islemkodu, urunkodu, tcno;

	fstream islemOkuma, islemYazma;
	islemOkuma.open("Islemler.txt", ios::in); islemYazma.open("gecici.txt", ios::app);
	/*DOSYALAMA BASLANGIC*/
	if (islemOkuma.is_open() == 1) {
		if (islemYazma.is_open() == 1) {
			while (islemOkuma >> islemkodu >> urunkodu >> tcno) { // Silinmeyen islemlerin korunmasi saglandi.
				if (tcno != tc_no) { // TC no'lara gore karsilastirilma yapildi.
					islemYazma << islemkodu << " " << urunkodu << " " << tcno << endl;
				}
			}
		}
	}

	islemOkuma.close(); islemYazma.close();
	remove("Islemler.txt"); rename("gecici.txt", "Islemler.txt");
	/*DOSYALAMA BITIS*/
}

void Islem::kaydet() // Yapilan islemlerin text dosyasina yazilmasi saglandi.
{
	std::fstream dosya; dosya.open("Islemler.txt", ios::in | ios::out | ios::app);

	if (dosya.is_open() == true) {
		dosya << islemKoduGetir() << " " << urunKodu << " " << tc_no << endl; // Bilgiler text dosyasina yaziliyor.
	} dosya.close();
}

string Islem::islemKoduUret() {
	string islemKodu = "";

	for (int i = 0; i < 4; i++) { // Islem kodunun uretilmesi icin for dongusu kullanildi. Bes defa donen dongu sonucunda bir kod uretildi.
		islemKodu += '1' + rand() % 9;
	}
	return islemKodu;
}

Islem::Islem() // Uretilen islem ve urun kodlari degiskenlere atandi.
{
	mIslemKodu = islemKoduUret();
	mUrunKodu = urunKoduGetir();
}

string Islem::urunKoduGetir() {
	return mUrunKodu;
}

string Islem::tcNoGetir() {
	return mMusteriTcNo;
}

string Islem::islemKoduGetir() {
	return mIslemKodu;
}

void Islem::urunKoduAta(string urunkodu) {
	mUrunKodu = urunkodu;
}

void Islem::tcNoAta(string tcno) {
	mMusteriTcNo = tcno;
}