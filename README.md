<p align="center"><img src="logo.png" height="130"></p>

# 🌥️ AWS Cloud - OpenWeather
Ennek a projektnek az a célja, hogy a felhasználók időjárás adatokat tudjanak lekérni egy adott városról. Ezeket az adatokat el is tudják menteni egy listába, ahol kedvük szerint törölhetik is azt. Az egész projekt a **felhő alapú infrastruktúrát / szolgáltatást** használ. Jó ötletnek találtuk, hogy a stílus is picit NJE-s legyen :)

## 🧩 Előkészítés
Így tudod felépíteni az alkalmazást.

### 1. API
 - Létrehozni egy **virtuális** környezetet -> `python -m venv .venv`
 - Ezt a környezetet aktiváli kell (pl. PowerShell-be) -> `.\.venv\Scripts\activate`
 - Majd telepíteni a függőségeket -> `pip install -r requirements.txt`
 - Létrehozni egy `.env` fájlt és beírni a db adataid (a `.env.example` példaként ott van)
 - 🎉 Végül elindítani az alkalmazást -> `python app.py`

### 2. UI
 - Kell egy webszerver stack amivel a PHP-t tudod futtatni (pl. `XAMPP`)
 - Behúzod a `htdocs` mappába a UI fájlokat
 - Importálod a db-t (`db.sql`)
 - 🎉 Elindítod az alkalmazást

## 🧱 Felépítés
 - **Frontend (UI):** Webes felhasználói felület PHP-ben, NJE stílusban
 - **Backend (API):** Python (Flask) API, amely az időjárás adatokat biztosítja
 - **Felhő infrastruktúra:** Amazon Web Services
 - **Adatbázis:** RDS (Relációs Adatbázis Szolgáltatás)

## 💡 Tulajdonságok
 - 🐍 **Python** (Flask) + 🐘 **PHP** alapú
 - 🌐 **VPC** használata `->` A rendszer teljesen izolált hálózaton fut, biztonságos adatkezeléssel
 - 🗄️ **RDS** használata `->` Az időjárás adatokat és a felhasználói beállításokat az Amazon RDS-ben tároljuk
 - 🪣 **S3 Bucket** használata
 - 💻 **2 darab EC2** szolgáltatás használata `->` A backend és frontend különböző EC2 instanciákon futnak a nagyobb teljesítmény és biztonság érdekében
 - ⚖️ **Load Balancer** használata `->` A terhelés elosztásához az AWS Load Balancer biztosítja az optimális teljesítményt
 - 📈 **Auto Scaling Group** használata `->` Az alkalmazás képes automatikusan skálázódni a változó igényekhez

## 👤 Hogyan tudom megnézni az oldalt?
Az egész projekt elérhető és kipróbálható online a [OpenWeather x NJE](http://openweather-lb-ui-1261494571.eu-west-1.elb.amazonaws.com/) oldalon.
 
### ℹ️ 2025/2026 - Felhőalapú szolgáltatások
 - © 2025 Szabó Adrián Csaba `BZ8PAM` — Molnár Gergely `JMWZAL`