/*
** @author Alperen Kaymak alperen.kaymak@ogr.sakarya.edu.tr , Erbil Nas erbil.nas@ogr.sakarya.edu.tr
** @since 16.03.2017
**
** Rastgelelik icin olusturulan kutuphane icin test programi.
*/
package PDP2Test;

import PDP2.RastgeleKarakter;

public class PDP2Test
{
    public static void main(String[] args)
    {
//Kutuphanemizi kullanabilmek için nesne.
	RastgeleKarakter nesne = new RastgeleKarakter();
	
//Rastgele bir tane karakter olusturmak.
	System.out.println("Rastgele Karakter:" + nesne.RastChar());
	System.out.println("Rastgele Karakter:" + nesne.RastChar());
	
/*Birden fazla ve ne kadar uzunlukta girildiyse o buyuklukte bir karakter toplulugu.
**Yazdırma islemi methodun içinde oldugu icin println ile bir satır asagıya aktarıyoruz. */
	nesne.RastCharUzun(5);
	System.out.println("");
	nesne.RastCharUzun(5);
	System.out.println("");
	nesne.RastCharUzun(3);
	System.out.println("");	
	
/*Burda stringlere girilen karakterler arasinda bir karakter yazdirma yapiyoruz.
**Soldaki sayi kac tane karakter olcagini belirtiyor.
**
**Karakterler yine methodun icinde yazdiriliyor ve de stringlerde kontrol yapılabilmesi
**girilen karakter buyuk harf girilmisse kucuk harfe ceviriyoruz.*/
	String birinci="a";
	birinci=birinci.toLowerCase();
	char car1=birinci.charAt(0);
	String ikinci="k";
	ikinci=ikinci.toLowerCase();
	char car2=ikinci.charAt(0);
	nesne.AraDeger(1,car1,car2);
	System.out.println("");
	
	birinci="h";
	birinci=birinci.toLowerCase();
	car1=birinci.charAt(0);
	ikinci="z";
	ikinci=ikinci.toLowerCase();
	car2=ikinci.charAt(0);
	nesne.AraDeger(2,car1,car2);
	System.out.println("");
	
	birinci="h";
	birinci=birinci.toLowerCase();
	car1=birinci.charAt(0);
	ikinci="z";
	ikinci=ikinci.toLowerCase();
	car2=ikinci.charAt(0);
	nesne.AraDeger(2,car1,car2);
	System.out.println("");
	
/*Burda girilen karakterlerden secerek rastgele birini yazdiriyor.
**Soldaki sayi kac tane karakter olacagini belirtiyor.
**println asagiya gecmesi icin.*/
	nesne.GirilenCharlar(1,'b','g','e','p','o');
	System.out.println("");
	
	nesne.GirilenCharlar(1,'b','g','e','p','o');
	System.out.println("");
	
	nesne.GirilenCharlar(2,'b','g','e','p','o');
	System.out.println("");
	
//Cumle kuruyor.Sayi kac tane kelime istendigi.
	nesne.CumleKur(5);
    }
}