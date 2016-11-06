package mp3Decoder;

import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.nio.file.Paths;
import java.util.Scanner;
import javafx.scene.media.Media;
import javafx.scene.media.MediaPlayer;
import javazoom.jl.player.Player;

import org.apache.commons.codec.binary.Base64;

public class Decoder {
	
	static String k2 = "B1V6ZmOHVNgM9vUo05vGPg==";
	
	
	public static void main(String args[]){
		String konfig = Szyfrowanie.decripting2("konfig.txt", k2, "AES", "CBC");
		System.err.println(konfig);
		String[] tab = konfig.split("\r\n");
		Scanner s = new Scanner(System.in);
		System.out.println("Podaj PIN: ");
		String pin = s.nextLine();
		if(!pin.equals(tab[0])){
			System.err.println("Zly PIN");
			System.exit(2);
		}
		System.out.println("Co odtworzyc: ");
		String mp3 = s.nextLine();
		Szyfrowanie.decripting(mp3, tab[1], tab[2], tab[3].toCharArray(), "AES", "CBC");
		/*Media hit = new Media(Paths.get("temp.mp3").toUri().toString());
		MediaPlayer mediaPlayer = new MediaPlayer(hit);
		mediaPlayer.play();*/
		 try {
             
             FileInputStream fis = new FileInputStream("temp.mp3");// tutaj nale¿y podaæ œcie¿kê do pliku z muzyk¹
             Player playMP3 = new Player(fis); 
             playMP3.play(); // odtwarza muzykê
         }catch(Exception e){
        	 e.printStackTrace();
         }
		
		
	}
	
	
	
	
	
	
	
	
}
