# Hola mundo con PHP, MySQL y Docker Compose

Aplicación web de práctica que levanta dos servicios:

- `app`: PHP 8.3 con Apache, expuesto en `http://localhost:8080`.
- `db`: MySQL 8.0 con una tabla inicial llamada `visitas`.

## Ejecutar

Requiere Docker Desktop:

```powershell
docker compose up --build
```

Luego abrir [http://localhost:8080](http://localhost:8080). La página confirma la conexión y muestra los registros consultados desde MySQL.

Para detener los servicios:

```powershell
docker compose down
```

Para eliminar también los datos persistidos:

```powershell
docker compose down -v
```
