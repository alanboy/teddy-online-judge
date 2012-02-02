package mx.itc.teddy;
import java.sql.*;
import java.io.*;

/**
* 
* 
* 
**/
public class Teddy {
	

	//fields
	//conexion a la base de datos
	static private Conexion con;
	private static boolean DEBUG;
	private static boolean FULL_DEBUG ;
	static String LANG;


	public static void main( String [] args ){
		
		for(String foobar : args)
			if( foobar.equals("-h") ){
				System.out.println("-------------------------");
				System.out.println("| Teddy Online Judge !   |");
				System.out.println("-------------------------");
				System.out.println("Usage:");
				System.out.println(" -d       Modo de debug basico");
				System.out.println(" -df      Modo de debug completo");
				System.out.println(" -h       Ayuda");												
				System.exit(1);
			}
		
		
		DEBUG 		= false;
		FULL_DEBUG 	= false;


		for(String foobar : args){
			if( foobar.equals("-d") )
				DEBUG = true;

			if( foobar.equals("-df") )
				FULL_DEBUG = true;				
		}
			
		
		System.out.println("-- Teddy Online Judge --");

		while(true){
			try{
				//sleep for ten seconds
				run();
				Thread.sleep(3000);

			}catch(Exception e){

				System.out.println(e);
			}

		}
		
		
		
		
		
	}


