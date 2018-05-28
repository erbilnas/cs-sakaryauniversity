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
** ÖDEVİN KONUSU..........: GİRİLEN BİR SAYININ İÇİNDEKİ TEK SAYILARI BULAN VE EKRANA YAZAN PROGRAM
********************************************************************************************************************/

#include <iostream>
using namespace std;

int main()
{
	int oddNumber; // Defined an integer and a char value.
	char a;

	cout << "Enter a number....: ";
	cout << endl;

	while (a = getchar()) // On while loop, I used getchar() function.
	{
		if (a >= '0' && a <= '9') // Char 'a' has been controlled between 0 and 9.
		{
			oddNumber = a - '0';
			if (oddNumber % 2 != 0) // If a value can't divided by 2, this mean it's a odd number.
			{
				cout << oddNumber;
			}
		}
	}
	return 0;
}