#include "Kart.h"
#include "Sembol.h"
#include <cstdlib>
////////////////////////////////////
void Kart::getrenk(int rastgelerenk)
{
	rastgelerenk = rand() % 13 + 1;
	kartrengi = rastgelerenk;
}
int Kart::printrenk()
{
	return kartrengi;
}
////////////////////////////////////
void Kart::changesembol(int a, int b, Kart semboldizi[])
{
	Kart temp;
	temp = semboldizi[a - 1];
	semboldizi[a - 1] = semboldizi[b - 1];
	semboldizi[b - 1] = temp;
}
void Kart::changerenk(int a, int b, Kart renkdizi[])
{
	Kart temp;
	temp = renkdizi[a - 1];
	renkdizi[a - 1] = renkdizi[b - 1];
	renkdizi[b - 1] = temp;
}
////////////////////////////////////
void Kart::semboltersdondur(int a,Kart kartsemboldizi[])
{
	Kart temp;
	for (int i = 0;i < a;i++)
	{
		temp = kartsemboldizi[a - 1];
		kartsemboldizi[a - 1] = kartsemboldizi[i];
		kartsemboldizi[i] = temp;
		a--;
	}
}
void Kart::renktersdondur(int a, Kart kartrenkdizi[])
{
	Kart temp;
	for (int i = 0;i < a;i++)
	{
		temp = kartrenkdizi[a - 1];
		kartrenkdizi[a - 1] = kartrenkdizi[i];
		kartrenkdizi[i] = temp;
		a--;
	}
}
////////////////////////////////////
Kart::Kart()
{
	semboltemp = new Sembol();
}
