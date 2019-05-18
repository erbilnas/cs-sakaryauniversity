import java.io.*;
import java.net.*;


public class IkiIstemci
{
	public static final String sERVER = "localhost";
	public static final int pORT = 8080;
	public static final int tIMEOUT = 10000;
	
	public static void main(String[] args) throws IOException {

		Socket socket = null;
		BufferedReader in = null; // Character Input
		
		try {
			socket = new Socket(sERVER, pORT); // "localhost" ya da sunucu IP adresi
			// input stream  olusuyor
						
			in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
		} catch (UnknownHostException e) {
			System.err.println("Sunucu bulunamadi");
			System.exit(1);
		} 
		System.out.println("Sunucuya baglanildi. zaman alınıyor...\n"+in.readLine());
		in.close();
		socket.close();
	}

}
