#include "RastgeleKarakter.h"


// RastgeleKarakter sinifi icin olusturma fonksiyonu
RastgeleKarakter RastgeleKarakterOlustur(){
	RastgeleKarakter this;
	this = (RastgeleKarakter)malloc(sizeof(struct RASTGELEKARAKTER));
	this->rand = RandomOlustur();

	return this;
}

// Rastgele karakter ureten fonksiyon
char RandomChar(RastgeleKarakter rastgele){
	unsigned randNumber = RandomUret(rastgele->rand, 122);

	while(randNumber < 65 || randNumber > 122 || (randNumber < 97 && randNumber > 90))
		randNumber = RandomUret(rastgele->rand, 122);

	return (char)randNumber;
}

// Rastgele karakterler üreten fonksiyon
char* RandChars(RastgeleKarakter rastgele, unsigned adet){
	int i;
	char *dizi = (char *)malloc(sizeof(char) * adet);

	for(i = 0; i < adet; i++)
		dizi[i] = RandomChar(rastgele);

	return dizi;
}

// Iki karakter arasindan rastgele karakter secen fonksiyon
char RandCharBetween(RastgeleKarakter rastgele, char ilk, char son){
	unsigned number = RandomUret(rastgele->rand, 122);

	while(number < (int)ilk || number > (int)son || (number < 97 && number > 90))
		number = RandomUret(rastgele->rand, 122);
	
	return (char)number;
}

// Iki karakter arasindan rastgele karakterler secen fonksiyon
char* RandCharsBetween(RastgeleKarakter rastgele, char ilk, char son, unsigned adet){
	unsigned number = RandomUret(rastgele->rand, 122);
	unsigned i;
	char *dizi = (char *)malloc(sizeof(char) * adet); 

	for(i = 0; i < adet; i++){
		while(number < (int)ilk || number > (int)son)
			number = RandomUret(rastgele->rand, 122);
		dizi[i] = (char)number;
		number = RandomUret(rastgele->rand, 122);
	}
	dizi[adet] = '\0';
	return dizi;
}

// Verilen dizi arasindan rastgele karakter secen fonksiyon
char Choice(RastgeleKarakter rastgele, char* dizi){
	unsigned uzunluk = (sizeof(dizi) / sizeof(dizi[0])) - 1;
	unsigned number = RandomUret(rastgele->rand, uzunluk);

	while(number < 0 || number >= uzunluk || number == 6)
		number = RandomUret(rastgele->rand, uzunluk);

	return (char)dizi[number];
}

// Verilen dizi arasindan rastgele karakterler secen fonksiyon
char* Choices(RastgeleKarakter rastgele, char* dizi, unsigned adet){
	unsigned uzunluk = (sizeof(dizi) / sizeof(dizi[0])) - 1;
	unsigned number = RandomUret(rastgele->rand, uzunluk);
	unsigned i;
	char *d = (char *)malloc(sizeof(char) * adet);

	for(i = 0; i < adet; i++){
		while(number < 0 || number >= uzunluk || number == 6)
			number = RandomUret(rastgele->rand, uzunluk);
		d[i] = dizi[number];
		number = RandomUret(rastgele->rand, uzunluk);
	}
	d[adet] = '\0';
	return d;
	
}

// Rastgele cumle yazdiran fonksiyon
char* Sentence(RastgeleKarakter rastgele){
	int sen_len = RandomUret(rastgele->rand, 15) + 5;
	int i=0,j;
	char *dizi = (char *)malloc(sizeof(char) * 17);

	for(i = 0; i < 5; i++){
		dizi[i] = RandomChar(rastgele);
	}
	
	dizi[5] = ' ';

	for(i = 6; i < 8; i++){
		dizi[i] = RandomChar(rastgele);
	}

	dizi[8] = ' ';

	for(i = 9; i < 12; i++)
		dizi[i] = RandomChar(rastgele);

	dizi[12] = ' ';

	for(i = 13; i < 17; i++)
		dizi[i] = RandomChar(rastgele);
	
	dizi[i] = '\0';
	return dizi;
}

// Sinifi yokedecek olan fonksiyon
void RastgeleKarakterYoket(RastgeleKarakter rastgele){
	if(rastgele == NULL) return;
	free(rastgele->rand);
	rastgele->rand = NULL;
	free(rastgele);
	rastgele = NULL;
}
