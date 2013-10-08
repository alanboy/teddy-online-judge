package mx.itc.teddy;
import java.sql.*;
import java.io.*;
/* -------------------------------------------------------------------------------------------- *
* Conexion a la base de datos
*
* -------------------------------------------------------------------------------------------- */
public class Conexion {

	static String bd ; 
	static String login;
	static String password;
	static String url; // = "jdbc:mysql://localhost/"+bd;

	Connection conexion = null;

	public Conexion() throws Exception {

		//leer el archivo config.php para sacar los datos de la base de datos

		BufferedReader br = new BufferedReader(new FileReader("../www/config.php"));
		String s, foo;
		while((s = br.readLine()) != null){

			if(s.indexOf("$TEDDY_DB_SERVER") != -1){
				foo = s.substring( s.indexOf('\"') + 1, s.lastIndexOf('\"') );
				//System.out.println( "server:"+foo );
				url = "jdbc:mysql://"+foo+"/"+bd;
			}

			if(s.indexOf("$TEDDY_DB_USER") != -1){
				foo = s.substring( s.indexOf('\"') + 1, s.lastIndexOf('\"') );
				//System.out.println( "user:"+foo );
				login = foo;
			}

			if(s.indexOf("$TEDDY_DB_PASS") != -1){
				foo = s.substring( s.indexOf('\"') + 1, s.lastIndexOf('\"') );
				//System.out.println( "pass:"+foo );
				password = foo;
			}

			if(s.indexOf("$TEDDY_DB_NAME") != -1){
				foo = s.substring( s.indexOf('\"') + 1, s.lastIndexOf('\"') );
				//System.out.println( "name:"+foo );
				bd = foo;
			}


		}

	
		abrir();

   	}

	

	public void abrir() throws Exception {

		if (conexion == null){
			// /usr/lib/jvm/java-6-openjdk/jre/lib/ext
			Class.forName("org.gjt.mm.mysql.Driver");//cargamos el driver
	       	 	conexion = DriverManager.getConnection(url,login,password);//nos conectamos con la BD
	       	 	// System.out.println("Conexion activa");
		} else {
        		System.out.println("Existe una conexion activa a" + bd);
		}

	}


	public void cerrar() throws Exception{

		if(conexion != null){

			conexion.close();

			conexion = null;

			//System.out.println("Se cerro la conexion satisfactoriamente.");

		} else {

			System.out.println("No existe conexion que cerrar");
		}

	}

	

	public ResultSet query(String consulta) {
		try{
			Statement estado = conexion.createStatement();
			ResultSet rs = estado.executeQuery(consulta); 
			return rs;
		}catch(Exception e){
			System.out.println(e);
		}
		return null;
	}

	

	public int update(String consulta) {
		try{
			Statement estado = conexion.createStatement();
			int rs = estado.executeUpdate(consulta); 
			return rs;
		}catch(com.mysql.jdbc.exceptions.MySQLIntegrityConstraintViolationException micve){

		}catch(Exception e){
			System.out.println(e);
		}

		return -1;
	}
}

