teddy-online-judge
==================

Teddy es un evaluador de problemas de programacion. 



API
==================
```
c_concurso.php::canshow()
c_concurso.php::concursosActivos()
c_concurso.php::concursosFuturos()
c_concurso.php::concursosPasados()
c_concurso.php::info($request)
c_concurso.php::nuevo()
c_concurso.php::rank()

c_ejecucion.php::lista()
c_ejecucion.php::nuevo($request)

c_mensaje.php::lista()
c_mensaje.php::markasread()
c_mensaje.php::nuevo()
c_mensaje.php::nuevo()
c_mensaje.php::nuevo()

c_problema.php::lista($request = null)
c_problema.php::problemaAddView($request = null)
c_problema.php::problemaBestTimes($request = null)
c_problema.php::problema($request = null)

c_sesion.php::isLoggedIn($request = null)
c_sesion.php::login($request)
c_sesion.php::logout($request = null)
c_sesion.php::usuarioActual()

c_usuario.php::canCreateContest($request)
c_usuario.php::editar()
c_usuario.php::getByNickOrEmail($request)
c_usuario.php::nuevo($request)
c_usuario.php::rank($request = null)
c_usuario.php::runs($request)
c_usuario.php::solvedProblems($request)

gui.php::informacionDeConcuso($concurso)
gui.php::listaDeConcursos($concursos)
gui.php::listaDeRuns($runs)
```
