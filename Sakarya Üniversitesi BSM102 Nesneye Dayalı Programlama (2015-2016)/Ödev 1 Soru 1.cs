/**************************************************************************************************************************************
** SAKARYA ÜNİVERSİTESİ                                                                            
** BİLGİSAYAR VE BİLİŞİM BİLİMLERİ FAKÜLTESİ                                
** BİLGİSAYAR MÜHENDİSLİĞİ BÖLÜMÜ                                                                   
** NESNEYE DAYALI PROGRAMLAMA DERSİ                                               
** 2015-2016 BAHAR DÖNEMİ                                                                         
**                                                                                             
** ÖDEV NUMARASI..........: 01                                                                                             
** ÖĞRENCİ ADI............: ERBİL NAS                                                                               
** ÖĞRENCİ NUMARASI.......: B151210053                                                                                                  
** DERSİN ALINDIĞI GRUP...: E GRUBU
**
** ÖDEVİN KONUSU..........: OLUŞTURULAN BİR DİZİDE, BAŞLANGIÇTAN İSTENİLEN ARALIĞA KADAR, İSTENİLEN ARALIKTAKİ VE ARALIĞIN SONUNDAN
**							DİZİNİN SONUNA KADAR OLAN ELEMANLARIN TOPLAMINI BULMA
**************************************************************************************************************************************/

using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace odev1soru1
{
    public class MainProgram
    {
        private static int aralikDizi, diziAralik, aralik;  //aralikDizi değişkeni dizinin başından aralık başına kadar, diziAralik değişkeni ise aralık sonundan dizi sonuna kadar olan değerler için tanımlandı.
        private static int baslangicAralik, bitisAralik, diziBoyutu;
  
        public static void Main(string[] args)
        {
            int[] dizi;

            Console.Write("Bir sayı değeri giriniz:"); diziBoyutu = Convert.ToInt32(Console.ReadLine());
            dizi = new int[diziBoyutu];
            Random degerAtama = new Random();

            for (int i = 0; i < dizi.Length; i++) //Girilen dizi boyutuna kadar ulaşana kadar diziye rastgele sayı atanması sağlandı.
            {
                dizi[i] = degerAtama.Next(0, 1000);
                Console.Write("{1}  ", i, dizi[i]);
            }
            Console.WriteLine(); Console.WriteLine();

            while (true) //Aralıklar ve dizi boyutları hakkında sorgulama döngüsü kuruldu.
            {
                Console.Write("Lütfen aralığın başlangıç değerini giriniz : "); baslangicAralik = Convert.ToInt32(Console.ReadLine());
                if (baslangicAralik <= 0 || baslangicAralik >= dizi.Length)
                {
                    Console.WriteLine("Seçilen indislerin değeri 0’dan küçük veya dizi boyutundan büyük olamaz!\a");
                }
                else
                {
                    Console.Write("Lütfen aralığın bitiş değerini giriniz : "); bitisAralik = Convert.ToInt32(Console.ReadLine());
                    if (bitisAralik <= 0 || bitisAralik > dizi.Length)
                    {
                        Console.WriteLine("Aralığın bitişi 0'dan küçük ve dizi boyutundan büyük olamaz!\a");
                    }
                    else if (bitisAralik <= baslangicAralik)
                    {
                        Console.WriteLine("Aralığın bitişi başlangıcından daha küçük olamaz!\a");
                    }
                    else
                        break;
                }
            }           
            Console.WriteLine();

            for (int i = 0; i < baslangicAralik; i++) //Dizinin başlangıcından aralığın başlangıcına kadar olan sayı değerlerinin toplamı bulundu.
                aralikDizi = aralikDizi + dizi[i];

            Console.WriteLine("Dizinin başlangıcından aralığın başlangıcına kadar olan sayı değerlerinin toplamı: {0}", aralikDizi);
            Console.WriteLine();

            for (int i = baslangicAralik; i <= bitisAralik; i++) //Girilen aralığın içindeki elemanların toplamı bulundu.
                aralik = aralik + dizi[i];

            Console.WriteLine("Girilen aralığın içindeki elemanların toplamı....................................: {0}", aralik);
            Console.WriteLine();

            for (int i = bitisAralik + 1; i < dizi.Length; i++) //Aralığın sonundan dizi sonuna kadar olan sayı değerlerinin toplamı bulundu.
                diziAralik = diziAralik + dizi[i];

            Console.WriteLine("Aralığın sonundan dizi sonuna kadar olan sayı değerlerinin toplamı:..............: {0}", diziAralik);
            Console.WriteLine();
        }
    }
}