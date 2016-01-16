package mx.itc.teddy;

import java.io.*;

public class Compilador {

	private String fileName;
	private String LANG;
	private String runId;
	final private boolean imprimirSalida = true;

	public boolean compilar() {
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
			//String [] test = fileName.split("/");
			//comando = "./compileC " + test[2] + " " + test[3]; //comando = "gcc " + fileName;
			comando = "gcc " + fileName + " -o /var/tmp/teddy/work_zone/" + runId  + "/a.out -O2 -ansi -fno-asm -Wall -lm -static -DONLINE_JUDGE";
		}

		if(LANG.equals("C++")){
			// String [] test = fileName.split("/");
			// comando = "./compileC++ " + test[2] + " " + test[3]; 
			comando = "g++ " + fileName + " -o /var/tmp/teddy/work_zone/" + runId  + "/a.out -O2 -ansi -fno-asm -Wall -lm -static -DONLINE_JUDGE";
			//			g++ $2 -O2 -ansi -fno-asm -Wall -lm -static -DONLINE_JUDGE


		}


		TeddyLog.logger.info("Comando para compilar > " + comando);
		int exitVal = -1;

		//intentar compilar
		try{
			Process proc = Runtime.getRuntime().exec(comando);

			//esperar hasta que termine el proceso
			exitVal = proc.waitFor();

			//si es que vamos a imprimir salida
			if (imprimirSalida) {
				//capturar la salida
				InputStreamReader isr = new InputStreamReader(proc.getInputStream());
				BufferedReader br = new BufferedReader(isr);

				String linea = "";
				while ((linea = br.readLine()) != null) {
					//imprimir en salida estandar
					TeddyLog.logger.warn("StdOut>>> " + linea);
				}

				//leer salida de error
				InputStreamReader isr2 = new InputStreamReader( proc.getErrorStream() );
				BufferedReader br2 = new BufferedReader( isr2 );

				String linea2 = null;
				String endString = "";

				while ((linea2 = br2.readLine()) != null) {
					TeddyLog.logger.warn("StdErr>>> " + linea2);
					endString += linea2 + "\n";
				}

				if(endString.length() > 0){
					PrintWriter pw = new PrintWriter( new FileWriter( "/usr/teddy/codigos/" + runId + ".compiler_out") );
					pw.println( endString );
					pw.flush();
					pw.close();
				}
			}

		}catch(Exception e){
			//error interno del juez
			TeddyLog.logger.fatal("ERROR EN EL JUEZ: " + e);
			return false;
		}


		//si pudo compilar el juez
		//depende lo que regrese el compilador es si si compilo o no compilo
		return (exitVal == 0);
	}

	//constructor
	Compilador( ){
		TeddyLog.logger.info("Creando compilador...");
	}

	void setLang(String LANG){
		this.LANG = LANG;
	}

	void setFile(String fileName){
		this.fileName = fileName;
	}

	void setRunId(String runId){
		this.runId = runId;
	}
}

