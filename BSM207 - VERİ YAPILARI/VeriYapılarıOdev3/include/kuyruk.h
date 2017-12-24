#ifndef KUYRUK_H
#define KUYRUK_H

#include <iostream>
using namespace std;

class dugum {
public:
	int girdi;
	dugum *sonraki;
};

class bagliKuyruk {
private:
	dugum *ilk, *son;
	int kapasite;
public:
	bagliKuyruk() {
		kapasite = 0;
		ilk = NULL; son = NULL;
	}

	int toplamaKuyruk() {
		int toplama = 0;
		toplama = ilk->girdi;
		
		dugum *a = ilk;
		ilk = ilk->sonraki;

		if (bosMu()) {}
		else {
			delete a;
		}
		kapasite--;

		return toplama;
	}

	void ekle(int a) {
		dugum *ikinciDugum = new dugum();
		ikinciDugum->girdi = a;
		ikinciDugum->sonraki = NULL;

		if (bosMu()) {
			ilk = ikinciDugum;
			son = ikinciDugum;
		}
		else {
			son->sonraki = ikinciDugum;
			son = ikinciDugum;
		}
		kapasite++;
	}

	bool bosMu() {
		return ilk == NULL;
	}

	int uzunluk() {
		return kapasite;
	}
};
#endif