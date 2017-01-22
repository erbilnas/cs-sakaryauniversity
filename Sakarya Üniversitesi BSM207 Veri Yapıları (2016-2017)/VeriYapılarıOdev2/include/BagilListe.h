#ifndef BAGILLISTE_H
#define BAGILLISTE_H

#include <iostream>
#include <string>
#include "Dugum.h"

using namespace std;

class BagilListe 
{
private:
	Dugum *listeBasi;
	int uzunluk;
public:
	BagilListe();
	void listeBasiniDegistir(Dugum *a);
	void ekle(int a);
	bool isEmpty();
	int uzunlukDon();
	string yazdir();
	Dugum* basiDon();
	Dugum* indextekiniVer(int i);
	BagilListe *tersCevir(BagilListe *b);
	BagilListe *operator+(const  BagilListe  b);  
	friend ostream &operator<<( ostream &output, const BagilListe  &D ); 
};
#endif