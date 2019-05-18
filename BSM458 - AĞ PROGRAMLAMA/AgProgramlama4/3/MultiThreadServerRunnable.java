import java.io.IOException;
import java.io.PrintStream;
import java.net.ServerSocket;
import java.net.Socket;
import java.net.*;
import java.io.*;

public class MultiThreadServerRunnable implements Runnable {
   Socket clientSocket;
   MultiThreadServerRunnable(Socket csocket) {
      this.clientSocket = csocket;
   }

   public static void main(String args[])   throws Exception {
      ServerSocket ssock = new ServerSocket(8001);
      System.out.println("Listening");
      while (true) {
         Socket clientSocket = ssock.accept();
         System.out.println(clientSocket.getLocalSocketAddress() + " baglandi.");
         new Thread(new MultiThreadServerRunnable(clientSocket)).start();
      }
   }
   public void run() {
      try {
         PrintWriter out = new PrintWriter(clientSocket.getOutputStream(), true);
		BufferedReader in = new BufferedReader(new InputStreamReader(clientSocket.getInputStream()));
	
		String inputLine, outputLine;
		System.out.println("istemciden girdi bekleniyor...");
		while (true) 
		{ // istemciden gelen string okunuyor...
			inputLine = in.readLine();
			System.out.println(clientSocket.getLocalSocketAddress()+"istemcisinden gelen :" + inputLine);
			outputLine = inputLine.toUpperCase(); // 
			
			out.println(outputLine); // 
			if (inputLine.equals("son")) // 
				break;
		}
		System.out.println(clientSocket.getLocalSocketAddress() + " baglantisi kesildi.");
		// stream ve socketleri kapat.
		out.close();
		in.close();
		//clientSocket.close();
		//serverSocket.close();
      }
      catch (IOException e) {
         System.out.println(e);
      }
   }
}
