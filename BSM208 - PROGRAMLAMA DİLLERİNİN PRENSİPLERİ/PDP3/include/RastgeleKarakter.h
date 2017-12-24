#ifndef RASTGELEKARAKTER_H
#define RASTGELEKARAKTER_H

#include "Random.h"

// Rastgelekarakter sinifi icin struct olusturuldu.
struct RASTGELEKARAKTER{
	// Random sinifindan kalitim almis gibi
	Random rand;
};

typedef struct RASTGELEKARAKTER* RastgeleKarakter;

// Fonksiyon prototipleri yazildi.
RastgeleKarakter RastgeleKarakterOlustur();
char RandomChar(RastgeleKarakter);
char* RandChars(RastgeleKarakter, unsigned);
char RandCharBetween(RastgeleKarakter, char, char);
char* RandCharsBetween(RastgeleKarakter, char, char, unsigned);
char Choice(RastgeleKarakter, char*);
char* Choices(RastgeleKarakter, char*, unsigned);
char* Sentence(RastgeleKarakter);
void RastgeleKarakterYoket(RastgeleKarakter);

#endif
