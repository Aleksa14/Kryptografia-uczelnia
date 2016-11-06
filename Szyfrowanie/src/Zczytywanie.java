import java.util.Scanner;

public class Zczytywanie {

	public static void main(String[] args) {
		
		Szyfrowanie sz = new Szyfrowanie();
		Scanner s = new Scanner(System.in);
		System.out.println("Sciezka do pliku: ");
		String plik = s.nextLine();
		
		System.out.println("Sciezka do keystore: ");
		String keyplik = s.nextLine();
		
		System.out.println("Id klucza: ");
		String id = s.nextLine();
		
		System.out.println("Schemat szyfrowania: ");
		String alg = s.nextLine();
		
		System.out.println("Tryb szyfrowania: ");
		String mode = s.nextLine();
		
		System.out.println("Has³o do klucza: ");
		char[] passw =/* System.console().readPassword()*/ s.nextLine().toCharArray();
		
		
		
		System.out.println("Encrypt czy decrypt: ");
		String type = s.nextLine();
		if(type.equals("encrypt")){
			sz.encripting(plik, keyplik, id, passw, alg, mode);
		}else{
			sz.decripting(plik, keyplik, id, passw, alg, mode);
		}
	}

}

