<?php
namespace src;

class Config {
    const BASE_DIR = '/AppCasaDosPobresCaruaru/public';

    const DB_DRIVER = 'mysql';
    const DB_HOST = 'localhost';
    const DB_DATABASE = 'casadospobres';
    CONST DB_USER = 'root';
    const DB_PASS = '';

    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';

    //Secret Key JWT
    const SECRET_KEY_JWT = '781833df098bd3665f223e194e019963';
}
