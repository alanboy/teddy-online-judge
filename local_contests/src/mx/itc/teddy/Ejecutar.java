package mx.itc.teddy;

import java.io.*;

public class Ejecutar implements Runnable{
	
	private String execID;
	private String LANG;
	final private boolean imprimirSalida = true;
	public String status = "TIME";	
	private Process proc;
	private String PID;
	private String comando;
	private String killcomand;

	public void destroyProc(){
		proc.destroy();
		destroyPID();
	}

	public void destroyPID(){

		//destruid pid con kill
		try{
			proc = Runtime.getRuntime().exec("./killprocess " + killcomand);
		}catch(IOException ioe){
			System.out.println(ioe);
		}

		//System.out.println("./killprocess " + killcomand);//java Main USER_CODE 0.3451665593858829
	}

	public void run(){
		synchronized(this){

			//ubicacion de el script sh externo
			comando = "";

			double uid = Math.random();

			//genera el comando ke se ejecutara si es java
			if(LANG.equals("Python")) {
				comando = "./runPython "+ execID  + ".py " + execID + " " + uid;
				killcomand = "python Main.py USER_CODE " + uid;
			}

			//genera el comando ke se ejecutara si es java
			if(LANG.equals("JAVA")){
				comando = "./runJava " + execID + " " + uid ;
				killcomand = "java Main USER_CODE " + uid;
			}

			//genera el comando ke se ejecutara si es perl
			if(LANG.equals("Perl")){
				comando = "./runPerl " + execID + " " + uid ;
				killcomand = "perl Main.pl USER_CODE " + uid;
			}

			//si es C
			if(LANG.equals("C")){
				comando = "./runC " + execID  + " " + uid; 
				killcomand = "a.out USER_CODE " + uid;
			}

			//si es C++
			if(LANG.equals("C++")){
				comando = "./runC " + execID  + " " + Math.random(); 
				killcomand = "a.out USER_CODE " + uid;
			}

			int exitVal = 0;

			PID = comando;

			try{
				//ejecutar el script
				proc = Runtime.getRuntime().exec(comando);

				//imprmir salida 
				if(imprimirSalida){

					//leer salida estandar
					InputStreamReader isr = new InputStreamReader( proc.getInputStream() );
					BufferedReader br = new BufferedReader(isr);
					boolean impMsg = true;
					String linea = null;
					while((linea = br.readLine()) != null){
						if(impMsg){
							System.out.println("Impresiones de tu programa a salida estandar:");
							impMsg = false;
						}
						System.out.println( linea );
					}

					//leer salida de error
					InputStreamReader isr2 = new InputStreamReader( proc.getErrorStream() );
					BufferedReader br2 = new BufferedReader( isr2 );
					impMsg = true;
					String linea2 = null;
					while((linea2 = br2.readLine()) != null){
						if(impMsg){
							System.out.println("Impresiones de tu programa a salida de error:");
							impMsg = false;
						}
						System.out.println( linea2 );
					}				
				}

				//esperar a que termine el proceso
				exitVal = proc.waitFor();
				
			} catch( Exception e ) {

				//error interno del juez
				//status = "ERROR_JUEZ";
				//System.out.println("Error, el juez no ha podido ejecutar el programa. \n" + e);
				//return;
			}

			//alguna exception del progrma invitado
			if( exitVal != 0 ) { 
				System.out.println(exitVal);
				status = "EXCEPTION";
				return; 
			}

			//avisar al otro hilo que hemos terminado
			status = "OK";
			notify();
		}
	}//run code thread

	void setLang( String lang ){
		LANG = lang;
	}

	//constructor
	Ejecutar(String s){
		this.execID = s;
	}

}//clase ejecutar
