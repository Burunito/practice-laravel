# practice-laravel
Practica para trabajo en laravel

# Requerimiento 
- Obtener con formato los códigos postales desde una api

# Solucion
- Primero, al ver que la información contenida en el servicio de códigos postales era bastante, decidí por descargar el formato xml e importarlo con Laravel excel
https://docs.laravel-excel.com/3.1/getting-started/
- Al ver la información decidi dividir en entidades para evitar tener una sola tabla con toda la información y solo obtener la información relevante para esta práctica
- Cree los modelos de las entidades identificadas, y cree sus tablas y sus relaciones
- Desarrollé el algoritmo para la lectura del archivo, para la alta de todos los registros necesarios
- Una vez hecho esto, la consulta queda en un query con el ORM bastante sencillo, ya que todo lo tengo configurado en los modelos para obtener solo la información necesaria para la respuesta
