# Instrucciones de Deploy en Red (Hackathon)

Para cumplir con el requerimiento **06 Deploy en red (IP accesible a todo el jurado)**, sigue estos pasos:

## 1. Descubrir tu IP Local
Necesitas saber cuál es la IP de tu computadora en la red Wi-Fi actual.
- Abre la terminal (CMD o PowerShell).
- Escribe `ipconfig` y presiona Enter.
- Busca el adaptador de tu red (ej. "Adaptador de LAN inalámbrica Wi-Fi") y anota la **Dirección IPv4** (por ejemplo: `192.168.1.50`).

## 2. Configurar Apache (XAMPP/Laragon)
Por defecto, XAMPP y otros servidores locales escuchan en todas las interfaces de red (`Listen 80`), lo cual es correcto.
- Abre tu panel de control de XAMPP.
- Asegúrate de que los módulos **Apache** y **MySQL** estén en verde (iniciados).
- Pon todos estos archivos (`index.php`, `config.php`, carpetas `admin` y `includes`, etc.) en la carpeta `C:\xampp\htdocs\hackaton`.

## 3. Configurar el Firewall de Windows
Para que los dispositivos del jurado puedan entrar a tu PC:
- Abre el menú Inicio y busca **"Firewall de Windows Defender con seguridad avanzada"**.
- Haz clic en **"Reglas de entrada"** a la izquierda.
- A la derecha, haz clic en **"Nueva regla..."**.
- Selecciona **Puerto** -> Siguiente.
- Elige **TCP** y puertos locales específicos: `80` -> Siguiente.
- **Permitir la conexión** -> Siguiente.
- Marca todas las casillas (Dominio, Privado, Público) -> Siguiente.
- Ponle un nombre como `Hackathon Servidor Web` y finaliza.

## 4. Prueba Final
- Pide a alguien del jurado (o usa tu celular) que se conecte a la **misma red Wi-Fi** que tu computadora.
- En el navegador del celular o de la PC del jurado, pídeles que ingresen a la IP que anotaste en el paso 1, seguida de la carpeta del proyecto.
- Ejemplo: `http://192.168.1.50/hackaton`

¡Y listo! Deberían ver la página funcionando perfectamente, conectada a tu base de datos MariaDB y corriendo sobre PHP.
