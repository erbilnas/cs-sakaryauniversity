import java.io.*;
import java.net.*;


public class TCPIstemci
{
	public static void main(String[] args) throws IOException {

		Socket socket = null;
		PrintWriter out = null; // Character output , mesaj gondermek icin
		BufferedReader in = null; // Character Input
		String host = "localhost";
		int port=8080;
		try {
			socket = new Socket(host,port); // "localhost" ya da sunucu IP adresi
			
			
			out = new PrintWriter(socket.getOutputStream(), true); 
			//Creates a new PrintWriter, without (if true then with) automatic line flushing, from an existing OutputStream.
			
			in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
		} catch (UnknownHostException e) {
			System.err.println("Sunucu bulunamadi");
			System.exit(1);
		} 
		/*catch (IOException e) {
			System.err.println("I/O exception:" + e.getMessage());
			System.exit(1);
		}*/
		System.out.println("Sunucuya baglanildi.");
		
		
		// klavyeden girdi: stdIn
		BufferedReader stdIn = new BufferedReader(new InputStreamReader(System.in));
		String userInput;
		System.out.println("Buyuk harflere cevrilmesi icin girdi bekleniyor (baglantiyi kesmek icin: son yazınız) ...");
		while (true) 
		{
			userInput = stdIn.readLine();
			
			out.println(userInput);
			System.out.println("Sunucudan gelenn: " + in.readLine());
			if (userInput.equals("son")) 
				break;
			
		}
		System.out.println("Baglanti kesiliyor...");
		
		
		stdIn.close();
		out.close();
		in.close();
		socket.close();
	}

}
