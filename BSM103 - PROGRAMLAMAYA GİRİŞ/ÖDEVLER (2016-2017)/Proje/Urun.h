#ifndef URUN_H
#define URUN_H

#include <string>

using namespace std;

class Urun // Dokumantasyondaki header dosyasi kullanildi.
{
public:
	Urun();
	
	string urunKoduUret();
	string mUrunKodu;
	string mUrunAdi;
	string urunAdiGetir();
	string urunKoduGetir();
	int	fiyatGetir();
	int mFiyat;
	void urunAdiAta(string urunAdi);
	void urunKoduAta(string urunkodu);
	void fiyatAta(int fiyat);
	void urunSilme();
	void kaydet();
private:
};
#endif URUN_H