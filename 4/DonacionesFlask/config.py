# config.py

import os

class Config:
    MYSQL_HOST = 'localhost'
    MYSQL_USER = 'root'
    MYSQL_PASSWORD = ''
    MYSQL_DB = 'donacionesinf324'
    MYSQL_CURSORCLASS = 'DictCursor'  # Esto permite devolver los resultados como diccionarios
