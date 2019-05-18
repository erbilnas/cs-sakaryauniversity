/*
 *  Time Server  
 * running on port 8080
 * 
 */

import java.net.*;
import java.io.*;
import java.util.Date;

public class IkiSunucu {
	
	public final static int pORT = 8080;
	
	public static void main(String[] args) 
	{
		ServerSocket serverSocket = null;
		PrintWriter out = null; // Character output , mesaj gondermek icin
		
		
		try
		{	serverSocket = new ServerSocket(pORT);
			System.out.println("Sunucu baslatildi. Baglanti bekleniyor...");
			while (true) 
			{
				try (Socket clientSocket = serverSocket.accept()) 
				{
					System.out.println(clientSocket.getInetAddress().getHostName() + " : " + clientSocket.getPort()+ " baglandi.");
					out = new PrintWriter(clientSocket.getOutputStream(), true);
					Date now = new Date();
					out.println(now.toString() +"\r\n");
					//out.flush();
					clientSocket.close();
				} catch (IOException e) 
				{
					System.err.println(e.getMessage());
					System.exit(1);
				}
			}
		} catch (IOException e) {
			System.err.println(e);
		}
	}
}

