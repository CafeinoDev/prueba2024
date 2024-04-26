# Domain Model

## User

### Properties

- **id**: (Único) PK.
- **fullName**: Nombre completo.
- **documentId**: (Único) Documento de identidad.
- **email**: (Único) correo electrónico.
- **password**: Contraseña (hasheada).
- **balance**: Monto disponible.
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
  "fullName": "Andy Alvarado",
  "documentId": "99988877",
  "email": "andy@yopmail.com",
  "password": "********",
  "balance": 100,
  "createdAt": "2024-01-01T00:00:00-05:00",
  "updatedAt": "2024-01-01T00:00:00-05:00"
}
```