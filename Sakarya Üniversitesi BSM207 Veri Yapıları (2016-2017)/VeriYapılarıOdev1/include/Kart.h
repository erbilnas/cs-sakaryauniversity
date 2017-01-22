#ifndef KART_H
#define KART_H
#include "Sembol.h"
////////////////////////////////////
class Kart
{
private:
	int kartrengi;
public:
	Sembol *semboltemp;
	void getrenk(int);
	int printrenk();
	void changesembol(int, int, Kart semboldizi[]);
	void changerenk(int, int, Kart renkdizi[]);
	void semboltersdondur(int, Kart kartsemboldizi[]);
	void renktersdondur(int, Kart kartrenkdizi[]);
	Kart();
};
#endif
