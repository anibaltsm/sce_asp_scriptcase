# Acceso a ScriptCase desde tu máquina local (misma red)

**Tu máquina:** 10.0.119.139  
**Servidor:** donde haces SSH (Linux), con ScriptCase en puerto **8091**  
**Objetivo:** abrir en el navegador de tu PC `http://...:8091/scriptcase/` (o equivalente).

---

## Estado actual (revisado en servidor)

| Comprobación        | Resultado |
|---------------------|-----------|
| Puerto 8091         | Escucha en **todas las interfaces** (`*:8091`) → acepta conexiones desde la red. |
| IP del servidor     | **192.168.2.138** |
| Firewall (ufw/nft)  | No se detectaron reglas activas que bloqueen; si falla, revisar con el administrador. |

**Nota:** Tu PC está en `10.0.119.139` y el servidor en `192.168.2.138` (distinto segmento). Si no hay ruta o hay un firewall entre redes, puede que no llegues. Prueba primero desde tu navegador:

- **http://192.168.2.138:8091/scriptcase/**

### Segunda revisión (servicio y red)

| Prueba | Resultado |
|--------|-----------|
| `curl http://127.0.0.1:8091/scriptcase/` desde el servidor | **200 OK** (Apache responde). |
| `curl http://192.168.2.138:8091/scriptcase/` desde el servidor | **200 OK**. |
| Ruta del servidor hacia 10.0.119.139 | Existe: via 192.168.2.254. |
| Conclusión | El servicio está bien; el bloqueo está **entre tu PC y el servidor** (firewall de red, segmento distinto, o política que no permite 8091). |

---

## Solución práctica: túnel SSH (acceso aunque la red bloquee el 8091)

Mientras tanto puedes usar ScriptCase **a través del túnel** desde tu PC:

1. Con la sesión SSH abierta al servidor, ejecuta en **tu PC** (en otra terminal o en segundo plano):

   ```bash
   ssh -L 8091:127.0.0.1:8091 usuario@192.168.2.138
   ```

   (Sustituye `usuario` por tu usuario SSH.) Si ya tienes SSH por nombre de host:

   ```bash
   ssh -L 8091:127.0.0.1:8091 usuario@posgrados.inecol.mx
   ```

2. Deja esa sesión abierta y en tu navegador entra a:

   **http://localhost:8091/scriptcase/**

El tráfico va por SSH hasta el servidor y allí se conecta al 8091 local; no hace falta que el puerto 8091 sea accesible desde tu red.

---

## Comprobar desde tu PC (10.0.119.139) dónde se corta

En una terminal **en tu máquina local** (PowerShell, CMD o bash):

```bash
# ¿Llega algo al servidor?
ping -n 3 192.168.2.138

# ¿Se puede abrir el puerto 8091? (en Linux/Mac)
nc -zv 192.168.2.138 8091
# En Windows PowerShell:
Test-NetConnection -ComputerName 192.168.2.138 -Port 8091
```

- Si **ping** falla: no hay ruta o hay firewall bloqueando todo hacia 192.168.2.138.
- Si **ping** responde pero **puerto 8091** no abre: un firewall (servidor o de red) está dejando ICMP pero bloqueando TCP 8091.
- En cualquiera de los dos casos, el **túnel SSH** anterior te permite usar ScriptCase sin depender de que el 8091 esté abierto en la red.

---

## 1. Qué debe cumplirse

Para poder entrar desde 10.0.119.139 hace falta:

| Requisito | Descripción |
|-----------|-------------|
| **Servicio escuchando en todas las interfaces** | Que el proceso que atiende el puerto 8091 escuche en `0.0.0.0:8091` (y no solo en `127.0.0.1:8091`). |
| **Firewall** | Que el firewall del servidor permita tráfico entrante al puerto **8091**. |
| **Misma red / conectividad** | Que tu PC (10.0.119.139) pueda alcanzar la IP del servidor (misma red o rutas correctas). |

