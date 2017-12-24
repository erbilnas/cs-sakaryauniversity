/********************************************************************************************************************
** SAKARYA ÜNİVERSİTESİ
** BİLGİSAYAR VE BİLİŞİM BİLİMLERİ FAKÜLTESİ
** BİLGİSAYAR MÜHENDİSLİĞİ BÖLÜMÜ
** PROGRAMLAMAYA GİRİŞ DERSİ
** 2015-2016 GÜZ DÖNEMİ
**
** ÖDEV NUMARASI..........: PROJE/TASARIM
** ÖĞRENCİ ADI............: ERBİL NAS
** ÖĞRENCİ NUMARASI.......: B151210053
** DERSİN ALINDIĞI GRUP...: C GRUBU
**
** ÖDEVİN KONUSU..........: HASTA KAYDI ALMA, HASTA KAYDI SİLME, RANDEVU ALMA YA DA SİLME, HASTA BİLGİLERİNİ DÜZENLEME,
**			    HASTALARIN LİSTELENMESİ VE BİLGİLERİNİN DOSYALANMASINI YAPAN TEMEL HASTANE YAZILIMI
********************************************************************************************************************/

#include <iostream>
#include <iomanip>
#include <fstream> // Dosyalama yapabilmek için <fstream> kütüphanesi eklendi.
#include <string>
using namespace std;

bool kayit_kontrol(string tc); // Programda kullanılan fonksiyonların prototipleri tanımlandı.
bool randevu_kontrol(string tc);
void hasta_ekle();
void hasta_duzenle(string tc);
void hasta_sil(string tc);
void randevu_al();
void randevu_duzenle(string tc);
void randevu_sil(string tc);
void hasta_sorgula(string tc);
void hasta_listesi();
void muayene(string tc);

int secim;

struct bilgigirisi // Bilgi girişinin saklanacağı yapı oluşturuldu.
{
	string TC, ad, soyad, tel, dogumtarihi, tarih, saat, doktoradi, teshis, ilac, tahlil;
} hasta;

void menu() // Seçim menüsü için void() fonksiyonu oluşturuldu.
{
	string tc;
	tc = "";

	cout << "-----------------------------------------------------------------------------------------------" << endl;
	cout << "1. Hasta kaydi" << setw(50) << "6. Randevu guncelleme" << endl;
	cout << "2. Hasta kaydi duzeltme" << setw(38) << "7. Hasta sorgulama" << endl;
	cout << "3. Hasta silme" << setw(45) << "8. Hasta listesi" << endl;
	cout << "4. Randevu alma" << setw(50) << "9. Hasta muayene kaydi" << endl;
	cout << "5. Randevu silme" << setw(35) << "10. Cikis" << endl << endl;
	cout << "Seciminiz: "; cin >> secim;
	cout << "-----------------------------------------------------------------------------------------------" << endl;

	switch (secim)
	{
	case 1:
		hasta_ekle();
			break;
	case 2:
		cout << "Hasta Duzenleme \nTC Kimlik: "; cin >> tc;
		hasta_duzenle(tc);
			break;
	case 3:
		cout << "Hasta Silme \nTC Kimlik: "; cin >> tc;
		hasta_sil(tc);
			break;
	case 4:
		randevu_al();
			break;
	case 5:
		cout << "Randevu Silme \nTC Kimlik: "; cin >> tc;
		randevu_sil(tc);
			break;
	case 6:
		cout << "Randevu Guncelleme \nTC Kimlik: "; cin >> tc;
		randevu_duzenle(tc);
			break;
	case 7:
		cout << "Hasta Sorgulama \nTC Kimlik: "; cin >> tc;
		hasta_sorgula(tc);
			break;
	case 8:
		hasta_listesi();
			break;
	case 9:
		cout << "Muayene Olustur \nTC Kimlik: "; cin >> tc;
		muayene(tc);
			break;
	case 10:
			break;
	default: cout << "Hatali bir islem sectiniz. Lutfen tekrar deneyin!\a" << endl;
			break;
	}
}

