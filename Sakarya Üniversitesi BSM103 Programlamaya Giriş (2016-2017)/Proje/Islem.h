#ifndef ISLEM_H
#define ISLEM_H

#include <string>

using namespace std;

class Islem // Dokumantasyondaki header dosyasi kullanildi.
{
public:
	Islem();

	string tc_no;
	string urunKodu;
	string islemKoduUret();
	string urunKoduGetir();
	string tcNoGetir();
	string islemKoduGetir();
	void urunKoduAta(string kod);
	void tcNoAta(string tcno);
	void kaydet();
	void islemSilme();
private:
	string  mIslemKodu;
	string	mUrunKodu;
	string  mMusteriTcNo;
};
#endif ISLEM_H