
import java.nio.charset.StandardCharsets;
import java.security.Key;
import java.sql.Time;
import java.util.Date;

import javax.crypto.BadPaddingException;
import javax.crypto.Cipher;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import javax.xml.bind.DatatypeConverter;

import org.apache.commons.codec.binary.Base32;
import org.apache.commons.codec.binary.Base64;

public class DecriptionAES extends Thread{
	String alphabet = "0123456789abcdefghijklmnoqprstuwxyzÍÛπú≥øüÊÒABCDEFGHIJKLMNOQPRSTUWXYZ”å£Øè∆—Vv.,?! \n";
	public String prefix = "";
	public String sufix = "9dd9e45785bf6c260728f75986d79f3eef6cc89c08e7646428bff9f";
	public String iv = "091927ba164026bd641e9708c390e0d5";
	public String mess = "9ekbnex9MXm7clvL8xb+Aezm3F+1WC7HXqMN3KlwWmBo8Tbn3KXhrNQEaCmws9uXSgKNX2D0/ymB89QgFG6Lk3KppgfwwUaN4Yi9OckSmUjMzEC3WcHzhosxjnFS1JKhqjpF+7NuO+boxFsfT42AzjpL/dFJBRME2nsqonuzbt0=";
	public String output="";
	//public String messEn="Bronislaw Komorowski ma nowa prace.\n";
	public int firstLetter;
	private long t = new Date().getTime();
	
	
	public void run(){ 
		bruteForce();
	}
	
	
	
	public static String decrypt(String key, String initVector, String encrypted){
        try {
            IvParameterSpec iv = new IvParameterSpec(DatatypeConverter.parseHexBinary((initVector)));
            SecretKeySpec skeySpec = new SecretKeySpec(DatatypeConverter.parseHexBinary((key)), "AES");
            byte[] ecryptedTextBytes = DatatypeConverter.parseBase64Binary(encrypted);
            
            Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
            cipher.init(Cipher.DECRYPT_MODE, skeySpec, iv);
            
            byte[] decryptedTextByte = null;
            decryptedTextByte = cipher.doFinal(ecryptedTextBytes);
            return new String(decryptedTextByte, StandardCharsets.UTF_8);
        } catch (Exception ex) {} 
        return null;
    }
	
	public static String encrypt(String key, String initVector, String crypted) {
        try {
            IvParameterSpec iv = new IvParameterSpec(DatatypeConverter.parseHexBinary((initVector)));
            SecretKeySpec skeySpec = new SecretKeySpec(DatatypeConverter.parseHexBinary((key)), "AES");

            Cipher cipher = Cipher.getInstance("AES/CBC/PKCS5Padding");
            cipher.init(Cipher.ENCRYPT_MODE, skeySpec, iv);
            
            byte[] original = cipher.doFinal(crypted.getBytes(StandardCharsets.UTF_8));
            
            
            return Base64.encodeBase64String(original);
        } catch (Exception ex) {
            ex.printStackTrace();
        }
        return null;
    }
	
	
	
	private void bruteForce(){
		char[] characters = new char[]{'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'};
		
		for(int t=firstLetter; t < firstLetter+4; t++){
			
			for(int p=0; p < characters.length; p++){
				
				for(int n=0; n < characters.length; n++){
					
					for(int m=0; m < characters.length; m++){
						
						for(int l=0; l < characters.length; l++){
							
							for(int k=0; k < characters.length; k++){
								
								for(int j=0; j < characters.length; j++){
									
									for(int i=0; i < characters.length; i++){
										for(int w=0; w < characters.length; w++){
											prefix = Character.toString(characters[w])+Character.toString(characters[i])+Character.toString(characters[j])+Character.toString(characters[k])+Character.toString(characters[l])+Character.toString(characters[m])+Character.toString(characters[n])+Character.toString(characters[p])+Character.toString(characters[t]);
											if(checking(prefix)){
												System.out.println(output);
												System.out.println(prefix);
												Date d = new Date();
												System.out.println("time: "+(this.t-d.getTime()));
												System.exit(0);
											}
										}
									}
										
								}
							}
						}
					}
				}
			}
		}
		
	}
	
	
	private boolean checking(String prefix){
		System.err.println(prefix);
		
		output = decrypt(prefix+sufix, iv, mess);
		if(output == null){
			return false;
		}
		for(int i=0; i < output.length(); i++){
				if(alphabet.indexOf(output.charAt(i))< 0){
					return false;
				}
		}
		return true;
		
	}
	
	
	
	public static void main(String[] args) {
		DecriptionAES o1 = new DecriptionAES();
		o1.firstLetter = 0;
		o1.start();
		DecriptionAES o2 = new DecriptionAES();
		o2.firstLetter = 4;
		o2.start();
		DecriptionAES o3 = new DecriptionAES();
		o3.firstLetter = 8;
		o3.start();
		DecriptionAES o4 = new DecriptionAES();
		o4.firstLetter = 12;
		o4.start();
	}
	
}
