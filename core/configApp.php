<?php
//Constantes para configuracion Base de Datos
const SERVER  ="localhost";
const DB      ="bd_sce";
const USER    ="root";
const PASS    ="";
const SGDB    ="mysql:host=".SERVER.";dbname=".DB;

//Constantes para configuracion para encrypt

const METHOD ="AES-256-CBC";
const SECRET_KEY ='#SCE@2020';
const SECRET_IV ='920128';

//Define la zona horaria
date_default_timezone_set('America/Bogota');
