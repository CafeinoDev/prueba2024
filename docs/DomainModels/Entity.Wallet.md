# Domain Model

## Wallet

### Properties

- **id**: (Único) PK.
- **balance**: Saldo disponible en la billetera.
- **createdAt**: Fecha de creación de la entidad.
- **updatedAt**: Fecha de última actualización.

### Methods
- **create**: Crea una instancia.
- **addFunds**: Añade fondos.
- **deductFunds**: Deduce fondos.
- **refreshUpdatedAt**: Actualiza el updatedAt
### JSON

```json
{
  "id": 1,
  "balance": 100,
  "createdAt": "2024-01-01T00:00:00-05:00",
  "updatedAt": "2024-01-01T00:00:00-05:00"
}
```