#include "Random.h"

// Random class i icin olusturma fonksiyonu yazildi.
Random RandomOlustur(){
	Random this;
	this = (Random)malloc(sizeof(struct RANDOM));
	this->lfsr = 0xACE1u;
	this->previous = 0;
	this->bit = 0x00000;
	return this;
}

// Sistem clock unu alabilmek icin fonksiyon yazildi.
int system_clock(){
	clock_t t1;
	t1 = clock();
	return t1;
}

// Rastgele sayi ureten fonksiyon yazildi.
unsigned RandomUret(const Random r, unsigned max){
	r->bit = ((r->lfsr >> 0) ^ (r->lfsr >> 2) ^ (r->lfsr >> 3) ^ (r->lfsr >> 5) ) & 1;
	r->lfsr = (r->lfsr >> 1) | (r->bit << 15);
	r->previous = r->lfsr;
	return (r->lfsr * (unsigned)system_clock()) % max;
}

// Yoket fonksiyonu yazildi.
void RandomYoket(Random r){
	if(r == NULL) return;
	free(r);
	r = NULL;
}
