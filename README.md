# Prueba Laravel - Bryner Tineo

Crear un URL Shortener usando Laravel y la base de datos de su preferencia. Esta
aplicación de Laravel será un simple API con el que se puede interactuar via CURL, POSTMAN o en
general http requests.

## Getting Started

Para empezar primero deben de tener instalado laravel en su maquina.

### Prerequisites

Como prerequisitos que tiene laravel son los siguientes.

```
PHP >= 7.1.3
BCMath PHP Extension
Ctype PHP Extension
JSON PHP Extension
Mbstring PHP Extension
OpenSSL PHP Extension
PDO PHP Extension
Tokenizer PHP Extension
XML PHP Extension
```

### Installing

Instalar composer y laravel.

```
composer global require laravel/installer
```

Crear un folder he importar el repositorio y las tabla de la base de datos que estan en migrations.

```
php artisan migrate
```

## Running the tests

Correr el proyecto.

```
php artisan serve
```

Probar el proyecto con POSTMAN enviando la variable "url" al metodo POST http://127.0.0.1:8000/api/ o cual sea el nombre del dominio. Este le respondera con un JSON con el resultado

```
{
	"error":"",
	"error_code":"000",
	"url":"http://127.0.0.1:8000/c48bbf"
}
```

en caso de dar un error:

```
{
	"error":"URL is required",
	"error_code":"001"
}
```
o
```
{
	"error":"URL is not in a valid format.",
	"error_code":"002"
}
```

Para redireccionar a la url insertada simplemente colocan la url devuelta por el metodo anterior en un GET en el navegador http://127.0.0.1:8000/####### y la misma los enviara a la url larga insertado por el usuario.

Para ver el top 100 visitadas simplemente las consulta en la url http://127.0.0.1:8000/url/top100