---

## 2. Comandos para revisar (ejecutar por SSH en el servidor)

### Ver qué está escuchando en el puerto 8091

```bash
# Opción 1: ss
ss -tlnp | grep 8091

# Opción 2: netstat (si está instalado)
netstat -tlnp | grep 8091
```

- Si ves **127.0.0.1:8091** → solo acepta conexiones desde el propio servidor (localhost). **No** podrás entrar desde 10.0.119.139.
- Si ves **0.0.0.0:8091** (o `*:8091`) → acepta conexiones desde cualquier interfaz. Entonces el siguiente paso es el firewall.

### Ver la IP del servidor en la red

```bash
ip addr show | grep -E "inet " | grep -v 127.0.0.1
# o
hostname -I
```

Esa IP (por ejemplo 10.0.x.x) es la que debes usar en el navegador desde tu PC:  
`http://10.0.x.x:8091/scriptcase/`

### Firewall (ejemplos según lo que use el servidor)

```bash
# Si usan ufw
sudo ufw status
sudo ufw allow 8091/tcp
sudo ufw reload

# Si usan firewalld
sudo firewall-cmd --list-ports
sudo firewall-cmd --add-port=8091/tcp --permanent
sudo firewall-cmd --reload

# Si usan iptables (solo para ver)
sudo iptables -L -n | head -30
```

---

## 3. URLs a probar desde tu navegador (en la PC 10.0.119.139)

- **Por IP del servidor (recomendado para probar):**  
  `http://<IP_DEL_SERVIDOR>:8091/scriptcase/`  
  Ejemplo: `http://10.0.119.140:8091/scriptcase/` (cambia por la IP real del servidor).

- **Por nombre de dominio (si aplica):**  
  `https://posgrados.inecol.mx:8091/scriptcase/`  
  Solo funcionará si:
  1. `posgrados.inecol.mx` resuelve a la IP del mismo servidor donde corre el 8091.
  2. El puerto 8091 está abierto en el firewall.
  3. El servicio escucha en 0.0.0.0:8091.

**Importante:** En producción el sitio suele estar en **puerto 80/443** (por eso ves `http://posgrados.inecol.mx/sce_asp/...` sin `:8091`). El **8091** es típico del entorno de **desarrollo** de ScriptCase. Si en el servidor Linux solo está levantado el servicio de desarrollo en 8091, entonces la URL correcta desde tu PC sería `http://<IP>:8091/scriptcase/` (o con el nombre de dominio si apunta a ese servidor y el puerto está abierto).

---

## 4. Si el servicio solo escucha en 127.0.0.1

Entonces hay que cambiar la configuración del servidor que atiende el 8091 para que escuche en `0.0.0.0`. Depende de cómo esté levantado:

- **ScriptCase servidor integrado:** suele tener un archivo de configuración o parámetro de arranque donde se indica la interfaz (bind address).
- **Apache/Nginx como proxy o virtualhost en 8091:** en Apache sería algo como `Listen 0.0.0.0:8091`; en Nginx, que el `listen` no esté limitado a 127.0.0.1.

Quien administre el servidor puede revisar la configuración del servicio que usa el puerto 8091 y cambiar el bind a `0.0.0.0`.

---

## 5. Resumen

1. Ejecuta `ss -tlnp | grep 8091` y comprueba si escucha en `0.0.0.0` o en `127.0.0.1`.
2. Anota la IP del servidor con `hostname -I` o `ip addr`.
3. Abre el puerto 8091 en el firewall si hace falta.
4. Desde tu PC (10.0.119.139) prueba: `http://<IP_SERVIDOR>:8091/scriptcase/`.
5. Si quieres usar `https://posgrados.inecol.mx:8091/scriptcase/`, verifica que el dominio apunte a ese servidor y que 8091 esté permitido.

Si tras estos pasos sigue sin cargar, puede haber un proxy inverso o reglas de red adicionales; conviene revisar con el administrador del servidor.
