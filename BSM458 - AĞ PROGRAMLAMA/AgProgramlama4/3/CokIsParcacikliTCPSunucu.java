/**
 *  Her istek için sunucu tarafında bu isteği ele alan iş parçacığı (thread) oluşturuluyor.
 * 	Thread oluşturulurken Thread sınıfından kalıtım yoluyla elde ediliyor. Runnable gerçeklenerek (Single Responsibilty ilkesine daha uygun)de thread oluşturulabilirdi
 */



import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.PrintWriter;
import java.net.ServerSocket;
import java.net.Socket;

/**
 * @author wsan
 *
 */
public class CokIsParcacikliTCPSunucu 
{
	private static final int PORT = 8001;

	/**
	 * @param args
	 * @throws IOException 
	 */
	public static void main(String[] args) throws IOException 
	{
		ServerSocket serverSocket = new ServerSocket(PORT);
		System.out.println("Listening");
		try {
			while (true) 
			{
				Socket clientSocket = serverSocket.accept();
				System.out.println(clientSocket.getRemoteSocketAddress() + " baglandi.");
				
				// Her bağlantıı için yeni bir iş parçacığı (thread) oluşturuluyor...
				Thread task = new Handler(clientSocket);
				task.start();
			}
			
			/*The finally block always executes when the try block exits. This ensures that the finally block is executed even if 
			an unexpected exception occurs. But finally is useful for more than just exception handling — it allows the programmer 
			to avoid having cleanup code accidentally bypassed by a return, continue, or break. 
			Putting cleanup code in a finally block is always a good practice, even when no exceptions are anticipated.
			
			The only times finally won't be called are; i)if you call System.exit() or ii) if the JVM crashes first (kill, etc....)

			*/
		}finally{
			serverSocket.close();
		}

	}

	private static class Handler extends Thread 
	{

		private Socket clientSocket;
		private BufferedReader in;
		private PrintWriter out;

		/**
		 * Constructs a handler thread, squirreling away the socket.
		 * All the interesting work is done in the run method.
		 */
		public Handler(Socket socket) { this.setClientSocket(socket); }

		public Socket getClientSocket()
		{
			return clientSocket;
		}


		public void setClientSocket(Socket clientSocket)
		{
			this.clientSocket = clientSocket;
		}


		public BufferedReader getIn()
		{
			return in;
		}


		public void setIn(BufferedReader in)
		{
			this.in = in;
		}


		public PrintWriter getOut()
		{
			return out;
		}


		public void setOut(PrintWriter out)
		{
			this.out = out;
		}


		public void run()
		{
			try {
				this.setIn(new BufferedReader(new InputStreamReader(this.getClientSocket().getInputStream())));
				this.setOut(new PrintWriter(this.getClientSocket().getOutputStream(), true));
				//this.out= new PrintWriter(this.getClientSocket().getOutputStream(), true);
				//this.setIn( new BufferedReader(new InputStreamReader(this.getClientSocket().getInputStream())));

				String inputLine, outputLine;
				System.out.println("istemciden girdi bekleniyor...");
				while (true) 
				{ // istemciden gelen string okunuyor...
					inputLine = this.getIn().readLine();
					System.out.println(this.getClientSocket().getRemoteSocketAddress()+"istemcisinden gelen :" + inputLine);
					outputLine = inputLine.toUpperCase(); // 

					this.out.println(outputLine); // 
					if (inputLine.equals("son")) // 
						break;
				}
				System.out.println(this.getClientSocket().getRemoteSocketAddress() + " baglantisi kesildi.");
				// stream ve socketleri kapat.
				this.getOut().close();
				this.getIn().close();
				this.getClientSocket().close();
			}
			catch (IOException e) {
				System.out.println(e);
			}
		}

	}
}