bool kayit_kontrol(string tc) // Hastanın programda kayıtlı olup olmadığını bulmaya yarayan fonksiyon oluşturuldu.
{
	bool kontrol = 0; // TC numarası programda kayıtlı değilse 0 değeri alıyor.
	ifstream dosyaoku;
	dosyaoku.open("hasta.txt");

	while (!dosyaoku.eof())
	{
		dosyaoku >> hasta.TC >> hasta.ad >> hasta.soyad >> hasta.dogumtarihi >> hasta.tel;

		if (hasta.TC == tc)
		{
			kontrol = 1;
		}
	}
	return kontrol;
}

bool randevu_kontrol(string tc) // Hastanın programda randevusu olup olmadığını bulmaya yarayan fonksiyon oluşturuldu.
{
	bool kontrol = 0; // TC numarası programda kayıtlı değilse 0 değeri alıyor.
	ifstream dosyaoku;
	dosyaoku.open("randevu.txt");

	while (!dosyaoku.eof())
	{
		dosyaoku >> hasta.TC >> hasta.tarih >> hasta.saat >> hasta.doktoradi >> hasta.teshis >> hasta.ilac >> hasta.tahlil;

		if (hasta.TC == tc)
		{
			kontrol = 1;
		}
	}
	return kontrol;
}

void hasta_ekle() // Programa hasta eklenmesini ve bu hastayı dosya üzerine kaydetmeyi sağlayan fonksiyon oluşturuldu.
{
	string tc;
	ofstream dosyayaz;
	dosyayaz.open("hasta.txt", ios::app);

	cout << "Hasta Ekle \nTC Kimlik.....: "; cin >> tc;

	if (kayit_kontrol(tc) == 1) // Kayıt kontrol fonksiyonu çağırılarak hasta kaydının olup olmadığı sorgulandı.
	{
		cout << "Bu TC kimlik numarasina ait bir hasta var!\n\a";
	}

	else
	{
		hasta.TC = tc;
		cout << "Hasta adi.....: "; cin >> hasta.ad;
		cout << "Hasta soyadi..: "; cin >> hasta.soyad;
		cout << "Dogum tarihi..: "; cin >> hasta.dogumtarihi;
		cout << "Telefon.......: "; cin >> hasta.tel;
		dosyayaz << hasta.TC << "\t" << hasta.ad << "\t" << hasta.soyad << "\t" << hasta.dogumtarihi << "\t" << hasta.tel << "\n";
		cout << "Hasta eklendi!\n";
	}
	dosyayaz.close();
}

void hasta_duzenle(string tc) // Programdaki hasta kaydının düzenlenmesi sağlayan fonksiyon oluşturuldu.
{
	ifstream dosyaoku;
	ofstream dosyayaz;
	dosyaoku.open("hasta.txt");
	dosyayaz.open("hasta_duzenle.txt", ios::app);

	bool kontrol = 0;

	if (kayit_kontrol(tc) == 0) // Kayıt kontrol fonksiyonu çağırılarak hasta kaydının olup olmadığı sorgulandı.
	{
		cout << "Boyle bir TC kimlik numarasi bulunamadi!\n\a";
	}
	else
	{
		kontrol = 1;
		while (true)
		{
			dosyaoku >> hasta.TC >> hasta.ad >> hasta.soyad >> hasta.dogumtarihi >> hasta.tel;
			if (hasta.TC == tc)
			{
				cout << "Hasta TC......: " << hasta.TC << "\nHasta adi.....: " << hasta.ad << "\nHasta soyadi..: " << hasta.soyad << "\nDogum tarihi..: " << hasta.dogumtarihi << "\nTelefon.......: " << hasta.tel << "\n\nYeni bilgiler;\n";
				cout << "Hasta TC......: "; cin >> hasta.TC;
				cout << "Hasta adi.....: "; cin >> hasta.ad;
				cout << "Hasta soyadi..: "; cin >> hasta.soyad;
				cout << "Dogum tarihi..: "; cin >> hasta.dogumtarihi;
				cout << "Telefon.......: "; cin >> hasta.tel;
				if (dosyaoku.eof())	break; // En son kaydın 2 kere okuyup yazılmaması için eklendi.
				dosyayaz << hasta.TC << "\t" << hasta.ad << "\t" << hasta.soyad << "\t" << hasta.dogumtarihi << "\t" << hasta.tel << "\n";
			}
			else
			{
				if (dosyaoku.eof())	break; // En son kaydın 2 kere okuyup yazılmaması için eklendi.
				dosyayaz << hasta.TC << "\t" << hasta.ad << "\t" << hasta.soyad << "\t" << hasta.dogumtarihi << "\t" << hasta.tel << "\n";
			}

		}
		dosyaoku.close();
		dosyayaz.close();

		if (kontrol == 1) // Programda kayıt varsa yapılan değişikliklerin dosya üzerine yazılması sağlandı.
		{
			remove("hasta.txt");
			rename("hasta_duzenle.txt", "hasta.txt");
			cout << "Hasta bilgileri guncellendi!\n";
		}
		else
		{
			remove("hasta_duzenle.txt");
		}
	}
}


