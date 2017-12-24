/********************************************************************************************************************
** SAKARYA ÜNİVERSİTESİ
** BİLGİSAYAR VE BİLİŞİM BİLİMLERİ FAKÜLTESİ
** BİLGİSAYAR MÜHENDİSLİĞİ BÖLÜMÜ
** PROGRAMLAMAYA GİRİŞ DERSİ
** 2016-2017 GÜZ DÖNEMİ
**
** ÖDEV NUMARASI..........: 01
** ÖĞRENCİ ADI............: ERBİL NAS
** ÖĞRENCİ NUMARASI.......: B151210053
** DERSİN ALINDIĞI GRUP...: D GRUBU
**
** ÖDEVİN KONUSU..........: UZUNLUK VE GENİŞLİK DEĞERLERİ GİRİLEN DÖRTGENİ EKRANA ÇİZEN PROGRAM
********************************************************************************************************************/

#include <iostream>
using namespace std;

int main()
{
	int height = 0, width = 0;

	cout << "Enter the height of the rectangle......:"; cin >> height;

	while (height > 20) { // If height value higher than 20, user get an error message
		cout << "Height value can't be higher than 20! Please, enter a new value......:";
		cin >> height;
	}

	cout << "Enter the width of the rectangle.......:"; cin >> width;
	
	while (width > 20) { // If width value higher than 20, user get an error message
		cout << "Width value can't be higher than 20! Please, enter a new value......:";
		cin >> width;
	}

	cout << endl;

	for (int i = 0; i<height; i++) { // A for loop for creating hollow rectangle.

		for (int j = 0; j<width; j++) {

			if (i == 0 || i == height - 1 || j == 0 || j == width - 1)
				cout << "*";
			else
				cout << " ";

		}
		cout << endl;
	}

	cout << endl;
	cout << endl;

	for (int i = 0; i<width; i++) { // A for loop for creating reversed hollow rectangle.

		for (int j = 0; j<height; j++) {

			if (i == 0 || i == width - 1 || j == 0 || j == height - 1)
				cout << "*";
			else
				cout << " ";

		}
		cout << endl;
	}
    return 0;
}