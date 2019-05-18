import java.io.PrintWriter;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.io.IOException;
import java.net.UnknownHostException;
import java.net.Socket;


public class TCPIstemci {

	public static void main(String[] args) throws IOException {

		Socket socket = null;
		PrintWriter out = null;
		BufferedReader in = null;
		final String hOST = "localhost";
		final int pORT=8080;
		try {
			socket = new Socket(hOST, pORT); // "localhost" ya da sunucu IP adresi
			// input stream ve output stream olusuyor
			out = new PrintWriter(socket.getOutputStream(), true);
			in = new BufferedReader(new InputStreamReader(socket.getInputStream()));
		} catch (UnknownHostException e) {
			System.err.println("Sunucu bulunamadi");
			System.exit(1);
		} catch (IOException e) {
			System.err.println("I/O exception:" + e.getMessage());
			System.exit(1);
		}
		System.out.println("Sunucuya baglanildi.");
		// klavyeden girdi: stdIn
		BufferedReader stdIn = new BufferedReader(new InputStreamReader(System.in));
		String userInput;
		System.out.println("Buyuk harflere cevrilmesi icin girdi bekleniyor (baglantiyi kesmek icin: son) ...");
		while (!(userInput = stdIn.readLine()).equals("son")) {
			out.println(userInput);
			System.out.println("Sunucudan gelen: " + in.readLine());
		}
		System.out.println("Baglanti kesiliyor...");

		out.close();
		in.close();
		stdIn.close();
		socket.close();
	}

}
