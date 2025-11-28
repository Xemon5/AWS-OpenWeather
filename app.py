from flask import Flask, request, jsonify
import requests
import mysql.connector
from dotenv import load_dotenv
import os

# Betöltjük az .env-et
load_dotenv()

# Flask app létrehozás
app = Flask(__name__)

# Mjad kinyerjük az .env-ből
API_KEY = os.getenv("API_KEY")

# Alapvető MySQL adatok
DB_HOST = os.getenv("DB_HOST")
DB_USER = os.getenv("DB_USER")
DB_PASS = os.getenv("DB_PASS")
DB_NAME = os.getenv("DB_NAME")

# Hozzákapcsolódunk a db-hez
db = mysql.connector.connect(
    host=DB_HOST,
    user=DB_USER,
    password=DB_PASS,
    database=DB_NAME
)

# Lekérjük az aktuális időjárást
@app.get("/weather/<city>")
def get_weather(city):

    # API hívás
    url = f"http://api.openweathermap.org/data/2.5/weather?q={city}&appid={API_KEY}&units=metric&lang=hu"
    res = requests.get(url).json()

    # Ezeket az adatokat szedjük ki (van itt minden is :D)
    data = {
        "city": city,
        "temperature": res["main"]["temp"],
        "feels_like": res["main"]["feels_like"],
        "temp_min": res["main"]["temp_min"],
        "temp_max": res["main"]["temp_max"],
        "humidity": res["main"]["humidity"],
        "pressure": res["main"]["pressure"],
        "wind_speed": round(res["wind"]["speed"] * 3.6, 1),
        "description": res["weather"][0]["description"],
        "icon": res["weather"][0]["icon"]
    }
    return jsonify(data)

# 5 napos / 3 órás előrejelzés
@app.get("/weather/forecast/<city>")
def get_forecast(city):

    # Szintén API hívás
    url = f"http://api.openweathermap.org/data/2.5/forecast?q={city}&appid={API_KEY}&units=metric&lang=hu"
    res = requests.get(url).json()

    forecast_list = []

    # A "list" tömbben vannak a 3 órás bontású előrejelzési elemek
    for item in res["list"]:
        forecast_list.append({
            "time": item["dt_txt"],
            "temperature": item["main"]["temp"],
            "feels_like": item["main"]["feels_like"],
            "description": item["weather"][0]["description"],
            "icon": item["weather"][0]["icon"],
            "wind_speed": round(item["wind"]["speed"] * 3.6, 1),
            "humidity": item["main"]["humidity"]
        })

    return jsonify(forecast_list)

# Az időjárás adatok mentése a db-be
@app.post("/weather/save")
def save_weather():
    data = request.json
    cursor = db.cursor()

    # Itt szúrjuk be
    cursor.execute("""
        INSERT INTO weather_data 
        (city, temperature, feels_like, temp_min, temp_max, humidity, pressure, wind_speed, description, icon)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
    """, (
        data["city"],
        data["temperature"],
        data["feels_like"],
        data["temp_min"],
        data["temp_max"],
        data["humidity"],
        data["pressure"],
        data["wind_speed"],
        data["description"],
        data["icon"]
    ))

    db.commit()
    return jsonify({"status": "saved"})

# Itt lekérhetjük az összes mentett időjárást ha akarjuk
@app.get("/weather/all")
def get_all():
    cursor = db.cursor(dictionary=True)
    cursor.execute("SELECT * FROM weather_data")
    return jsonify(cursor.fetchall())

# Adott időjárási adat törlése
@app.delete("/weather/<int:id>")
def delete_weather(id):
    cursor = db.cursor()
    cursor.execute("DELETE FROM weather_data WHERE id=%s", (id,))
    db.commit()
    return jsonify({"status": "deleted"})

if __name__ == "__main__":
    # debug=False esetén nem ír ki hibákat
    app.run(debug=True, port=5000)