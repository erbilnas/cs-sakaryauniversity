#include <iostream>      
#include <fstream>	  
#include <string>
#include "kuyruk.h"
#include "agac.h"

using namespace std;

int main()
{
	bagliKuyruk *liste = new bagliKuyruk();
	ikiliAgac *agac = new ikiliAgac();

	ifstream dosyaOku("sayilar.txt");
	while (true) {
		string a;
		dosyaOku >> a;
		int array[100];

		for (int i = 0; i < a.size(); i++) {
			char ch = a[i];
			int sayi = ch - '0';
			array[i] = sayi;
		}

		for (int i = 0; i < a.size(); i++) {
			liste->ekle(array[i]);
		}

		int toplam = 0;
		while (liste->uzunluk() != 0) {
			toplam = toplam + liste->toplamaKuyruk();
		}

		agac->ekleme(toplam);

		if (dosyaOku.eof()) {
			dosyaOku.close();
			break;
		}
	}

	cout << "inorder:" << endl; agac->inorder();
	cout << endl << "preorder:" << endl; agac->preorder();
	cout << endl << "postorder:" << endl; agac->postorder();

	cin.get();
	cin.ignore();
	return 0;
}