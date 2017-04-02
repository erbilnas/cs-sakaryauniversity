/*
** @author Alperen Kaymak alperen.kaymak@ogr.sakarya.edu.tr , Erbil Nas erbil.nas@ogr.sakarya.edu.tr
** @since 16.03.2017
** 
** Rastgelelik icin olusturulan kutuphane.Rastgele olarak sadece odevde 
** istendigi gibi karakter veya karakter toplulukları ele alinmistir.
*/
package PDP2;

public class RastgeleKarakter
{
//Rastgele bir karakter olusturucu.
    public char RastChar()
    {
//Karakter return icin.
	char karakter = 0;
//Temp nanoTime() ile gelen long degerini integera cevirdikten sonra tutulmasi icin degisken.
	int temp;
//Burda buyuk harf olabilmesi icin bir rastgelelik.
	if (System.nanoTime() % 2 == 0)
	{
	    temp = (int)System.nanoTime();
//NanoTime() dan gelen deger - isaretli olabilecegi icin kontrol yapiyoruz.
	    if (temp<0)
	    {
		temp=temp*(-1);
	    }
//Tempe atanan degeri mod 26 ya alıp 65 eklememizin sebebi buyuk harflerin ASCII da 65 ila 90 arasinda olmasi.
	    temp=((temp% 26) + 65);
	}
//else ifadesi kucuk harf icin.
	else
	{
//Yukardaki kodun aynısı sadece kucuk sayilar icin 97 ila 122 arası aliniyor.
	    temp = (int) System.nanoTime();
	    if (temp<0)
	    {
		temp=temp*(-1);
	    }
	    temp = ((temp%26)+97);
	}
//Tempden gelen integer chara aktariliyor ve returnle donduruluyor.
	karakter = (char) temp;
	return karakter;
    }
//Rastgele birden fazla karakter olusturma.
    public void RastCharUzun(int a)
    {
//Parametre icine yazılan deger kadar karakter uretici cagiriliyor.
	System.out.print("Rastgele " + a + " Karakter:");
	for (int i = 0; i < a; i++)
	{
	    System.out.print(RastChar());
	}
    }
    public void AraDeger(int a, char tmp1, char tmp2)
    {
//Karakter olusturuyoruz sonradan kullanmak icin.
	char gecici = RastChar();
//x,y tmp1 ve tmp2 parametrelerinin integer degerini tutmak icin.
	int x, y;
//x'e atama yapılıyor.İlk sayi
	x = (int) tmp1;
//Kontrol duzgun olması icin egerki Buyuk harf ise Kucuk harfe cevriliyor.
	if (x < 97)
	{
	    x = x + 32;
	}
//Yukardaki kodun aynısının y versiyonu.
	y = (int) tmp2;
	if (y < 97)
	{
	    y = y + 32;
	}
//Burda, egerki soldaki parametre sagdakinden buyukse yer degistirmeleri saglanıyor.
//Kodun daha kısa olmasını saglıyor yoksa sonraki if leri bir ifin icine koymamız gerekiyor.
	if (x > y)
	{
	    int tmp = x;
	    x = y;
	    y = tmp;

	}
//While dongusunde kullanmak icin bir baslangıc degiskeni.
	int i = 0;
//Output icin gereken cıkıs.
	System.out.print("Verilen 2 Karakter Arası("+tmp1+","+tmp2+"):");
//Burda a  bizim kac tane karakter olmasını istememizdi.
//While dongusunde yazdırma islemi yapıyoruz.
	while (i < a)
	{
//Burda egerki istenen charlar arasında ise yazdırılıyor ve yeni bir rastgele karakter olusturulup.
//i nin arttirilmasinin sebebi kac karakter istendigine gore hareket etmesi icin.
	    if ((int) gecici > x && (int) gecici < y)
	    {
		System.out.print(gecici);
		gecici = RastChar();
		i++;
	    }
//Eger ki x ve y arasında degilse yani verilen karakterler arasinda baska bir karakter atiyarak yeniden deniyoruz.
	    else
	    {
		gecici=RastChar();
	    }
	}
    }
//Girilen charlar arasindan rastgele secerek yazdirma.(char... kac tane karakter oldugu belirsiz oldugundan dolayi.)
     public void GirilenCharlar(int a , char... temp)
    {
//Cikti icin duzenli bir gosterim.
	System.out.print("Belirtilen Karakterler(");
//Bu for dongusu test programimizda kac tane char girdiysek o kadarini yazdirmak icin.
	for(int i=0;i<temp.length;i++)
	{
	    System.out.print(temp[i]);
//If dongusu son karakterden sonra virgul konmamasi icin.
	    if(i+1!=temp.length)
	    {
		System.out.print(",");
	    }
	}
	System.out.print("):");
//For dongusunde kac tane karakter istendiyse o kadar karakter cikartmak icin.
	for(int i=0;i<a;i++)
	{
//secici char dizisinden rastgele secmek icin.
	    int secici=(int)System.nanoTime();
//NanoTime - isaretli olabiliyor.
	    if(secici<0)
	    {
		secici=secici*(-1);
	    }
//temp char dizimizin adi.
	    secici=secici%temp.length;
	    System.out.print(temp[secici]);
	}
    }
//Cumle olusturucu.
    public void CumleKur(int tmp)
    {
//degisken adlarinin anlamlarini yerine getiriyor.
	int kelimedurdurma=0;
	System.out.print("Cumle: \"");
//Output icin duzenli bir cikis saglandiktan sonra while icinde kac tane kelime isteniyorsa o kadar kelime uretiliyor.
	while(kelimedurdurma<tmp)
	{
//Kelime uzunlugunu rastgele olarak ele aliyoruz.
	    int kelimeuzunlugu=(int)System.nanoTime();
//eksi cıkmaması icin.
	    if(kelimeuzunlugu<0)
	    {
		kelimeuzunlugu=kelimeuzunlugu*(-1);
	    }
//kelimeuzunlugu 3 ila 8 arası degisiyor.
	    kelimeuzunlugu=((kelimeuzunlugu%6)+3);
//for dongusunde kelimeuzunlugu kadar rastgele karakter cikartiliyor.
	    for(int i=0;i<kelimeuzunlugu;i++)
	    {
		char x=RastChar();
//if de kelimelerin kucuk harf olmasi saglaniyor cumlede full kucuk harf olusmasi icin.
		if((int)x<97)
		{
		    x=(char)((int)x+32);
		}
		System.out.print(x);
	    }
//Bu ifde son kelime haric diger kelimelerden sonra bosluk birakiliyor.
	    if(kelimedurdurma+1!=tmp)
	    {
	    System.out.print(" ");
	    }
//Bu ifde de son kelimeden sonra nokta koyuluyor.
	    if(kelimedurdurma+1==tmp)
	    {
		System.out.print(".");
	    }
	    kelimedurdurma++;
	}
//Tirnak icinde yazdiriyorduk cumleyi tirnagi kapatiyoruz.
	System.out.println("\"");
    }
}