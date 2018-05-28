#ifndef TARIH_H
#define TARIH_H

#include <string>

using namespace std;

class Tarih // Tarih bilgilerinin olusturulmasi icin yeni bir header dosyasi hazirlandi.
{
public:
	Tarih();

	string gunUret();
	string ayUret();
	string yilUret();
	string tarihUret();
	string gunGetir();
	string ayGetir();
	string yilGetir();
	string tarihGetir();
	void gunAta(string gun);
	void ayAta(string ay);
	void yilAta(string yil);
	void tarihAta(string tarih);
private:
	string mGun;
	string mAy;
	string mYil;
	string mTarih;
};
#endif TARIH_H