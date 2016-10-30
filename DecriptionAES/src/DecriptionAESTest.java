import static org.junit.Assert.*;

import java.util.Base64;

import org.junit.Test;

public class DecriptionAESTest {

	@Test
	public void test() {
		//String strkryp = "00100110 11001010 00111111 00000001 10001101 10100011 11001110 10000111 10010000 00110111 11000110 10001011 01010110 00100000 00011100 11111010 11011001 11001100 10111101 11001011 00100101 00010101 01011110 01111010 10010101 10101100 11000101 11101100 11001100 00000001 00111110 01100000 01100010 10100000 11110010 11101100 11011110 10101111 11011001 01000011 10110011 11001001 01110101 10001001 11011001 01000110 10001000 01000100";
		//String[] tabkryp = strkryp.split(" "); 
		//byte[] kryptogram = new byte[tabkryp.length];
		/*for(int i=0; i<kryptogram.length; i++){
			kryptogram[i] = (byte) Integer.parseInt(tabkryp[i]);		
		}
		String finalkryp = Base64.getEncoder().encodeToString(kryptogram);
		String encode = DecriptionAES.decrypt("000000003de132ba", "8cbea64be3e34b4acf350a70fbb284f1", finalkryp);
		*/
		DecriptionAES decr = new DecriptionAES();
		String encode = decr.encrypt(decr.prefix+decr.sufix, decr.iv, decr.messEn);
		//String decode = decr.decrypt(decr.prefix+decr.sufix, decr.iv, decr.mess);
		System.out.println("odszyfrowane: "+encode);
		
	}

}
