#include <iostream>
#include <string>
#include "BagilListe.h"
#include "Sayi.h"

using namespace std;

BagilListe::BagilListe()
{
	uzunluk = 0;
}

Dugum* BagilListe::basiDon()
{
	return listeBasi;
}

int BagilListe::uzunlukDon()
{
	return uzunluk;
}

void BagilListe::listeBasiniDegistir(Dugum *a)
{
	listeBasi = a;
}

void BagilListe::ekle(int a)
{

	if (uzunluk == 0)
	{
		Dugum *bas = new Dugum;
		bas->rakamiDegistir(a);
		bas->sonrakiniDegistir(NULL);
		listeBasi = bas;
		uzunluk++;
	}
	else
	{
		Dugum *simdiki = listeBasi;
		Dugum *onceki = listeBasi;
		for(int i = 0; i < uzunluk ; i++)
		{
			simdiki = simdiki->sonrakiniVer();
			if(i > 0)
				onceki = onceki->sonrakiniVer();
		}
		simdiki = new Dugum;
		simdiki->rakamiDegistir(a);
		simdiki->sonrakiniDegistir(NULL);
		onceki->sonrakiniDegistir(simdiki);
		uzunluk++;
	}
}

string BagilListe::yazdir()
{
	Dugum *simdiki = listeBasi;
	string sonuc = "";
	for(int i = 0; i < uzunluk ; i++)
	{
		if(i != uzunluk-1)
			sonuc += simdiki->rakamiVer() + "-";
		else
			sonuc += simdiki->rakamiVer();
		simdiki = simdiki->sonrakiniVer();
	}
	return sonuc;
}

bool BagilListe::isEmpty()
{
	if (uzunluk == 0)
		return true;
	else
		return false;
}
Dugum* BagilListe::indextekiniVer(int i)
{
	Dugum *simdiki  = listeBasi;
	for(int y = 0; y < i ; y++)
	{
		simdiki  = simdiki->sonrakiniVer();
	}
	return simdiki;
}

BagilListe *BagilListe::operator+( BagilListe b)
{
	BagilListe *list = new BagilListe;

	int uzunluk1 = this->uzunlukDon();
	int uzunluk2 = (&b)->uzunlukDon();
	int uzunluk = 0;

	if(uzunluk1 < uzunluk2)
		uzunluk = uzunluk1;
	else
		uzunluk = uzunluk2;

	Dugum *simdiki1 = this->indextekiniVer(uzunluk1-1);
	Dugum *simdiki2 = (&b)->indextekiniVer(uzunluk2-1);

	int artanOnceki = 0;
	int artanSimdiki = 0;
	int rakam1;
	int rakam2;
	int rakam3;

	for(int i = 0; i < uzunluk ; i++)
	{
		rakam1 = simdiki1->rakamiVer();
		rakam2 = simdiki2->rakamiVer();
		rakam3 = rakam1+rakam2;

		if(rakam3+artanOnceki < 10)
		{
			list->ekle(rakam3+artanOnceki);
		}
		else
		{
			artanSimdiki = 1;
			list->ekle(rakam3+artanOnceki - 10);
		}
		artanOnceki = artanSimdiki;
		artanSimdiki = 0;
		simdiki1 = this->indextekiniVer(uzunluk1-i-2);
		simdiki2 = (&b)->indextekiniVer(uzunluk2-i-2);
	}

	if(uzunluk1 > uzunluk)
	{
		simdiki1 = this->indextekiniVer(uzunluk1-uzunluk-1);
		for(int p = uzunluk1-uzunluk-1; p >=0 ; p--)
		{
			rakam1 = simdiki1->rakamiVer();

			if(artanOnceki != 0)
			{
				list->ekle(rakam1+artanOnceki);
				artanOnceki = 0;
			}
			else
			{
				list->ekle(rakam1);
			}
			if(p != 0)
				simdiki1 = this->indextekiniVer(p-1);

		}
	}
	else if(uzunluk2 > uzunluk)
	{
		simdiki2 = (&b)->indextekiniVer(uzunluk2-uzunluk-1);
		for(int t = uzunluk2-uzunluk-1; t >=0 ; t--)
		{
			rakam2 = simdiki2->rakamiVer();
			if(artanOnceki != 0)
			{
				list->ekle(rakam2+artanOnceki);
				artanOnceki = 0;
			}
			else
			{
				list->ekle(rakam2);
			}
			if(t != 0)
				simdiki2 = (&b)->indextekiniVer(t-1);
		}

	}
	else
	{
		if(artanOnceki != 0)
			{
				list->ekle(artanOnceki);
				artanOnceki = 0;
			}
	}

	return list->tersCevir( list);
}

BagilListe *BagilListe::tersCevir(BagilListe *b)
{
	BagilListe *yeni = new BagilListe;
	for(int t = b->uzunlukDon()-1; t >= 0  ; t--)
	{
		yeni->ekle(b->indextekiniVer(t)->rakamiVer());
	}
	delete [](&b);
	return yeni;
}

ostream &operator<<( ostream &output, const BagilListe  &D )
{
	Dugum *simdiki = D.listeBasi;

	for(int i = 0; i < D.uzunluk ; i++)
	{
		if(i != D.uzunluk-1)
			output << simdiki->rakamiVer() << "-";
		else
			output << simdiki->rakamiVer();
		simdiki = simdiki->sonrakiniVer();
	}

	return output;
}