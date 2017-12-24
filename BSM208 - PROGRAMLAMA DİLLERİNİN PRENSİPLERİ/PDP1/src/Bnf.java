/*
* @author Alperen Kaymak alperen.kaymak@ogr.sakarya.edu.tr b151210098 , Erbil Nas erbil.nas@ogr.sakarya.edu.tr b151210053
* @since 29.02.2017
* 
*<p>
* Dosyadan okunan BNF seklindeki dosyayi okuyup terminalleri yazdirmak.
* </p>
 */

import java.io.*;
import java.util.regex.Matcher;
import java.util.regex.Pattern;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

public class Bnf {

    public static void main(String[] args) {
        // Dosya adi
        String dosyaadi = "Dosya.txt";

        // Terminallerin tutulacagi liste
        ArrayList<String> esleyen = new ArrayList<String>();

        // Dosyadaki satir icin degisken
        String satirlar = null;

        // Normal gösterimler icin
        Pattern yol = Pattern.compile(".(?!\\])");

        try {
            // Dosya okuma icin
            FileReader dosyayioku = new FileReader(dosyaadi);

            BufferedReader okuyucu = new BufferedReader(dosyayioku);

            // Dosyayi satir satir okuma
            while ((satirlar = okuyucu.readLine()) != null) {

                // Normal gösterimler icin
                Matcher esle = yol.matcher(satirlar);

                // Normal gösterimler de esleyenleri bulmak
                while (esle.find()) {
                    String gecici = esle.group().replaceAll("[^A-Za-z0-9]+", "");
                    if (gecici.length() != 0) {
                        if (!esleyen.contains(gecici)) {
                            esleyen.add(gecici);
                        }
                    }
                }
            }

            //Terminal sayisini ekrana yazdirma
            System.out.println("Terminal Sayisi:" + esleyen.size());
            // Terminalleri ekrana yazdirma
            System.out.println("Terminaller:");

            for (int i = 0; i < esleyen.size(); i++) {
                System.out.println(esleyen.get(i));
            }
            //Dosya kapatmak
            okuyucu.close();

        } catch (FileNotFoundException ex) {
            System.out.println("Dosya bulunamadi.");
        } catch (IOException ex) {
            Logger.getLogger(Bnf.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
}
