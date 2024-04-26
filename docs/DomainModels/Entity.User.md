# Domain Model

## User

### Properties

- **id**: (Único) PK.
- **fullName**: Nombre completo.
- **document**: (Único) Documento de identidad.
- **email**: (Único) correo electrónico.
- **password**: Contraseña (hasheada).
- **walletId**: PK de la billetera.
- **userType**: Rol del usuario. REGULAR | MERCHANT.
- **createdAt**: Fecha de creación de la entidad.
- **updatedAt**: Fecha de última actualización.

### Methods
- **create**: Crea una instancia.
- **refreshUpdatedAt**: Actualiza el updatedAt
### JSON

```json
{
  "id": 1,
  "fullName": "Andy Alvarado",
  "document": "99988877",
  "email": "andy@yopmail.com",
  "password": "********",
  "walletId": 1,
  "userType": "MERCHANT",
  "createdAt": "2024-01-01T00:00:00-05:00",
  "updatedAt": "2024-01-01T00:00:00-05:00"
}
```