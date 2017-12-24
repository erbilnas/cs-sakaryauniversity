#include <iostream>
#include <string>
#include "Dugum.h"

using namespace std;

Dugum* Dugum::sonrakiniVer()
{
	return sonraki;
}

int Dugum::rakamiVer()
{
	return rakam;
}

void Dugum::rakamiDegistir(int a)
{
	rakam = a;
}

void Dugum::sonrakiniDegistir(Dugum *a)
{
	sonraki = a;
}