void hasta_sil(string tc) // Programdaki hasta kaydının silinmesini sağlayan fonksiyon oluşturuldu.
{
	ifstream dosyaoku;
	ofstream dosyayaz;
	dosyaoku.open("hasta.txt");
	dosyayaz.open("hasta_sil.txt", ios::app);

	bool kontrol = 0;

	if (kayit_kontrol(tc) == 0) // Kayıt kontrol fonksiyonu çağırılarak hasta kaydının olup olmadığı sorgulandı.
	{
		cout << "Boyle bir TC kimlik numarasi bulunamadi!\n\a";
	}
	else
	{
		kontrol = 1;
		while (true)
		{
			dosyaoku >> hasta.TC >> hasta.ad >> hasta.soyad >> hasta.dogumtarihi >> hasta.tel;
			if (hasta.TC != tc)
			{
				if (dosyaoku.eof())	break; // En son kaydın 2 kere okuyup yazılmaması için eklendi.
				dosyayaz << hasta.TC << "\t" << hasta.ad << "\t" << hasta.soyad << "\t" << hasta.dogumtarihi << "\t" << hasta.tel << "\n";
			}
		}
	}
	dosyaoku.close();
	dosyayaz.close();

	if (kontrol == 1) // Programda kayıt varsa yapılan değişikliklerin dosya üzerine yazılması sağlandı.
	{
		remove("hasta.txt");
		rename("hasta_sil.txt", "hasta.txt");
		cout << "Kayit silindi!\n";
	}
	else
	{
		remove("hasta_sil.txt");
	}
}

void randevu_al() // Programın randevu kaydı tutmasını sağlayan fonksiyon oluşturuldu.
{
	string tc;
	ifstream dosyaoku;
	ofstream dosyayaz;
	dosyaoku.open("hasta.txt");
	dosyayaz.open("randevu.txt", ios::app);

	cout << "Randevu Alma\n TC Kimlik: "; cin >> tc;

	if (kayit_kontrol(tc) == 0)
	{
		cout << "Kayit bulunamadi. Kayit olusturun;\n"; // Kayıt kontrol fonksiyonu çağırılarak hasta kaydının olup olmadığı sorgulandı.
		hasta_ekle();
	}

	cout << "\nRandevu tarihi.: "; cin >> hasta.tarih;
	cout << "Randevu saati..: "; cin >> hasta.saat;
	hasta.TC = tc;
	hasta.doktoradi = "-";
	hasta.teshis = "-";
	hasta.ilac = "-";
	hasta.tahlil = "-";
	dosyayaz << hasta.TC << "\t" << hasta.tarih << "\t" << hasta.saat << "\t" << hasta.doktoradi << "\t" << hasta.teshis << "\t" << hasta.ilac << "\t" << hasta.tahlil << "\n";

	dosyayaz.close();
	dosyaoku.close();
	cout << "Randevu alindi\n";
}

