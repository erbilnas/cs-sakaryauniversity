#include "Sembol.h"
////////////////////////////////////
void Sembol::getsembol(int i)
{
	sembol = char(i % 6 + 1);
}
char Sembol::printsembol()
{
	return sembol;
}
