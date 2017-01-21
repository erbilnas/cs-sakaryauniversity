/**************************************************************************************************************************************
** SAKARYA ÜNİVERSİTESİ                                                                            
** BİLGİSAYAR VE BİLİŞİM BİLİMLERİ FAKÜLTESİ                                
** BİLGİSAYAR MÜHENDİSLİĞİ BÖLÜMÜ                                                                  
** NESNEYE DAYALI PROGRAMLAMA DERSİ                                              
** 2015-2016 BAHAR DÖNEMİ                                                                        
**                                                                                            
**  ÖDEV NUMARASI..........: 02                                                                                           
**  ÖĞRENCİ ADI............: ERBİL NAS                                                                              
**  ÖĞRENCİ NUMARASI.......: B151210053                                                                                                  
**  DERSİN ALINDIĞI GRUP...: E GRUBU
**
**	ÖDEVİN KONUSU..........: ÜRÜNLERİN TÜRLERİNE GÖRE YAPILACAK NAKLİYATIN NE KADAR MASRAF ÇIKARACAĞINI HESAPLAYAN, TEMEL DÜZEY LOJİSTİK
**							 PROGRAMI                                                                                               
**************************************************************************************************************************************/

using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace odev2
{
    class MusteriBilgisi
    {
        public string musteriIsim, musteriAdres, musteriEposta, musteriWeb, musteriTarih;
        public long musteriTel, musteriFax, musteriVergi;
    }

    class Urunler // Kalıtımın yapılacağı ana sınıf oluşturuldu.
    {
        public string urunIsim;
        public long urunMesafe;
        public double urunCarpani;
    }

    class Kati : Urunler // Ana sınıftan kalıtılan katı yavru sınıfı oluşturuldu.
    {
        public float katiTonaj, katiHacim;
    }

    class Sivi : Urunler // Ana sınıftan kalıtılan sıvı yavru sınıfı oluşturuldu.
    {
        public float siviTonaj, siviOzgun;
    }

    class Gaz : Urunler // Ana sınıftan kalıtılan gaz yavru sınıfı oluşturuldu.
    {
        public long gazTipi;
        public float gazHacim;
    }

    class DegerliUrun : Urunler // Ana sınıftan kalıtılan değerli ürün yavru sınıfı oluşturuldu.
    {
        public long degerliAdedi;
        public float degerliHacim, degerliTonaj, degerliAdetAgirlik;
    }

    class Program
    {
        public static int urunSecim;

        static void Main(string[] args)
        {
            MusteriBilgisi musteri = new MusteriBilgisi(); // Müşteri bilgilerinin girilmesi sağlandı.

            Console.Write("Müşteri Adı...:"); musteri.musteriIsim = Console.ReadLine();
            Console.Write("Adresi........:"); musteri.musteriAdres = Console.ReadLine();
            Console.Write("Telefonu......:"); musteri.musteriTel = Convert.ToInt64(Console.ReadLine());
            Console.Write("Fax...........:"); musteri.musteriFax = Convert.ToInt64(Console.ReadLine());
            Console.Write("Mail..........:"); musteri.musteriEposta = Console.ReadLine();
            Console.Write("Web Adresi....:"); musteri.musteriWeb = Console.ReadLine();
            Console.Write("Vergi No......:"); musteri.musteriVergi = Convert.ToInt64(Console.ReadLine());
            Console.Write("Sipariş Tarihi:"); musteri.musteriTarih = Console.ReadLine();

            Urunler mesafe = new Urunler();

            Console.Write("\nTaşınacak Mesafe:"); mesafe.urunMesafe = Convert.ToInt64(Console.ReadLine());

            Console.WriteLine("\nTaşınacak ürünün cinsini seçiniz:");
            Console.WriteLine("1 - Katı\n2 - Sıvı\n3 - Gaz\n4 - Değerli Ürün");
            Console.Write("\nSeçiminiz:"); urunSecim = Convert.ToInt32(Console.ReadLine());

            switch (urunSecim)
            {

                case 1: // Taşınacak katı ürünün toplam tutarı hesaplandı.

                    Kati urunKati = new Kati();

                    urunKati.urunCarpani = 1;

                    Console.Write("\nKatı ürünün adı........:"); urunKati.urunIsim = Console.ReadLine();
                    Console.Write("Katı ürünün tonajı.....:"); urunKati.katiTonaj = Convert.ToInt64(Console.ReadLine());
                    Console.Write("Katı ürünün paket hacmi:"); urunKati.katiHacim = Convert.ToInt64(Console.ReadLine());
                    Console.WriteLine("*********************************************************************************");
                    Console.WriteLine("\n\aToplam Tutar: {0} $", ((urunKati.katiTonaj * urunKati.urunCarpani * mesafe.urunMesafe) + 1000));
                    Console.Read();

                    break;

                case 2: // Taşınacak sıvı ürünün toplam tutarı hesaplandı.

                    Sivi urunSivi = new Sivi();

                    urunSivi.urunCarpani = 1.25;

                    Console.Write("\nSıvı ürünün adı:"); urunSivi.urunIsim = Console.ReadLine();
                    Console.Write("Sıvı ürünün tonajı:"); urunSivi.siviTonaj = Convert.ToInt64(Console.ReadLine());
                    Console.Write("Sıvı ürünün özgül ağırlığı:"); urunSivi.siviOzgun = Convert.ToInt64(Console.ReadLine());
                    Console.WriteLine("*********************************************************************************");
                    Console.WriteLine("\n\aToplam Tutar: {0} $", (urunSivi.siviOzgun * urunSivi.urunCarpani * mesafe.urunMesafe));
                    Console.Read();

                    break;

                case 3: // Taşınacak gaz ürünün toplam tutarı hesaplandı.

                    Gaz urunGaz = new Gaz();

                    urunGaz.urunCarpani = 1.1;

                    Console.Write("\nGaz ürünün adı:"); urunGaz.urunIsim = Console.ReadLine();
                    Console.Write("Gaz ürünün hacmi:"); urunGaz.gazHacim = Convert.ToInt64(Console.ReadLine());
                    Console.Write("Gaz ürünün tipi:"); urunGaz.gazTipi = Convert.ToInt64(Console.ReadLine());
                    Console.WriteLine("*********************************************************************************");
                    Console.WriteLine("\n\aToplam Tutar: {0} $", ((urunGaz.gazHacim * urunGaz.urunCarpani * mesafe.urunMesafe) + 4000));
                    Console.Read();

                    break;

                case 4: // Taşınacak değerli ürünün toplam tutarı hesaplandı.

                    DegerliUrun urunDegerli = new DegerliUrun();

                    urunDegerli.urunCarpani = 1.5;

                    Console.Write("\nDeğerli ürünün adı:"); urunDegerli.urunIsim = Console.ReadLine();
                    Console.Write("Değerli ürünün hacmi:"); urunDegerli.degerliHacim = Convert.ToInt64(Console.ReadLine());
                    Console.Write("Değerli ürünün tonajı:"); urunDegerli.degerliTonaj = Convert.ToInt64(Console.ReadLine());
                    Console.Write("Değerli ürünün adedi:"); urunDegerli.degerliAdedi = Convert.ToInt64(Console.ReadLine());
                    Console.Write("Değerli ürünün adet ağırlığı:"); urunDegerli.degerliAdetAgirlik = Convert.ToInt64(Console.ReadLine());
                    Console.WriteLine("*********************************************************************************");

                    if (urunDegerli.degerliTonaj / urunDegerli.degerliHacim >= 0.5) // 0.5 koşulu sağlayan ve sağlamayan ürünler için farklı fiyatlandırma yapıldı.
                        Console.WriteLine("\n\aToplam Tutar: {0} $", ((urunDegerli.degerliTonaj * urunDegerli.urunCarpani) + ((urunDegerli.degerliHacim * urunDegerli.urunCarpani)) / 2 + (mesafe.urunMesafe * 1.5)));
                    else
                        Console.WriteLine("\n\aToplam Tutar: {0} $", ((urunDegerli.degerliHacim * urunDegerli.urunCarpani) + (mesafe.urunMesafe * 2)));

                    break;

                default:

                    Console.WriteLine("Hatalı bir giriş yaptınız!\a");

                    break;

            }
        }
    }
}