# Prueba técnica - Wallet
[(Puede encontrar una versión refactorizada aquí)](https://github.com/CafeinoDev/prueba2024/tree/refactor)
### Instalación
Luego de clonar el proyecto, ejecutar `docker-compose up` en la carpeta del proyecto, esto levantará automáticamente el servidor e importará la base de datos.

### RESTful API
Encontrará un archivo postman llamado `LG-Andy.postman_collection` en la raiz del proyecto.

En el postman se encuentra configurada la variable `{{Entorno Local}}` con la ruta `http://localhost/api/v1`

#### Endpoints
| Método |     Ruta     |            Descripción            |
|:------:|:------------:|:---------------------------------:|
|  GET   |    /users    |     Lista todos los usuarios      |
|  POST  |    /user     |       Registrar un usuario        |
|  GET   |  /user/{id}  | Obtiene información de un usuario |
|  POST  | /transaction |      Realiza una transacción      |

#### Payloads
`Nota: Los comentarios son solo para propósitos explicativos y no son parte del JSON real.`

Payload para `/user`

```json
{
  "full_name": "Andy Alvarado",
  "document": "00000000", // Debe ser único
  "email": "mail@yopmail.com", // Debe ser único
  "user_type": "MERCHANT", // REGULAR | MERCHANT
  "password": "12345678",
  "balance": 100
}
```

Payload para `/transaction`
```json
{
  "senderId": 2, // Usuario que realiza la transferencia, no debe ser comerciante
  "receiverId": 1, // Usuario que recibe la transferencia
  "amount": 1 // El monto a pagar, la cantidad mínima permitida es 1
}
```