	public static void run(  ){
		
		String execID;
		String userID;
		String probID;
		String concursoID;

		//crear conexion con base
		try{
			if(FULL_DEBUG) System.out.println("Conectandose a la base de datos.");
			con = new Conexion();

		}catch(Exception e){
			System.out.println("Error al crear la conexion con la base de datos.");
			return;
		}




		//leer la base de datos y revisar si hay runs en waiting...
		ResultSet rs = con.query( "SELECT * FROM Ejecucion WHERE status = 'WAITING' LIMIT 1;" );
		if(FULL_DEBUG) System.out.println("SELECT * FROM Ejecucion WHERE status = 'WAITING' LIMIT 1;");
		/*
		if(FULL_DEBUG) System.out.println("");
		if(FULL_DEBUG) System.out.println("");
		if(FULL_DEBUG) System.out.println("");
		if(FULL_DEBUG) System.out.println("");
		*/
		try{
			if(!rs.next()) {
				if(FULL_DEBUG) System.out.println("No runs on wait...");
				return;
			}

			System.out.println( "-------------------------- RUN --------------------------------------");
			System.out.println( "Total memoria de la maquina virutal : " +  (Runtime.getRuntime().totalMemory() / 1024) + "kb");
			System.out.println( "There is a run on wait : " + rs.getString("execID") );

			execID   = 	rs.getString("execID");
			LANG     = 	rs.getString("LANG");
			userID   = 	rs.getString("userID");
			probID 	= 	rs.getString("probID");
			concursoID = 	rs.getString("Concurso");

		}catch(SQLException sqle){

			System.out.println("Error al contactar la BD.");
			return;
		}


		
		//crear el nombre del archivo
		String fileName = 	"";
		if(LANG.equals("JAVA")){
			fileName = execID + ".java";			
		}

		if(LANG.equals("C")){
			fileName = execID + ".c";
		}

		if(LANG.equals("C++")){
			fileName = execID + ".cpp";
		}

		if(LANG.equals("Python")){
			fileName = execID + ".py";
		}

		if(LANG.equals("C#")){
			fileName = execID + ".cs";
		}

		if(LANG.equals("Perl")){
			fileName = execID + ".pl";
		}

		String rawFileName = 	"";

		//es un concurso ?
		boolean concurso = !concursoID.equals("-1");


		if(DEBUG) {
			System.out.println("execID     : " + execID);
			System.out.println("concursoID : " + concursoID);
			System.out.println("probID : " + probID);
			System.out.println("lenguage : " + LANG);
			System.out.println("userID : " + userID);
		}




		//crear un directorio para trabajar con ese codigo
		File directorio = new File("../work_zone/" + execID);
		directorio.setWritable(true);
		directorio.mkdir();
		directorio.deleteOnExit();

		//crear un objeto File de el codigo fuente que se ha subido en la primer carpeta
		File cf = new File( "../codigos/" + fileName);
		cf.setWritable(true);


		//crer un objeto File donde se guardara el codigo fuente para ser compilado dentro de su sub-carpeta
		File cfNuevo = new File( directorio, fileName );
		try{
			cfNuevo.createNewFile();
		}catch(IOException ioe){
			System.out.println("Error al escribir en el disco duro.");
			return;
		}


		//copiar linea por linea el contenido en el archivo del work_zone
		try{
			BufferedReader br = new BufferedReader(new FileReader( cf ));
			PrintWriter pw = new PrintWriter( cfNuevo );

			String contents = "";
			while((contents = br.readLine()) != null){

				//aqui puedo ir revisando linea por linea por codigo malicioso
				pw.println( contents );
				
			}
			pw.flush();
			pw.close();

		}catch(FileNotFoundException fnfe){
			System.out.println("No se ha podido leer el archivo de codigo fuente." );
			System.out.println(fnfe);
			con.update("UPDATE Ejecucion SET status = 'ERROR' WHERE execID = "+ execID +" LIMIT 1 ;");
			return;
			
		}catch(IOException ioe){
			System.out.println("Error al transcribir el codigo fuente." + ioe);
			con.update("UPDATE Ejecucion SET status = 'ERROR' WHERE execID = "+ execID +" LIMIT 1 ;");
			return;
		}



		//ok todo va bien, ahora si poner las cosas en la base de datos de todo lo que he hecho
		// 
		//ponerlo como que estoy jueseandooo
		con.update("UPDATE Ejecucion SET status = 'JUDGING' WHERE execID = "+ execID +" LIMIT 1 ;");
		
		//agregar un nuevo intento a ese problema
		con.update("UPDATE Problema SET intentos = (intentos + 1) WHERE probID = "+ probID +" LIMIT 1 ");

		//agregar un nuevo intento a este chavo
		con.update("UPDATE Usuario SET tried = tried + 1  WHERE userID = '"+ userID +"' LIMIT 1 ;");

		//--------------compilar el codigo fuente-----------------------------------//
		// obvio depende de que voy a compilar

		//al constructor se le proporciona la ruta hasta el .java
		Compilador c = new Compilador();
		c.setLang( LANG );
		c.setFile( "../work_zone/" + execID +"/" + fileName );

		//verificar si compilo bien o no
		if( ! c.compilar() ){
			System.out.println("COMPILACION FALLIDA");

			//no compilo, actualizar la base de datos
			con.update("UPDATE Ejecucion SET status = 'COMPILACION' WHERE execID = "+ execID +" LIMIT 1 ;");

			//cerrar la conexion a la base
			terminarConexion();
	
			//salir
			return;
		}


		//brindarle los datos de entrada ahi en la carpeta
		//esos datos estan en la base de datos
		String titulo ;
		int tiempoLimite;

		rs = con.query("SELECT titulo, tiempoLimite FROM Problema WHERE probID = " + probID);
		try{
			rs.next();
			titulo  = rs.getString("titulo");
			tiempoLimite = Integer.parseInt ( rs.getString("tiempoLimite") );

		}catch(SQLException sqle){

			System.out.println("Error al contactar la BD.");
			return;
		}

		

		//generar el archivo de entrada para el programa
		File archivoEntrada = new File(directorio, "data.in");
		try{
			archivoEntrada.createNewFile();
		}catch(IOException ioe){
			System.out.println("Error al escribir el archivo de entrada." + ioe);
			con.update("UPDATE Ejecucion SET status = 'ERROR' WHERE execID = "+ execID +" LIMIT 1 ;");
			return;
		}



		//llenar el contenido del archivo de entrada
		try{
			BufferedReader br = new BufferedReader( new FileReader( "../casos/"+probID+".in" ));
			PrintWriter pw = new PrintWriter( archivoEntrada );
			String s = null;
			while((s = br.readLine()) != null){
				pw.println( s );
			}	
			pw.flush();
			pw.close();

		}catch(IOException ioe){
			System.out.println("Error al transcribir el archivo de entrada." );
			System.out.println( ioe );			
			con.update("UPDATE Ejecucion SET status = 'ERROR' WHERE execID = "+ execID +" LIMIT 1 ;");
			return;
		}

		//eliminar el archivo de entrada al terminar el proceso
		//archivoEntrada.deleteOnExit();


		//--------------ejecutar lo que salga de la compilacion -----------------------------------//
		// 

		if(DEBUG) System.out.println("ejecutando...");

		//aqui esta lo bueno, ejecutar el codigo... sniff
		// por el momento al la clase ejecutar solo le pasaremos
		// el execID y con eso ejecutara el Main que este dentro o el a.out etc 
		Ejecutar e = new Ejecutar( execID );

		//decirle que lenguaje es... pudiera ser c, c++, python, etc
		e.setLang ( LANG );

		//la clase ejecutar es un hilo
		Thread ejecucion = new Thread(e);

		//comienza el tiempo
		long start = System.currentTimeMillis();

		//iniciar el hilo
		ejecucion.start();

		synchronized(ejecucion){
			try{
				//esperar hasta el tiempo limite
				ejecucion.wait( tiempoLimite );

			}catch(InterruptedException ie){
				//ni idea... :s
				con.update("UPDATE Ejecucion SET status = 'ERROR' WHERE execID = "+ execID +" LIMIT 1 ;");
				System.out.println("thread interrumpido");
			}

			//al regresar, si el otro hilo sigue vivo entonces detenerlo
			if(ejecucion.isAlive()){
				//destruir el proceso... pero... como !
				//ejecucion.stop();
				e.destroyProc();
			}
		}


		//calcular tiempo total
		long tiempoTotal = System.currentTimeMillis() - start;

		//la varibale e.status contiene:
		//	TIEMPO 		si sobrepaso el limite de tiempo
		//	JUEZ_ERROR 	si surgio un error interno del juez
		//	EXCEPTION 	si el programa evaluado arrojo una exception

		if(DEBUG) System.out.println("resultado: "+ e.status);

		//revisar distintos casos despues de ejecutar el programa
		if( e.status.equals("TIME") ){
			//no cumplio en el tiempO
			System.out.println("TIEMPO");
			System.out.println("Tu programa fue detenido a los "+tiempoTotal+"ms");

			//guardar el resultado
			con.update("UPDATE Ejecucion SET status = 'TIEMPO', tiempo = "+ tiempoTotal +"  WHERE execID = "+ execID +" LIMIT 1 ;");

			//cerra base de datos
			terminarConexion();
			vaciarCarpeta( execID );

			//salir
			return;
		}


		if( e.status.equals("EXCEPTION") ){
			//arrojo una exception
			System.out.println("RUN-TIME ERROR");
			System.out.println("Tu programa ha arrojado una exception.");

			//guardar el resultado
			con.update("UPDATE Ejecucion SET status = 'RUNTIME_ERROR' WHERE execID = "+ execID +" LIMIT 1 ;");

			//cerra base de datos
			terminarConexion();
			vaciarCarpeta( execID );

			//salir
			return;
		}


		if( e.status.equals("JUEZ_ERROR") ){
			//arrojo una exception
			System.out.println("ERROR INTERNO EN EL JUEZ");

			//guardar el resultado
			con.update("UPDATE Ejecucion SET status = 'ERROR' WHERE execID = "+ execID +" LIMIT 1 ;");

			//cerra base de datos
			terminarConexion();
			vaciarCarpeta( execID );

			//salir
			return;
		}

		if(DEBUG) System.out.println("comprobando salida...");
		// ---------------------------------------------------------------------------- COMPROBAR SALIDA
		//si seguimos hasta aca, entonces ya solo resta compara el resultado
		//del programa con la variable salida
		String salidaTotal = "";


		int flag = 0;
		boolean erroneo = false;

		//leer los contenidos del archivo ke genero el programa he ir comparando linea por linea con la respuesta
		try{
			BufferedReader salidaDePrograma = new BufferedReader(new FileReader(new File(directorio, "data.out")));
			BufferedReader salidaCorrecta = new BufferedReader(new FileReader("../casos/" + probID + ".out"));

			String foo = null;
			String bar = null;
			while(((foo = salidaCorrecta.readLine()) != null) ){
				if((bar = salidaDePrograma.readLine()) == null) {
					erroneo = true;
					if(DEBUG) System.out.println("Se esperaban mas lineas de respuesta!!!") ;
					break;
				}


				if(DEBUG) System.out.println("ESPERADO : >" + foo + "<") ;
				if(DEBUG) System.out.println("RESPUESTA: >" + bar + "<") ;

				if(!foo.equals(bar)) {
					erroneo = true;
					if(DEBUG) System.out.println("^------ DIFF ------^") ;
				}
			}

			if((bar = salidaDePrograma.readLine()) != null) {
				if(! bar.trim().equals("")){
					erroneo = true;
					if(DEBUG) System.out.println("Ya acabde de leer la correcta pero tu programa tiene mas lineas") ;
					if(DEBUG) System.out.println("->"+bar) ;
				}
			}

		}catch(IOException ioe){
			
			System.out.println("NO SALIDA");
			System.out.println(ioe);

			con.update("UPDATE Ejecucion SET status = 'NO_SALIDA', tiempo = "+ tiempoTotal +"  WHERE execID = "+ execID +" LIMIT 1 ;");
			//cerra base de datos
			terminarConexion();
			vaciarCarpeta( execID );

			//salir
			return;						
		}

		if(DEBUG) System.out.println("erroneo : "+erroneo);

		if( !erroneo ){
			//programa correcto !
			System.out.println("OK");
			System.out.println("El tiempo fue de "+ tiempoTotal +"ms");

			//guardar el resultado de ejecucion
			con.update("UPDATE Ejecucion SET status = 'OK', tiempo = "+ tiempoTotal +"  WHERE execID = "+ execID +" LIMIT 1 ;");

			//darle un credito mas a este chavo solo si no ha resuelto este antes
			//revisar si ya lo ha resolvido
			rs = con.query("SELECT status FROM Ejecucion WHERE (probID = '" + probID +"' AND userID = '" + userID+"')" );
			int aciertos = 0;
			int intentos = 0;

			

			try{
				while(rs.next()){
					intentos++;
//					System.out.println("("+ intentos +")->"+rs.getString("status"));

					if( rs.getString("status").equals("OK") )
						aciertos++;

				}
			}catch(SQLException sqle){

				System.out.println("Error al contactar la BD.");
				return;
			}

//			System.out.println(intentos+ " "+ aciertos);
			//si no es asi, entonces sumarle uno

			if( aciertos == 1 ){
				con.update("UPDATE Usuario SET solved = solved + 1  WHERE userID = '"+ userID +"' LIMIT 1 ;");

			}else{
				System.out.println("Ya tenias resuelto este problema. Ya haz enviado "+ intentos +" soluciones para este problema. Y "+aciertos+" han sido correctas.");
			}


			//agregar un nuevo acierto al problema
			con.update("UPDATE Problema SET aceptados = (aceptados + 1) WHERE probID = "+ probID +" LIMIT 1 ");
		}else{
			//salida erronea
			System.out.println(" - WRONG - ");			
			System.out.println("El programa termino en "+tiempoTotal+"ms. Pero no produjo la respuesta correcta.");

			//guardar el resultado
			con.update("UPDATE Ejecucion SET status = 'INCORRECTO', tiempo = "+ tiempoTotal +"  WHERE execID = "+ execID +" LIMIT 1 ;");

		}


		//fin, terminar la conexion con la base de datos
		terminarConexion();
		vaciarCarpeta( execID );
	}


	static void vaciarCarpeta(String execID){

		//vaciar el contenido de la carpeta
		for( String file :  new File("../work_zone/"+execID).list() ){
			new File( "../work_zone/"+execID+"/"+file ).delete();
		}


	}


	//terminar la conexion con la base de datos
	private static void terminarConexion(){
		//cerrar conexion con base
		try{
			con.cerrar();
		}catch(Exception e){
			System.out.println("Error al cerrar la conexion con la base de datos.");
			return;
		}
	}

}
