Teddy Online Judge
==================
Teddy Online Judge es el resultado de una iniciativa denominada Club de Programación del Tecnológico de Celaya. Este club tuvo como finalidad alentar a los estudiantes del Tecnológico a participar en concursos de programación llevados a cabo en la región. Y el de consolidar un nivel de programación mayor al que se tenía.

Instalacion
==================
```
  $git clone https://github.com/alanboy/teddy-online-judge.git
  $cd teddy-online-judge\
  $git submoudle init
  $git submoudle update

  $cd deploy
  #docker-compose build
  #docker-compose up
```

Despues de eso Teddy estara corriendo en http://127.0.0.1:8080/
Logs(desde el host):
 `/var/log/teddy/teddy.log`
 `/var/log/ngninx/error.log`



API
==================
```
 c_backup::BackupDatabase()

 c_concurso::canshow()
 c_concurso::concursosActivos()
 c_concurso::concursosFuturos()
 c_concurso::concursosPasados()
 c_concurso::info()
 c_concurso::nuevo()
 c_concurso::rank()

 c_ejecucion::canUserViewRun()
 c_ejecucion::details()
 c_ejecucion::lista()
 c_ejecucion::nuevo()
 c_ejecucion::status()

 c_escuela::lista()

 c_mensaje::Lista()
 c_mensaje::MarcarComoLeido()
 c_mensaje::Nuevo()

 c_problema::Nuevo()
 c_problema::lista()
 c_problema::mejoresTiempos()
 c_problema::problema()
 c_problema::problemaAddView()

 c_sesion::isAdmin()
 c_sesion::isLoggedIn()
 c_sesion::login()
 c_sesion::logout()
 c_sesion::usuarioActual()

 c_usuario::IsResetPassTokenValid()
 c_usuario::RequestResetPass()
 c_usuario::ResetPassword()
 c_usuario::ResetPasswordWithToken()
 c_usuario::canCreateContest()
 c_usuario::editar()
 c_usuario::getByEmail()
 c_usuario::getByNick()
 c_usuario::nuevo()
 c_usuario::problemasIntentados()
 c_usuario::problemasResueltos()
 c_usuario::rank()
 c_usuario::runs()
```
