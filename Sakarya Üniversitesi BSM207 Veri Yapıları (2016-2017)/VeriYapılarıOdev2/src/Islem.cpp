#include <iostream>
#include <string>
#include "Sayi.h"
#include "BagilListe.h"
#include "Islem.h"

using namespace std;

Islem::Islem()
{
	Sayi *a = new Sayi;
	
	BagilListe *liste1 = new BagilListe;
	BagilListe *liste2 = new BagilListe;
	string alinan1;
	
	cout << "X : "; cin >> alinan1;
	a->stringiListeyeEkle(alinan1,liste1);
	string alinan2;
	
	cout << "Y : "; cin >> alinan2;
	a->stringiListeyeEkle(alinan2,liste2);

	cout << "\nX listesi : "; cout<<*liste1;
	cout << "\nY listesi : "; cout<<*liste2;
	
	BagilListe *k = (*liste1+*liste2);
	cout << "\n   X+Y    = "; cout<<*k;
	
	delete a;
	delete []liste1;
	delete []liste2;
}
