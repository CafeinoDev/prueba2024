# Domain Model

## Transaction

### Properties

- **id**: (Único) PK.
- **senderId**: PK de quien realiza la transacción.
- **receiverId**: PK de quien recibe la transacción.
- **amount**: Cantidad enviada.
- **status**: Estado de la transacción.
- **createdAt**: Creación de la entidad.
- **updatedAt**: Última actualización.

### Methods
- **create**: Crea una instancia.
- **updateBalance**: Actualiza el balance.
- **refreshUpdatedAt**: Actualiza el updatedAt
### JSON

```json
{
  "id": 1,
  "senderId": 1,
  "receiverId": 2,
  "amount": 100,
  "status": "PENDING",
  "createdAt": "2024-01-01T00:00:00-05:00",
  "updatedAt": "2024-01-01T00:00:00-05:00"
}
```