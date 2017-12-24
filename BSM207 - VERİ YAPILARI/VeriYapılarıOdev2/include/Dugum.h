#ifndef DUGUM_H
#define DUGUM_H

#include <iostream>
#include <string>

using namespace std;

class Dugum
{	
private:
	int rakam;
	Dugum *sonraki;
public:
	void rakamiDegistir(int a);
	void sonrakiniDegistir(Dugum *a);
	int rakamiVer();
	Dugum* sonrakiniVer();
};
#endif  