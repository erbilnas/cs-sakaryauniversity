#ifndef MUSTERI_H
#define MUSTERI_H

#include <string>

using namespace std;

class Musteri // Dokumantasyondaki header dosyasi kullanildi.
{
public:
	Musteri();

	string tcnouret();
	string telnoUret();
	string tcnoGetir();
	string telnoGetir();
	string isimGetir();
	string soyisimGetir();
	string tcNo;
	void isimAta(string isim);
	void telnoAta(string telno);
	void tcnoAta(string tcno);
	void soyisimAta(string soyisim);
	void musteriSilme();
	void kaydet();
private:
	string mIsim;
	string mSoyisim;
	string mTcno;
	string mTelno;
};
#endif MUSTERI_H