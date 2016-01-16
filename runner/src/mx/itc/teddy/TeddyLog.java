
package mx.itc.teddy;

import org.apache.log4j.*;
import java.io.IOException;

public class TeddyLog {

	public static Logger logger;
	static PatternLayout layout;
	static FileAppender appender;

	private TeddyLog (){
	}

	static {
		logger = Logger.getLogger(TeddyLog.class);
		layout = new PatternLayout("%d{E, d M y HH:mm:ss Z} | [runner] | %-5p %30.30c %x - %m%n");
		logger.setLevel(Level.INFO);

		try {
			appender = new FileAppender(layout,"/var/log/teddy/teddy.log", true);
			logger.addAppender(appender);

		}catch(IOException ioe){
			System.out.println("Imposible eescribir al archivo de log");
			logger = null;
		}
	};
}

