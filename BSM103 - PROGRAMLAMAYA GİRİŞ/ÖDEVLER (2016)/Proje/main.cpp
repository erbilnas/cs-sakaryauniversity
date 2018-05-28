/********************************************************************************************************************
** SAKARYA ÜNİVERSİTESİ
** BİLGİSAYAR VE BİLİŞİM BİLİMLERİ FAKÜLTESİ
** BİLGİSAYAR MÜHENDİSLİĞİ BÖLÜMÜ
** PROGRAMLAMAYA GİRİŞ DERSİ
** 2016-2017 GÜZ DÖNEMİ
**
** ÖDEV NUMARASI..........: PROJE/TASARIM
** ÖĞRENCİ ADI............: ERBİL NAS
** ÖĞRENCİ NUMARASI.......: B151210053
** DERSİN ALINDIĞI GRUP...: D GRUBU
**
** ÖDEVİN KONUSU..........: MÜŞTERİ EKLEME YA DA ÇIKARMA YAPABİLEN, MÜŞTERİLERİN ALDIĞI ÜRÜNLERİ LİSTELEYEBİLEN,
**                          LİSTEDEKİ ÜRÜNLERİ DOSYALAYABİLEN, ADMİN PANELİNE SAHİP, TEMEL DÜZEY KONTROL PANELİ YAZILIMI
********************************************************************************************************************/

#include "Musteri.h"
#include "Urun.h"
#include "Islem.h"
#include "Kontrol.h"
#include "Tarih.h"
#include <iostream>

using namespace std;

int main() {
	Kontrol kontrol; Musteri musteri; Islem islem; Urun urun; // Class lar cagirildi.
	kontrol.anaMenuCiz();
	
	cout << "Secim:";
	int secim, secim2;
	cin >> secim;
	switch (secim) { // Menu icin switch-case yapisi kullanildi.
			case 1:
			{
				kontrol.musteriCiz();
				cout << "Lutfen bir TC no giriniz:"; cin >> islem.tc_no;
				kontrol.musteriMenuCiz();
				cout << "Secim:"; cin >> secim2;
				switch (secim2)
				{
				case 1:
				{
					kontrol.urunCiz();
					cout << "Lutfen bir urun kodu giriniz:"; cin >> islem.urunKodu;
					islem.kaydet();
				}
				case 2:
				{
					kontrol.islemCiz();
				}
				case 3:
				{
					islem.islemSilme();
				}
				case 4:
				{
					return main(); // Menuye geri donmesi icin kullanildi.
				}
				default:
					break;
				}
			} break;

			case 2:
			{
				kontrol.yoneticiMenuCiz();
				cout << "Secim:"; cin >> secim2;

				switch (secim2)
				{
				case 1:
				{
					musteri.kaydet();
					kontrol.musteriList();
				}
				case 2:
				{
					kontrol.musteriCiz();
				}
				case 3:
				{
					kontrol.musteriCiz();
					cout << "Lutfen bir TC no giriniz:";
					cin >> musteri.tcNo;
					musteri.musteriSilme();
				}
				case 4:
				{
					urun.kaydet();
					kontrol.urunList();
				}
				case 5:
				{
					kontrol.urunCiz();
				}
				case 6:
				{
					kontrol.urunCiz();
					cout << "Lutfen bir urun kodu giriniz:";
					cin >> urun.mUrunKodu;
					urun.urunSilme();
				}
				default:
					break;
				}
			}
			break;

			case 3:
			{
				exit(1); // Uygulamanin kapanmasi icin yapildi.
				break;
			}

			default:
				break;
			}
	/*EKRANDA KALMASI ICIN*/
	cin.get();
	cin.ignore();
	return 0;
}