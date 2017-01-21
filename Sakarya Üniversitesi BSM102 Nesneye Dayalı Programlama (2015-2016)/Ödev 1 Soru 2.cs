/**************************************************************************************************************************************
** SAKARYA ÜNİVERSİTESİ                                                                            
** BİLGİSAYAR VE BİLİŞİM BİLİMLERİ FAKÜLTESİ                                
** BİLGİSAYAR MÜHENDİSLİĞİ BÖLÜMÜ                                                                   
** NESNEYE DAYALI PROGRAMLAMA DERSİ                                               
** 2015-2016 BAHAR DÖNEMİ                                                                         
**                                                                                             
**	ÖDEV NUMARASI..........: 01                                                                                             
**	ÖĞRENCİ ADI............: ERBİL NAS                                                                               
**	ÖĞRENCİ NUMARASI.......: B151210053                                                                                                  
**  DERSİN ALINDIĞI GRUP...: E GRUBU
**
**	ÖDEVİN KONUSU..........: STRİNG BİR DEĞİŞKEN İÇERİSİNDE SUBSTRİNG FONKSİYONUNU ÖNCE KULLANMAYARAK, SONRA DA KULLANARAK ARAMA YAPMA,
**							 BİR STRİNG İÇERİSİNDE ALFABEDEKİ HER KARAKTERİN KAÇ DEFA KULLANILDIĞINI BULMA                                                                                                
**************************************************************************************************************************************/

using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace odev1soru2
{
    public class MainMenu
    {
        private static int secim, indis;
        private static string karakterDizini, araKelime, kelime, cumle;
        private static string harf = "ABCÇDEFGĞHIİJKLMNOÖPQRSŞTUÜVWXYZ";

        public static void Main(string[] args)
        {
            Console.WriteLine("\t\t\t\t\tANA MENUYE HOSGELDINIZ!\a"); Console.WriteLine("************************************************************************************************");
            Console.WriteLine("1 - String bir değişkende, string değeri substring kullanmadan arama........................:");
            Console.WriteLine("2 - String bir değişkende, string değeri substring kullanarak arama.........................:");
            Console.WriteLine("3 - Alfabenin karakterlerini bir string içerisinde arama ve kaç adet geçtiğini bularak çizme:");
            Console.WriteLine(); Console.Write("Seçiminiz:"); secim = Convert.ToInt32(Console.ReadLine());

            switch (secim) //Ana menü oluşturmak için switch-case yapısı kullanıldı.
            {
                case 1: WithoutSub();
                    break;
                case 2: WithSub();
                    break;
                case 3: Alphabet();
                    break;
                default: Console.Write("Hatalı bir giriş yaptınız!\a");
                    break;
            }
        }

        public static void WithSub() //Substring kullanılarak arama yapıldı.
        {
            Console.WriteLine();
            Console.Write("Bir karakter dizini giriniz:"); karakterDizini = Console.ReadLine();
            Console.Write("Aranacak kelimeyi giriniz......:"); araKelime = Console.ReadLine();

            for (int i = 0; i < karakterDizini.Length; i++) //Karakter dizinin genişliği kullanılarak kelimenin cümle içerisindeki indisleri bulundu.
            {
                if (karakterDizini.Length - i >= araKelime.Length)
                {
                    kelime = karakterDizini.Substring(i, araKelime.Length); //Substring ile kelimenin cümle içerisinde olup olmadığı kontrol edildi.
                    {
                        if (kelime == araKelime)
                            Console.WriteLine("Girilen kelimenin bulunduğu indisler:" + i);
                    }
                }
            }
        }

        public static void WithoutSub() //Substring kullanılmadan arama yapıldı.
        {
            Console.WriteLine();
            Console.Write("Bir karakter dizini giriniz:"); karakterDizini = Console.ReadLine();
            Console.Write("Aranacak kelimeyi giriniz......:"); araKelime = Console.ReadLine();
            indis = karakterDizini.IndexOf(araKelime);

            while (indis != -1)
            {
                Console.WriteLine("Girilen kelimenin bulunduğu indisler:" + indis);
                indis = karakterDizini.IndexOf(araKelime, indis + 1);
            }
        }

        public static void Alphabet() //Alfabenin karakterlerinin cümle içerisinde kaç adet geçtiği bulundu.
        {
            char[] stringChar, harfDizini;
            int[] harfler = new int[32];

            Console.Write("Bir karakter dizini giriniz:"); cumle = Console.ReadLine().ToUpper();
            harfDizini = harf.ToCharArray();
            stringChar = cumle.ToCharArray();

            for (int i = 0; i < harfler.Length; i++) //Bir harfler dizini oluşturuldu ve değerleri sıfıra atandı.
            {
                harfler[i] = 0;
            }

            for (int j = 0; j < harfDizini.Length; j++) //Cümlenin içindeki harfler kontrol edildi, eğer bu harf cümle içinde bulunduysa diziye değeri atandı.
            {
                for (int k = 0; k < stringChar.Length; k++)
                {
                    if (harfDizini[j] == stringChar[k])
                    {
                        harfler[j] = harfler[j] + 1;
                    }
                }
            }

            Console.WriteLine("------------------------------------------------------------------------------------------------");
            for (int n = 0; n < harfler.Length; n++) //Alfabedeki harfler yazıldı.
            {
                Console.Write(harfDizini[n] + " sayısı: ");
                Console.Write(harfler[n] + " ");
                for (int m = 0; m < harfler[n]; m++) //Harflerin cümle içerisindeki sayısı kadar "*" işareti kullanıldı.
                {
                    Console.Write("*");
                }
                Console.WriteLine();
            }
        }
    }
}