void randevu_duzenle(string tc) // Programın randevu kaydını düzenlemesini sağlayan fonksiyon oluşturuldu.
{
	ifstream dosyaoku;
	ofstream dosyayaz;
	dosyaoku.open("randevu.txt");
	dosyayaz.open("randevu_duzenle.txt", ios::app);
	bool kontrol = 0;

	if (randevu_kontrol(tc) == 0) // Kayıt kontrol fonksiyonu çağırılarak hasta kaydının olup olmadığı sorgulandı.
	{
		cout << "Kayit bulunamadi. Kayit olusturun;\n";
		hasta_ekle();
	}
	else
	{
		kontrol = 1;
		while (true)
		{
			dosyaoku >> hasta.TC >> hasta.tarih >> hasta.saat >> hasta.doktoradi >> hasta.teshis >> hasta.ilac >> hasta.tahlil;

			if (hasta.TC == tc)
			{
				cout << "Hasta TC: " << hasta.TC << "\nRandevu tarihi: " << hasta.tarih << "\nRandevu saati: " << hasta.saat << "\nYeni bilgiler \n";

				cout << "Randevu tarihi: "; cin >> hasta.tarih;
				cout << "Randevu saati: "; cin >> hasta.saat;

				hasta.doktoradi = "-";
				hasta.teshis = "-";
				hasta.ilac = "-";
				hasta.tahlil = "-";

				if (dosyaoku.eof())	break; // En son kaydın 2 kere okuyup yazılmaması için eklendi.
				dosyayaz << hasta.TC << "\t" << hasta.tarih << "\t" << hasta.saat << "\t" << hasta.doktoradi << "\t" << hasta.teshis << "\t" << hasta.ilac << "\t" << hasta.tahlil << "\t";
			}
			else
			{
				hasta.doktoradi = "-";
				hasta.teshis = "-";
				hasta.ilac = "-";
				hasta.tahlil = "-";

				if (dosyaoku.eof())	break; // En son kaydın 2 kere okuyup yazılmaması için eklendi.
				dosyayaz << hasta.TC << "\t" << hasta.tarih << "\t" << hasta.saat << "\t" << hasta.doktoradi << "\t" << hasta.teshis << "\t" << hasta.ilac << "\t" << hasta.tahlil << "\t";
			}
		}
	}
	dosyaoku.close();
	dosyayaz.close();

	if (kontrol == 1) // Programda kayıt varsa yapılan değişikliklerin dosya üzerine yazılması sağlandı.
	{
		remove("randevu.txt");
		rename("randevu_duzenle.txt", "randevu.txt");
		cout << "randevu guncellendi\n";
	}
	else
	{
		remove("randevu_duzenle.txt");
	}
}

void randevu_sil(string tc) // Programın randevu kaydını silmesini sağlayan fonksiyon oluşturuldu.
{
	ifstream dosyaoku;
	ofstream dosyayaz;
	dosyaoku.open("randevu.txt");
	dosyayaz.open("randevu_sil.txt", ios::app);
	bool kontrol = 0;

	if (randevu_kontrol(tc) == 0) // Kayıt kontrol fonksiyonu çağırılarak hasta kaydının olup olmadığı sorgulandı.
	{
		cout << "Kayit bulunamadi.\n";
	}
	else
	{
		kontrol = 1;
		while (true)
		{
			dosyaoku >> hasta.TC >> hasta.tarih >> hasta.saat >> hasta.doktoradi >> hasta.teshis >> hasta.ilac >> hasta.tahlil;
			if (hasta.TC != tc)
			{
				if (dosyaoku.eof())	break; // En son kaydın 2 kere okuyup yazılmaması için eklendi.
				dosyayaz << hasta.TC << "\t" << hasta.tarih << "\t" << hasta.saat << "\t" << hasta.doktoradi << "\t" << hasta.teshis << "\t" << hasta.ilac << "\t" << hasta.tahlil << "\t";
			}
		}

	}
	dosyaoku.close();
	dosyayaz.close();
	if (kontrol == 1) // Programda kayıt varsa yapılan değişikliklerin dosya üzerine yazılması sağlandı.
	{
		remove("randevu.txt");
		rename("randevu_sil.txt", "randevu.txt");
		cout << "Kayit silindi!\n";
	}
	else
	{
		remove("randevu_sil.txt");
	}
}

