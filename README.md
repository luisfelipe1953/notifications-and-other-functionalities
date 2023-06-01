### Aplicacion con distintas funcionalidades para demostrar conocimientos avanzados sobre el framework de Laravel

#### Configuracion para entorno local

Cambiar el nombre de .env.example a .env
En el archivo de variables de entorno (.env) ingresar credenciales de email
Puede optar por MailHog, Mailtrap entre otros...
Tambien podrá configurarlo a su gusto
Por defecto en este repositorio las variables de entorno vendran configuradas con Redis Cache

#### Instalacion
Ejecutar en consola
`composer install && npm install`
`php artisan key:generate`
`php artisan migrate --seed`

#### Inicializacion
`php artisan serve && npm run dev`
`php artisan queue:work`
`php artisan websockets:serve`


*si opta por utilizar redis asegurese de inicalizar su servidor de redis*

