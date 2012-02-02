<?php 
	session_start();
	include_once("config.php");
	include_once("includes/db_con.php");	
?>
<html>
<head>
		<link rel="stylesheet" type="text/css" href="css/teddy_style.css" />
		<title>Teddy Online Judge - Preguntas Frecuentes</title>
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery-ui.custom.min.js"></script>
		<link type="text/css" rel="stylesheet" href="css/SyntaxHighlighter.css"></link>
		<script language="javascript" src="js/shCore.js"></script>
		<script language="javascript" src="js/shBrushCSharp.js"></script>
		<script language="javascript" src="js/shBrushJava.js"></script>
		<script language="javascript" src="js/shBrushCpp.js"></script>
		<script language="javascript" src="js/shBrushPython.js"></script>
		<script language="javascript" src="js/shBrushXml.js"></script>
<script>
window.onload = function () {

    dp.SyntaxHighlighter.ClipboardSwf = 'flash/clipboard.swf';
    dp.SyntaxHighlighter.HighlightAll('code');
}
</script>
</head>
<body>

<div class="wrapper">
	<?php include_once("includes/header.php"); ?>
	<?php include_once("includes/menu.php"); ?>
	<?php include_once("includes/session_mananger.php"); ?>	
	
	<div class="post">
<p>	
<b>&iquest; Que es Teddy  ?</b><br>
Teddy es un Juez en Linea para revisar problemas de programacion. Estas usando una version de Teddy para concursos locales. Ingresa en la opcion de concursos y selecciona un problema para ver su redaccion. Luego escribe la solucion utlizando alguno de los lenguajes de programacion que Teddy acepta. Deberas formular tu programa para que lea un archivo <i>data.in</i> con los casos de prueba, y este debera escribir un archivo llamado <i>data.out</i> con la solucion.
</p>


<p>
<b>&iquest; Que lenguajes puede revisar Teddy  ?</b><br>
Teddy puede evaluar codigo escrito en <i>Perl</i>, <i>Python</i>, <i>Java</i>, <i>C</i> y <i>C++</i>.<br><br>
</p>

<p>
<b>&iquest; Como reconoce Teddy los distinto lenguajes  ?</b><br>
Por la extension del codigo fuente, cuando subes un archivo que termina en .java, teddy tratara de compilarlo y ejecutarlo como codigo fuente de java. Pero si subes un archivo .cpp lo tratara como un codigo fuente de C++.<br><br>
</p>
<p>
<b>&iquest; Cuales son las extensiones que Teddy asociara a cada lenguaje  ?</b><br>

.java - Java <br>
.c - C <br>
.cpp - C++<br>
.py - Python<br>
.pl - Perl

</p>

<p>
<b>&iquest; Donde esta la entrada y salida ?</b><br>
Todos los casos de prueba para cada problema se encuentra en el archivo <b><code>data.in</code></b> en el directorio donde se ejecutara tu programa.
 Asi tambien, todo lo que tu programa escriba en el archivo llamado <b><code>data.out</code></b> sera tu respuesta final.<br><br>
</p>

<p>
<b>&iquest; Como se debe llamar mi clase en Java ?</b><br>
La clase debe llamarse <b><code>Main</code></b> de lo contrario obtendras un error.<br><br>
</p>

<p>
<b>&iquest; Como se debe llamar mi script de Python ?</b><br>
Tu script debe llamarse <b><code>Main.py</code></b> de lo contrario obtendras un error.<br><br>
</p>

<p>
<b>&iquest; Que compiladores e interpretes usa Teddy ?</b><br>
gcc version 4.3.2 (Debian 4.3.2-1.1)<br>
javac 1.6.0_12<br>
perl v5.10.0 built for i486-linux-gnu-thread-multi<br><br>
</p>


<p>
<b>&iquest; Con que parametros compila Teddy ?</b><br>
<b>Java </b> <code>javac Main.java</code><br>
<b>C </b> <code>gcc fileName -O2 -ansi -fno-asm -Wall -lm -static -DONLINE_JUDGE</code><br>
<b>C++ </b> <code>g++ fileName -O2 -ansi -fno-asm -Wall -lm -static -DONLINE_JUDGE</code><br><br>
</p>


<p>
<b>&iquest; Porque sigo obteniendo un RUN-TIME ERROR ?</b><br>
Tu programa debera regresar un 0 al termino de su ejecucion, de lo contrario obtendras un error de ejecucion.<br><br>
</p>



<p>
<b>Ejemplos</b><br>
He aqui programas de ejemplo para leer dos numeros y sumarlos.<br><br>
<b>Java :</b>
</p>
<textarea name="code" class="java" cols="60" rows="10">
import java.io.*;  
import java.util.Scanner;  
  
class Main {  
    public static void main(String[] args) throws IOException{  
  
    	Scanner sc=new Scanner(new FileReader("data.in")); 
        PrintWriter pw=new PrintWriter("data.out");

	while( sc.hasNextInt() )
        	pw.println( sc.nextInt()+sc.nextInt() );

        pw.close(); 
    }  
}
</textarea>

<br>
<b>C :</b>
<textarea name="code" class="c" cols="60" rows="10">
#include <stdio.h>

int main(void)
{
	FILE *in, *out;
	int a, b;

	in = fopen("data.in", "r");
	out = fopen("data.out", "w");

	while( fscanf(in, "%d %d", &a, &b) != EOF  ){
		fprintf(out, "%d\n", a + b);	
	}


	return (0);
}
</textarea>



<br>
<b>Python :</b>
<textarea name="code" class="py" cols="60" rows="10">
entra = open("data.in")
out   = open("data.out", 'w')

for each_line in entra:
	t = each_line.rsplit() 
	out.write( str( int(t[0]) + int(t[1]) )  +"\n")

entra.close()
out.close()
exit(0)
</textarea>

<br>
<b>Perl :</b>
<textarea name="code" class="py" cols="60" rows="10">
#!/usr/bin/perl

open FILE, "data.in" or die $!;
open FILE_OUT, ">data.out" or die $!; 

while (<FILE>) { 
	@nums = split(/ /, $_);
	$suma =  @nums[0] + @nums[1];
        print FILE_OUT $suma ; 
        print FILE_OUT "\n" ;
}
close FILE_OUT;
close FILE;
</textarea>
	</div>




	<?php include_once("includes/footer.php"); ?>

</div>
<?php include("includes/ga.php"); ?>
</body>
</html>

