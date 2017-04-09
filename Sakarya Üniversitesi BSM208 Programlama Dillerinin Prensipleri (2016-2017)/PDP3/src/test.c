#include "RastgeleKarakter.h"

int main(){
	// Degiskenler tanimlandi
	int i;
	char *dizi = "gyucne";

	// Sinif(Sahte) olusturuldu.
	RastgeleKarakter rast = RastgeleKarakterOlustur();
	
	// Rastgele Karakter ekrana bastirildi.
	printf("Rastgele Karakter: %c\n", RandomChar(rast));
	printf("Rastgele Karakter: %c\n", RandomChar(rast));

	// Rastgele 3 Karakter ekrana bastirildi.
	printf("Rastgele 3 Karakter: %s\n", RandChars(rast, 3));
	printf("Rastgele 3 Karakter: %s\n", RandChars(rast, 3));

	// Verilen 2 karakter arasindan secim yapildi.
	printf("Verilen iki karakter(a,k): %c\n", RandCharBetween(rast, 'a', 'k'));
	
	printf("Verilen iki karakter(a,k): %s\n", RandCharsBetween(rast, 'a', 'k', 2));

	// Belirtilen karakterler arasından secim yapildi.
	printf("Belirtilen Karakterler(g,y,u,c,n,e): %c\n", Choice(rast, dizi));
	printf("Belirtilen Karakterler(g,y,u,c,n,e): %c\n", Choice(rast, dizi));
	printf("Belirtilen Karakterler(g,y,u,c,n,e): %s\n", Choices(rast, dizi, 2));

	// Rastgele cumle yazildi.
	printf("Cumle: %s.\n", Sentence(rast));

	printf("\n------------------------------------------\n\nRastgele 100 Karakter:");
	
	// Rastgele oldugunun kanitlanmasi icin ekrana 100 adet karakter basildi
	for(i = 0; i < 100; i++)
		printf("%c", RandomChar(rast));

	printf("\n");

	// RastgeleKarakter sinifini yokettik.
	RastgeleKarakterYoket(rast);


	getchar(); 
	return 0;
}
