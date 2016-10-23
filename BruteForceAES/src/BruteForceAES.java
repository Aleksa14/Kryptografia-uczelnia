import java.io.BufferedReader;
import java.io.BufferedWriter;
import java.io.InputStreamReader;
import java.io.OutputStreamWriter;

public class BruteForceAES extends Thread{
	
	static String output;
	static int firstLetter;

	public static void main(String[] args) {
		BruteForceAES o1 = new BruteForceAES();
		o1.firstLetter = 0;
		o1.start();
		BruteForceAES o2 = new BruteForceAES();
		o2.firstLetter = 4;
		o2.start();
		BruteForceAES o3 = new BruteForceAES();
		o3.firstLetter = 8;
		o3.start();
		BruteForceAES o4 = new BruteForceAES();
		o4.firstLetter = 12;
		o4.start();
	}
	
	public void run(){ 
		bruteForce();
	}
	
	private String executeCommand(String command, String msg) {

		StringBuffer output = new StringBuffer();

		Process p;
		try {
			p = Runtime.getRuntime().exec(command);
			BufferedWriter write = new BufferedWriter(new OutputStreamWriter(p.getOutputStream()));
			BufferedReader reader = new BufferedReader(new InputStreamReader(p.getInputStream()));
			write.write(msg);
			write.newLine();
			write.close();
			
			p.waitFor();

                        String line = "";
			while ((line = reader.readLine())!= null) {
				output.append(line + "\n");
			}

		} catch (Exception e) {
			e.printStackTrace();
		}

		return output.toString();

	}
	
	private static boolean checking(String prefix){
		String alphabet = "0123456789abcdefghijklmnoqprstuwxyzęóąśłżźćńABCDEFGHIJKLMNOQPRSTUWXYZĘÓĄŚŁŻŹĆŃVv.,?! ";
		BruteForceAES obj = new BruteForceAES();
		System.out.println(prefix);
		String mg = "7NIWsJzMvjxgYa+hCpvFdhXyi7lTLyqdt58XpHd0he0Vz9cHhY1jlZKXm9pvKDNw\n";
		String sufix = "3de132ba6c33cf0e645dcb2d3277c26e90dc833681b45e66d6abcb68";
		String iv = "901fa6e997b67af21142710149ab6e6d";
		String key = prefix+sufix;
		String command = "openssl enc -d -A -aes-256-cbc -base64 -K " +key+ " -iv " +iv;
		
		output = obj.executeCommand(command, mg);
		
		for(int i=0; i < output.length(); i++){
				if(alphabet.indexOf(output.charAt(i))< 0){
					return false;
				}
		}
		return true;
		
	}
	
	private static void bruteForce(){
		String prefix="";
		char[] characters = new char[]{'0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'};
		
		for(int t=firstLetter; t < firstLetter+4; t++){
			
			for(int p=0; p < characters.length; p++){
				
				for(int n=0; n < characters.length; n++){
					
					for(int m=0; m < characters.length; m++){
						
						for(int l=0; l < characters.length; l++){
							
							for(int k=0; k < characters.length; k++){
								
								for(int j=0; j < characters.length; j++){
									
									for(int i=0; i < characters.length; i++){
										prefix = Character.toString(characters[i])+Character.toString(characters[j])+Character.toString(characters[k])+Character.toString(characters[l])+Character.toString(characters[m])+Character.toString(characters[n])+Character.toString(characters[p])+Character.toString(characters[t]);
										if(checking(prefix)){
											System.out.println(output);
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
