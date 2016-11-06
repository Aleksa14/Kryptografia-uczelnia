import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.FileWriter;
import java.io.IOException;
import java.io.InputStream;
import java.nio.charset.StandardCharsets;
import java.security.Key;
import java.security.KeyStore;
import java.security.KeyStoreException;
import java.security.NoSuchAlgorithmException;
import java.security.UnrecoverableKeyException;
import java.security.cert.CertificateException;

import org.apache.commons.codec.binary.Base64;
import javax.crypto.Cipher;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import javax.xml.bind.DatatypeConverter;


public class Szyfrowanie {
	
	public void decripting(String plik, String keyplik, String alias, char[] passw, String alg, String mode){
		FileReader fr = null;
		try{
			fr = new FileReader(plik);
		}catch (FileNotFoundException e) {
			System.out.println("B£¥D PRZY OTWIERANIU PLIKU!");
		}
		BufferedReader bf = new BufferedReader(fr);
		String out = "";
		String iv=null;
		try {
			iv = bf.readLine();
		} catch (IOException e1) {
			e1.printStackTrace();
		}
		try{
			while(bf.ready()){
				out = out + bf.readLine();
			}
		}catch(IOException e){
			System.out.println("B£¥D ODCZYTU Z PLIKU!");
		}
		try {
			fr.close();
			bf.close();
		}catch (IOException e) {
			System.out.println("B£¥D PRZY ZAMYKANIU PLIKU!");
		}
		
		String change = decrypt(findKey(keyplik, alias, passw), out, alg, mode, iv);
		
		FileWriter fw = null;
		try{
			fw = new FileWriter(plik);
		}catch (IOException e) { 
	        e.printStackTrace();
		}
		BufferedWriter bw = new BufferedWriter(fw);
		try {
			bw.write(change);
		} catch (IOException e) {
			e.printStackTrace();
		}
		try {
			bw.close();
			fw.close();
		} catch (IOException e) {
			e.printStackTrace();
		}
				
	}
	
	public byte[] findKey(String keyPlik, String alias, char[] passw){
		KeyStore ks=null;
		FileInputStream readStream=null;
		Key key=null;
		try {
			ks = KeyStore.getInstance("JCEKS");
		} catch (KeyStoreException e) {
			e.printStackTrace();
		}
		try {
			readStream = new FileInputStream(keyPlik);
		} catch (FileNotFoundException e) {
			e.printStackTrace();
		}
		try {
			ks.load(readStream, "".toCharArray());
			key = ks.getKey(alias, passw);
			readStream.close();
		} catch (NoSuchAlgorithmException e) {
			e.printStackTrace();
		} catch (CertificateException e) {
			e.printStackTrace();
		} catch (IOException e) {
			e.printStackTrace();
		} catch (UnrecoverableKeyException e) {
			e.printStackTrace();
		} catch (KeyStoreException e) {
			e.printStackTrace();
		}
		
		return key.getEncoded();
		
	}
	
	

	public static String decrypt(byte[] key, String encrypted, String alg, String mode, String siv){
        try {
            IvParameterSpec iv = new IvParameterSpec(Base64.decodeBase64(siv));
            SecretKeySpec skeySpec = new SecretKeySpec(key, "AES");
            byte[] ecryptedTextBytes = DatatypeConverter.parseBase64Binary(encrypted);
            
            Cipher cipher = Cipher.getInstance(alg+"/"+mode+"/PKCS5Padding");
            cipher.init(Cipher.DECRYPT_MODE, skeySpec, iv);
            
            byte[] decryptedTextByte = null;
            decryptedTextByte = cipher.doFinal(ecryptedTextBytes);
            return new String(decryptedTextByte, StandardCharsets.UTF_8);
        } catch (Exception ex) {
        	ex.printStackTrace();
        } 
        return null;
    }
	
	
	public void encripting(String plik, String keyplik, String alias, char[] passw, String alg, String mode){
		FileReader fr = null;
		try{
			fr = new FileReader(plik);
		}catch (FileNotFoundException e) {
			System.out.println("B£¥D PRZY OTWIERANIU PLIKU!");
		}
		BufferedReader bf = new BufferedReader(fr);
		String out = "";
		try{
			while(bf.ready()){
				out = out + bf.readLine() + "\r\n";
			}
		}catch(IOException e){
			System.out.println("B£¥D ODCZYTU Z PLIKU!");
		}
		try {
			fr.close();
		}catch (IOException e) {
			System.out.println("B£¥D PRZY ZAMYKANIU PLIKU!");
		}
		
		String change = encrypt(findKey(keyplik, alias, passw), out, alg, mode);
		
		FileWriter fw = null;
		try{
			fw = new FileWriter(plik);
		}catch (IOException e) { 
	        e.printStackTrace();
		}
		BufferedWriter bw = new BufferedWriter(fw);
		try {
			bw.write(eiv);
			bw.newLine();
			bw.write(change);
		} catch (IOException e) {
			e.printStackTrace();
		}
		try {
			bw.close();
			fw.close();
		} catch (IOException e) {
			e.printStackTrace();
		}
				
	}
	
	private static String eiv;
	public static String encrypt(byte[] key, String crypted, String alg, String mode) {
        try {
            //IvParameterSpec iv = new IvParameterSpec(DatatypeConverter.parseHexBinary((initVector)));
            SecretKeySpec skeySpec = new SecretKeySpec(key, "AES");

            Cipher cipher = Cipher.getInstance(alg+"/"+mode+"/PKCS5Padding");
            cipher.init(Cipher.ENCRYPT_MODE, skeySpec);
            
            byte[] original = cipher.doFinal(crypted.getBytes(StandardCharsets.UTF_8));
            eiv = Base64.encodeBase64String(cipher.getIV());
            
            return Base64.encodeBase64String(original);
        } catch (Exception ex) {
            ex.printStackTrace();
        }
        return null;
    }
	
	
}
