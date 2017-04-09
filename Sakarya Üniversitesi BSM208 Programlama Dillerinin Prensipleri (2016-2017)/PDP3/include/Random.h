#ifndef RANDOM_H
#define RANDOM_H

#include <stdio.h>
#include <stdlib.h>
#include <time.h>

// Random class i icin struct olusturuldu.
struct RANDOM{
	unsigned previous;
	unsigned short lfsr;
	unsigned bit;
};

typedef struct RANDOM* Random;

// Fonksiyon prototipleri yazildi.
Random RandomOlustur();
int system_clock();
unsigned RandomUret(const Random, unsigned);
void RandomYoket(Random);

#endif
