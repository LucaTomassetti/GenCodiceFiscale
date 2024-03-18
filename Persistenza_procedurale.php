<?php
//Questo script è stato la base per la creazione dei metodi leggiFile() e getCodiceCatastale() della classe Persistenza
$lista = array_map('str_getcsv', file('Codici-statistici-e-denominazioni-al-22_01_2024.csv'));
//Estraggo l'elemento alla testa del file, cioè i campi intestazione
$header = array_shift($lista);
//La funzione _combina_array crea un array $row che ha come
//chiave i campi dell'intestazione $header
//e come valori sempre i dati della riga 
//Con array_walk() applico la funzione ad ogni elemento di $utenti
array_walk($lista, '_combina_array', $header);
function _combina_array(&$row, $key, $header) {
  $row = array_combine($header, $row);
}
print_r($lista[5350]);//corrisponde ad Avezzano
?>