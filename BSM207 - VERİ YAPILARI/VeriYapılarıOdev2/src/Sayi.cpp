#include <iostream>
#include <string>
#include "Sayi.h"
#include "BagilListe.h"

using namespace std;

void Sayi::stringiListeyeEkle(string a,BagilListe *&liste)
{
	for(int i = 0; i < a.size() ; i++) 
	{
		char ch = a[i];
		int rakam = ch - '0';
		liste->ekle(rakam);
	}
}