void hasta_sorgula(string tc) // Programdaki hastanın kaydının olup olmadığını sorgulayan fonksiyon oluşturuldu.
{
	ifstream dosyaoku;
	dosyaoku.open("randevu.txt");

	if (kayit_kontrol(tc) == 0) // Kayıt kontrol fonksiyonu çağırılarak hasta kaydının olup olmadığı sorgulandı.
	{
		cout << "Kayit bulunamadi.\n";
	}
	else
	{
		if (randevu_kontrol(tc) == 1) // Daha önceden randevu alınmış ise gösterir.
		{
			while (!dosyaoku.eof())
			{
				dosyaoku >> hasta.TC >> hasta.tarih >> hasta.saat >> hasta.doktoradi >> hasta.teshis >> hasta.ilac >> hasta.tahlil;
				if (hasta.TC == tc)
				{
					cout << "Tarih.........: " << hasta.tarih << endl;
					cout << "Saat..........: " << hasta.saat << endl;
					cout << "Doktor Adi....: " << hasta.doktoradi << endl;
					cout << "Teshis........: " << hasta.teshis << endl;
					cout << "Ilac..........: " << hasta.ilac << endl;
					cout << "Tahlil........: " << hasta.tahlil << endl;
				}
			}
		}
		else
		{
			cout << "Randevu kayidi bulunamadi!\a\n";
		}
	}
	dosyaoku.close();
}

void hasta_listesi() // Programdaki hastaların tamamını gösteren fonksiyon oluşturuldu.
{
	ifstream dosyaoku;
	dosyaoku.open("hasta.txt");

	cout << "TC\t\t" << "Ad & Soyad\t" << "Dogum Tarihi\t" << "Telefon\n";
	while (true)
	{
		dosyaoku >> hasta.TC >> hasta.ad >> hasta.soyad >> hasta.dogumtarihi >> hasta.tel;

		if (dosyaoku.eof())	break; // En son kaydın 2 kere okuyup yazılmaması için eklendi.
		cout << hasta.TC << "\t" << hasta.ad << "\t" << hasta.soyad << "\t" << hasta.dogumtarihi << "\t" << hasta.tel << "\n";

	}
	dosyaoku.close();
}

void muayene(string tc) // Programdaki hasta muayene kaydı hazırlayan fonksiyon oluşturuldu.
{
	ifstream dosyaoku;
	ofstream dosyayaz;
	dosyaoku.open("randevu.txt");
	dosyayaz.open("muayene.txt", ios::app);
	bool kontrol = 0;


	if (randevu_kontrol(tc) == 0) // Kayıt kontrol fonksiyonu çağırılarak hasta kaydının olup olmadığı sorgulandı.
	{
		cout << "Kayit bulunamadi.\n";

	}
	else
	{
		kontrol = 1;
		while (true)
		{
			dosyaoku >> hasta.TC >> hasta.tarih >> hasta.saat >> hasta.doktoradi >> hasta.teshis >> hasta.ilac >> hasta.tahlil;
			if (hasta.TC == tc)
			{
				hasta_sorgula(tc);
				hasta.TC = tc;
				cout << "\nDoktor adi....: "; cin >> hasta.doktoradi; cout << endl;
				cout << "Tarih.........: "; cin >> hasta.tarih; cout << endl;
				cout << "Saat..........: "; cin >> hasta.saat; cout << endl;
				cout << "Teshis........: "; cin >> hasta.teshis; cout << endl;
				cout << "Ilac..........: "; cin >> hasta.ilac; cout << endl;
				cout << "Tahlil........: "; cin >> hasta.tahlil;
				if (dosyaoku.eof())	break; // En son kaydın 2 kere okuyup yazılmaması için eklendi.
				dosyayaz << hasta.TC << "\t" << hasta.tarih << "\t" << hasta.saat << "\t" << hasta.doktoradi << "\t" << hasta.teshis << "\t" << hasta.ilac << "\t" << hasta.tahlil << "\t";

			}
			else
			{
				if (dosyaoku.eof())	break; // En son kaydın 2 kere okuyup yazılmaması için eklendi.
				dosyayaz <<	hasta.TC << "\t" << hasta.tarih << "\t" << hasta.saat << "\t" << hasta.doktoradi << "\t" << hasta.teshis << "\t" << hasta.ilac << "\t" << hasta.tahlil << "\t";
			}
		}
	}
	dosyaoku.close();
	dosyayaz.close();

	if (kontrol == 1) // Programda kayıt varsa yapılan değişikliklerin dosya üzerine yazılması sağlandı.
	{
		remove("randevu.txt");
		rename("muayene.txt", "randevu.txt");
		cout << "Kayit olusturuldu\n";
	}
	else
	{
		remove("muayene.txt");
	}

}

int main()
{
	while (secim != 10)
	{
		system("cls");
		menu();
		system("pause");
	}
	return 0;
}
