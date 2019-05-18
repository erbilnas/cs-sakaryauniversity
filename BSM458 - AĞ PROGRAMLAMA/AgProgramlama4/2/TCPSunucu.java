import java.net.*;
import java.io.*;
import java.util.Date;

public class TCPSunucu {
	public static void main(String[] args) throws IOException {

		ServerSocket serverSocket = null;
		Socket clientSocket = null;
		PrintWriter out = null; // Character output , mesaj gondermek icin
		BufferedReader in = null; // Character Input
		//String host = "localhost";
		int port=8080;
		
		try 
		{
			serverSocket = new ServerSocket(port);
		} catch (IOException e) {
			System.err.println("I/O exception: " + e.getMessage());
			System.exit(1);
		}
		System.out.println("Sunucu baslatildi. Baglanti bekleniyor...");
		
		try 
		{
			clientSocket = serverSocket.accept(); 
		} catch (IOException e) 
		{
			System.err.println("Accept failed.");
			System.exit(1);
		}
		
		System.out.println(clientSocket.getInetAddress().getHostName() + " : " + clientSocket.getPort()+ " baglandi.");
		
		// input stream ve output stream olustur
		try
		{	
			out = new PrintWriter(clientSocket.getOutputStream(), true);
			in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
		} catch (IOException e) 
		{
			System.out.println("Read failed");
			System.exit(-1);
		}
		String inputLine, outputLine;
		System.out.println("istemciden girdi bekleniyorrr...");
		
		while (true) 
		{ // istemciden gelen string okunuyor...
			inputLine = in.readLine();
			System.out.println(clientSocket.getRemoteSocketAddress()+"istemcisinden gelen :" + inputLine);
			outputLine = inputLine.toUpperCase(); // 
			
			out.println(outputLine); // 
			if (inputLine.equals("son")) // 
				break;
		}
		System.out.println(" baglantisi kesildi.");
		// stream ve socketleri kapat.
		
        clientSocket.close();
		serverSocket.close();
        out.close();
        in.close();
		
	}
}
