/********************************************************************************************************************
** SAKARYA ÜNİVERSİTESİ
** BİLGİSAYAR VE BİLİŞİM BİLİMLERİ FAKÜLTESİ
** BİLGİSAYAR MÜHENDİSLİĞİ BÖLÜMÜ
** PROGRAMLAMAYA GİRİŞ DERSİ
** 2015-2016 GÜZ DÖNEMİ
**
** ÖDEV NUMARASI..........: 3
** ÖĞRENCİ ADI............: ERBİL NAS
** ÖĞRENCİ NUMARASI.......: B151210053
** DERSİN ALINDIĞI GRUP...: C GRUBU
**
** ÖDEVİN KONUSU..........: GİRİLEN N DEĞERİNİ ÖZYİNELEMELİ/YİNELEMELİ FONKSİYONA SOKMA, 
**			    KOORDİNATLARI GİRİLEN DİKDÖRTGENİN İÇİNDEKİ NOKTAYI HESAPLAMA, 
**			    POİNTER KULLANARAK BÜYÜK/KÜÇÜK HARF DEĞİŞİMİ VE İKİ KARAKTER DİZİSİNİN YERİNİ DEĞİŞTİRME
********************************************************************************************************************/

#include <iostream>
using namespace std;

int yineleme(int n);
double alan(struct dikdortgen); // Fonksiyonların prototipleri tanımlandı.
bool nokta(struct dikdortgen);

void degistir(char *dizi);
void yer_degistir(char **dizi1, char **dizi2);

int n, islem = 0; // Genel değişkenler tanımlandı.

char degisim[] = "TurkiyE";
char *Dizi1 = "C++", *Dizi2 = "Programlama";

struct dikdortgen // Dikdörtgen bilgilerinin tutulacağı yapı oluşturuldu.
{
	int x, y;
	int xkose, ykose;
	int en, boy;
} dikdortgen;

void secim() // Seçim menüsü için void() fonksiyonu oluşturuldu.
{
	cout << "1. Ozyinelemeli/Yinelemeli fonksiyon" << endl;
	cout << "2. Dikdortgen yapisi" << endl;
	cout << "3. Buyuk-Kucuk harf degisimi" << endl;
	cout << "4. Iki karakter dizisinin yer degisimi" << endl;
	cout << "5. Programdan cikis" << endl;
	cout << "Lutfen bir islem seciniz: "; cin >> islem;
	
	switch (islem)
		{
		case 1:
			cout << "Bir n degeri giriniz: "; cin >> n;
			cout << "Ozyinelemeli F(" << n << "):" << yineleme(n) << endl;
			cout << "Yinelemeli F(" << n << "):" << yineleme(n) << endl;
			break;
		case 2:
			cout << "Dikdortgenin kose kordinatlarini giriniz: " << endl;
			cin >> dikdortgen.xkose;
			cin >> dikdortgen.ykose;
			cout << "Dikdortgenin en ve boy bilgilerini giriniz: " << endl;
			cin >> dikdortgen.en;
			cin >> dikdortgen.boy;
			cout << "Nokta kordinatlarini giriniz: " << endl;
			cin >> dikdortgen.x;
			cin >> dikdortgen.y;
			cout << "Dikdortgenin alani: " << alan(dikdortgen) << endl;
			cout << "Belirttiginiz nokta dikdortgenin icinde mi?:\t" << nokta(dikdortgen) << endl;
			break;
		case 3:
			cout << "Dizinin ilk hali: " << degisim << endl; degistir(degisim);
			cout << "Dizinin son hali: " << degisim << endl;
			break;
		case 4:
			cout << "\nIlk Dizi: " << Dizi1 << endl << "Ikinci Dizi: " << Dizi2 << endl << endl; yer_degistir(&Dizi1, &Dizi2);
			cout << "Ilk Dizi: " << Dizi1 << endl << "Ikinci Dizi: " << Dizi2 << endl;
			break;
		case 5:
			break;
		default:
			cout << "Hatali islem secimi yaptiniz. Lutfen tekrar deneyiniz.\a" << endl;
			break;
		}
}

int yineleme(int n) // Özyinelemeli/yinelemeli fonksiyon oluşturuldu.
{
	if (n == 0)
	{
		return 1;
	}
	else if (n == 1)
	{
		return 2;
	}
	else if (n > 1)
	{
		return (2 * yineleme(n - 1)) - (2 * (n - 1) * yineleme(n - 2));
	}
}

double alan(struct dikdortgen) // Dikdörtgenin alanını hesaplayan fonksiyon oluşturuldu.
{
	return dikdortgen.en * dikdortgen.boy;
}

bool nokta(struct dikdortgen) // Girilen noktanın dikdörtgenin içinde mi, dışında mı olduğunu bulan fonksiyon oluşturuldu.
{
	if (dikdortgen.xkose < dikdortgen.x && dikdortgen.x < dikdortgen.xkose + dikdortgen.en && dikdortgen.ykose < dikdortgen.y && dikdortgen.y < dikdortgen.ykose + dikdortgen.boy)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

void degistir(char *dizi) // //Dizideki karakterleri büyük ise küçülten, küçük ise büyülten fonksiyon oluşturuldu.
{
	for (int i = 0; i < 7; i++)
	{
		if (dizi[i] >= 65 && dizi[i] <= 90)
		{
			dizi[i] += 32;
		}
		else if (dizi[i] <= 122 && dizi[i] >= 97)
		{
			dizi[i] -= 32;
		}
	}
}

void yer_degistir(char **dizi1, char **dizi2) // Dizilerin yerini değiştiren fonksiyon oluşturuldu.
{
	char *gecici_ptr = nullptr;
	gecici_ptr = *dizi1;
	*dizi1 = *dizi2;
	*dizi2 = gecici_ptr;
}

int main()
{
	while(islem != 5) // Programın 5 no'lu seçenek seçilene kadar açık kalması sağlandı.
	{
		system("cls");
		secim(); // Seçim menüsünün bulunduğu fonksiyon çağırıldı.
		system("pause");
	}
	return 0;
}
