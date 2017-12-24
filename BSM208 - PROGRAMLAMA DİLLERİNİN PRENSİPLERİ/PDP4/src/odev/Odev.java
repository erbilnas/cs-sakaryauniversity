/**
*
* @author Umut Tosun - b151210113@sakarya.edu.tr , Erbil Nas - b151210053@sakarya.edu.tr
* @since 28/04/2017
* <p>
* Pdp 4.Odev
* </p>
*/
package odev;

import java.io.BufferedWriter;
import java.math.*;
import java.io.*;
import java.util.*;
import java.util.concurrent.Callable;
import java.util.concurrent.ExecutorService;
import java.util.concurrent.Executors;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;

class Sayi{
    int sayi;
    BigInteger sonuc =  BigInteger.valueOf(1);
    
    public Sayi(int s){
        sayi = s;
    }
    
    public void setSayi(int s){
        sayi = s;
    }
    
    public void setSonuc(BigInteger s){
        sonuc = s;
    }
    
    public int getSayi(){
        return sayi;
    }
    
    public BigInteger getSonuc(){
        return sonuc;
    }
}


class MyMultiplication implements Runnable 
{
    public static BigInteger subResult1;
    public static BigInteger subResult2;
    int thread1StopsAt;
    int thread2StopsAt;
    long threadId;
    static boolean idIsSet=false;

    // İlk Thread
    public MyMultiplication(BigInteger n1, int n2)
    {
        MyMultiplication.subResult1 = n1;
        this.thread1StopsAt = n2/2;

        thread2StopsAt = n2;

    }
    
    // 2.Thread
    public MyMultiplication(int n2,BigInteger n1)
    {
        MyMultiplication.subResult2 = n1;
        this.thread2StopsAt = n2;

        thread1StopsAt = n2/2;
    }
    @Override
    public void run() 
    {
        if(idIsSet==false)
        {
            threadId = Thread.currentThread().getId(); 
            idIsSet=true;            
        }
        if(Thread.currentThread().getId() == threadId)
        {
            for(int i=2; i<=thread1StopsAt; i++)
            {
                subResult1 = subResult1.multiply(BigInteger.valueOf(i));
            }
        }
        else
        {
            for(int i=thread1StopsAt+1; i<= thread2StopsAt; i++)
            {
                subResult2 = subResult2.multiply(BigInteger.valueOf(i));
            }
        }            
    }   
}


public class Odev {
    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws InterruptedException {
        long start = System.nanoTime(); 
        BigInteger num = BigInteger.valueOf(1);
        
        // Kullanıcıdan sayı alınıyor.
        Scanner reader = new Scanner(System.in);  
        System.out.println("Faktoriyeli alınacak sayi: ");
        int calculate = reader.nextInt();
        
        Sayi say = new Sayi(calculate);
        
        
        // Seri Hesaplama Yapılıyor.
        for (int i = 2; i <= calculate; i++) 
        {
          num = num.multiply(BigInteger.valueOf(i));
        }
        long end = System.nanoTime();
        double time = (end-start)/1000000.0;
        System.out.println("Seri Hesaplama: \t" + 
        String.format("%.2f",time) + " miliseconds");    
        
        //Paralel Hesaplama Yapılıyor.
        BigInteger num1 = BigInteger.valueOf(1);
        BigInteger num2 = BigInteger.valueOf(1);
        ExecutorService myPool = Executors.newFixedThreadPool(2);
        start = System.nanoTime();

            myPool.execute(new MyMultiplication(num1,calculate));  
            Thread.sleep(100);
            myPool.execute(new MyMultiplication(calculate,num2));

        myPool.shutdown();
        
        // Threadin bitmesi bekleniyor
        while(!myPool.isTerminated())   {}
        // Zaman hesaplanıyor
        end = System.nanoTime();
        time = (end-start)/1000000.0;
        System.out.println("Paralel Hesaplama: \t" +String.format("%.2f",time) 
        + " miliseconds");    
        
        // Sonuç Hesaplandı.
        BigInteger result = MyMultiplication.subResult1.multiply(MyMultiplication.subResult2);
        say.setSonuc(result);
        
        // Dosyaya yazma işlemleri
       try {
         
         String content = say.getSonuc().toString();
         File file = new File("sonuc.txt");
         
         // Yeni dosya yaratıldı
         file.createNewFile();
          
         FileWriter fw = new FileWriter(file.getAbsoluteFile());
         BufferedWriter bw = new BufferedWriter(fw);
         bw.write(content);
         bw.close();
         
         System.out.println("Sonuç sonuc.txt dosyasına yazıldı.");
      } catch (IOException e) {
         System.out.println("Dosyaya yazma sırasında hata oluştu.");
      } 
        
    }
    
}


