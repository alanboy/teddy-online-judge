
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
		layout = new PatternLayout("%-6r [%15.15t] %-5p %30.30c %x - %m%n");
		logger.setLevel(Level.INFO);

		try {
			appender = new FileAppender(layout,"/var/log/teddy/teddy.log", true);
			logger.addAppender(appender);

		}catch(IOException ioe){
			System.out.println("Imposible eescribir al archivo de log");
			// Default appender to log to console.

			// Esto causara AV
			logger = null;
		}
	};
}

