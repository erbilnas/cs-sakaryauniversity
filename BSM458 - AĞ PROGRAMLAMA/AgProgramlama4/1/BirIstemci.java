import java.io.*;
import java.net.*;


public class BirIstemci
{
	public static final String sERVER = "192.168.56.103";
	public static final int pORT = 80;
	public static final int tIMEOUT = 2000;
	
	public static void main(String[] args) throws IOException {

		Socket socket = null;
		PrintWriter out = null; // Character output , mesaj gondermek icin
		BufferedReader in = null; // Character Input
		
		try 
		{
			socket = new Socket(sERVER, pORT); // istemci soketi oluşturuluyor
			
			// veri gönderildikten sonra yanıtın gelmesini bekleme süresi ayarlanıyor.  
			// bu kadar süre sonra yanıt gelmez ise verinin gitmediği düşünülür ve istisna ...
			//socket.setSoTimeout(tIMEOUT); //nc ile 80. porttan calisan sunucu ayarlayarak test yapilabilir.
			
			// output stream ve input stream olusuyor
			out = new PrintWriter(socket.getOutputStream(), false); 
			//Creates a new PrintWriter, without (if true then with) automatic line flushing, from an existing OutputStream.
			in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
		} catch (IOException  e) {
			System.err.println(e.getMessage());
			System.exit(1);
			
		}
		
		System.out.println("Sunucuya baglanildi.");
		
		
		
		//out.println("GET / HTTP/1.0\r\n\r\n");   
		out.println("GET / HTTP/1.0\r\n\r\n"); 
		out.flush();
		
		
		System.out.println("web istegi gönderildi");
		
		
		
		 //Get response from server
		String response;
		while ((response = in.readLine()) != null)
		{
			System.out.println( response );
		}
		
		out.close();
		in.close();
		socket.close();
	}

}
