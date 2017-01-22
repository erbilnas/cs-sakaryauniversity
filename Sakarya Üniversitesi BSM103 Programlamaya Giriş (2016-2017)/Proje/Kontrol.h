#ifndef KONTROL_H
#define KONTROL_H

#include<string>

using namespace std;

class Kontrol // Dokumantasyondaki header dosyasi kullanildi.
{
public:
	Kontrol();

	void anaMenuCiz();
	void tavanCiz(int genislik);
	void zeminCiz(int genislik);
	void araCiz(int genislik, string yazi);
	void ayracCiz(int genislik);
	void musteriMenuCiz();
	void yoneticiMenuCiz();
	void musteriCiz();
	void islemCiz();
	void urunCiz();
	void musteriList();
	void urunList();
};
#endif KONTROL_H