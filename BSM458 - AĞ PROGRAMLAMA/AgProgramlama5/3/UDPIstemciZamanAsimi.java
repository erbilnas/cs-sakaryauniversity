/**
 *  UDP istemci
 *  Klavyeden girilen mesaj UDP Sunucuya gönderiliyor. Sunucu ise bu mesajı büyük harflere dönüştürüp geriye
 *  döndürüyor. İstemci sunucudan gelen mesajı ekrana yazdırıyor. Zaman Aşımı durumu da ele alınıyor
 */

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.InterruptedIOException;
import java.net.DatagramPacket;
import java.net.DatagramSocket;
import java.net.InetAddress;
import java.util.logging.FileHandler;
import java.util.logging.Level;
import java.util.logging.Logger;
import java.util.Date;

/**
 * @author wsan
 *
 */
public class UDPIstemciZamanAsimi
{

	/**
	 * @param args
	 */
	private final static String sUNUCU = "localhost";
	private final static int pORT = 8080;
	private final static Logger audit = Logger.getLogger("gunluk");

	private final static int tIMEOUT = 2000;   // Resend timeout (milliseconds)
	private final static int tEKRARgONDERIMsINIRI = 3;     // Maximum retransmissions


	public static void main(String[] args) 
	{

		DatagramSocket socketClient=null;
		// sunucu IP adresi bulunuyor
		InetAddress sunucuIPAdresi=null; 

		try
		{	//Log dosyası belirleniyor...

			FileHandler handler = new FileHandler("Logs/client.log");
			Logger.getLogger("gunluk").addHandler(handler);

			// Soket oluşturuluyor
			socketClient = new DatagramSocket();

			// veri gönderildikten sonra yanıtın gelmesini bekleme süresi ayarlanıyor. UDP, TCP gibi 
			//bağlantı yönelimli olmadığı için bu kadar süre sonra yanıt gelmez ise verinin gitmediği düşünülebilir...

			socketClient.setSoTimeout(tIMEOUT);
			
			
			sunucuIPAdresi = InetAddress.getByName(sUNUCU);

			

			// klavyeden girdi: stdIn
			BufferedReader stdIn = new BufferedReader(new InputStreamReader(System.in));
			String userInput=null;
			byte[] in = new byte[1024]; 
			byte[] out  = new byte[1024];

			while (true) {
				try {
					// Giriş ve çıkışlar için oluşturulacak DatagramPacket içerisinde kullanılmak üzere tampon bellek oluşturuluyor. 
					// TCP deki stream yerine DatagramPacket kullanılıyor.

					//byte[] in = new byte[1024]; 
					//byte[] out  = new byte[1024];
					userInput = new String(stdIn.readLine());

					if (userInput.equals("cikis")) // Klavyeden "cikis" ifadesi girildiğinde bağlantı sonlandırılacak
						break;


					out=userInput.getBytes(); // kullanıcının girdiği string byte dizisine dönüştürülüyor.
	
					// Sunucuya veri göndermek üzere DatagramPacket oluşturuluyor, içerisine kullanıcının klavyeden girdiği 
					// mesaj yazılıyor.
					DatagramPacket gonderilecekPaket = new DatagramPacket(out, out.length, sunucuIPAdresi, pORT);


					int tekrarGonderimSayisi = 0;      // Packets may be lost, so we have to keep trying
					boolean yanitGeldi = false;
					do 
					{

						// DatagramPacket gönderiliyor
						socketClient.send(gonderilecekPaket);

						// Bilgi mesajı olarak günlüğe ekleniyor
						audit.info("Paket gönderildi. Hedef soket adresi:"+sunucuIPAdresi+" : "+pORT);			


						// Sunucudan gelen veriyi almak üzere DatagramPacket oluşturuluyor
						DatagramPacket gelenPaket = new DatagramPacket(in, in.length);
						try {
							socketClient.receive(gelenPaket);
							if (!gelenPaket.getAddress().equals(sunucuIPAdresi)) {// Check source
								
								// Uyarı mesajı olarak günlüğe ekleniyor
								audit.warning("Bilinmeyen bir kaynaktan paket geldi:"+gelenPaket.getAddress());	
								
								throw new IOException("Received packet from an unknown source");
							}
							yanitGeldi = true;

							String inputLine = new String(gelenPaket.getData());
							InetAddress IPAddressServer = gelenPaket.getAddress(); 

							int port = gelenPaket.getPort(); 

							System.out.println ("Gönderen: " + IPAddressServer + ":" + port);
							System.out.println ("Mesaj: " + inputLine);


						} catch (InterruptedIOException e) {  // Yanit gelmedi
							tekrarGonderimSayisi++;
							System.out.println("Zaman Aşımı, " + (tEKRARgONDERIMsINIRI - tekrarGonderimSayisi) + " kez daha denenecek");
							audit.info(sunucuIPAdresi+" adresine yeniden gönderiliyor :");			
						}
					} while ((!yanitGeldi) && (tekrarGonderimSayisi < tEKRARgONDERIMsINIRI));
					
					if (!yanitGeldi) 
					{					     
					      System.out.println("Yanit yok, daha sonra yeniden deneyiniz!!!");
					      audit.log(Level.SEVERE,"Yanit yok, daha sonra yeniden deneyiniz!!!");
					      break;
					}
					    

				} catch (IOException | RuntimeException ex) {
					audit.log(Level.SEVERE, ex.getMessage(), ex);
				}
			}
		} catch (IOException ex) 
		{
			audit.log(Level.SEVERE, ex.getMessage(), ex);
		}finally
		{	Date now = new Date();
			audit.info("Bağlantı sonlandırıldı"+now.toString()+". Uzak Sistem:"+sunucuIPAdresi);		
			socketClient.close();
		}
	} 
}

