package mx.itc.teddy;

import java.io.*;


public class Compilador {

	private String fileName;
	private String LANG;
	final private boolean imprimirSalida = true;

	public boolean compilar(){

		String comando = "";

		//no hay necesidad de compilar a python
		if(LANG.equals("Python")) 
			return true;

		//no hay necesidad de compilar perl
		if(LANG.equals("Perl")) 
			return true;

		//no hay necesidad de compilar php
		if(LANG.equals("Php")) 
			return true;


		//genera el comando ke se ejecutara
		if(LANG.equals("JAVA")) 
			comando = "javac " + fileName;


		if(LANG.equals("C")){
			 String [] test = fileName.split("/");
			 comando = "./compileC " + test[2] + " " + test[3]; //comando = "gcc " + fileName;
		}

		if(LANG.equals("C++")){
			 String [] test = fileName.split("/");
			 comando = "./compileC++ " + test[2] + " " + test[3]; 
		}

		System.out.println("Comando para compilar > " + comando);
		int exitVal = -1;

		//intentar compilar
		try{
			Process proc = Runtime.getRuntime().exec(comando);

			//esperar hasta que termine el proceso
			exitVal = proc.waitFor();

			//si es que vamos a imprimir salida
			if(imprimirSalida){
		
				//capturar la salida
				InputStreamReader isr = new InputStreamReader(proc.getInputStream());
				BufferedReader br = new BufferedReader(isr);
				
				String linea = "";
				while((linea = br.readLine()) != null){
					//imprimir en salida estandar
					System.out.println( linea );
				}

				//leer salida de error
				InputStreamReader isr2 = new InputStreamReader( proc.getErrorStream() );
				BufferedReader br2 = new BufferedReader( isr2 );
				
				
				
				String linea2 = null;
				String endString = "";
				
				while((linea2 = br2.readLine()) != null){

					System.out.println( ">" + linea2 );
					endString += linea2 + "\n";
				}
				
				if(endString.length() > 0){
					PrintWriter pw = new PrintWriter( new FileWriter( "../codigos/" + fileName.split("/")[2]  + ".compiler_out") );
					pw.println( endString );
					pw.flush();
					pw.close();					
				}


			}

		}catch(Exception e){
			//error interno del juez
			System.out.println("ERROR EN EL JUEZ: " + e);
			return false;
		}
		

		//si pudo compilar el juez
		//depende lo que regrese el compilador es si si compilo o no compilo
		return (exitVal == 0);
	}

	//constructor
	Compilador( ){
		System.out.println("Creando compilador...");
	}

	void setLang( String LANG ){
		System.out.println("Setting language..." + LANG);		
		this.LANG = LANG;
	}

	void setFile( String fileName ){
		System.out.println("Setting filename..." + fileName);		
		this.fileName = fileName;
	}

}

