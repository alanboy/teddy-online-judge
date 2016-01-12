package mx.itc.teddy;

import java.sql.*;
import java.io.*;

public class Conexion {
	private String bd ;
	private String login;
	private String password;
	private String url;
	private Connection conexion = null;

	public Conexion(String server, String login, String password, String bd) throws Exception {
		this.url = "jdbc:mysql://"+server+"/"+bd;
		this.login = login;
		this.password = password;
		this.bd = bd;

		abrir();
	}

	private void abrir() throws Exception {
		if (conexion == null){
			// /usr/lib/jvm/java-6-openjdk/jre/lib/ext
			Class.forName("org.gjt.mm.mysql.Driver"); // cargamos el driver
			conexion = DriverManager.getConnection(url, login, password);
		} else {
			TeddyLog.logger.error("Ya existe una conexion activa a " + bd);
		}
	}

	public void cerrar() throws Exception{
		if(conexion != null){
			conexion.close();
			conexion = null;
		} else {
			TeddyLog.logger.error("No existe conexion que cerrar");
		}
	}

	public ResultSet query(String consulta) {
		try{
			Statement estado = conexion.createStatement();
			ResultSet rs = estado.executeQuery(consulta); 
			return rs;
		}catch(Exception e){
			TeddyLog.logger.error(e);
		}
		return null;
	}

	public int update(String consulta) {
		try{
			Statement estado = conexion.createStatement();
			int rs = estado.executeUpdate(consulta);
			return rs;
		}catch(com.mysql.jdbc.exceptions.MySQLIntegrityConstraintViolationException micve){
			TeddyLog.logger.error(micve);
		}catch(Exception e){
			TeddyLog.logger.error(e);
		}

		return -1;
	}
}

