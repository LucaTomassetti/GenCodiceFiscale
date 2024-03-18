<?php
class Persistenza {
  private $file;
  private $header;
  private $lista_dati;

  public function __construct($file) {
    $this->file = $file;
    $this->leggiFile();
  }

  private function leggiFile() {
    $this->lista_dati = array_map('str_getcsv', file($this->file));
    $this->header = array_shift($this->lista_dati);
    $this->aggiustaChiavi();
  }

  public function getHeader() {
    return $this->header;
  }

  public function getLista_dati(){
    return $this->lista_dati;
  }
  //Trasforma le chiavi numeriche nei campi dell'intestazione
  private function aggiustaChiavi() {
    foreach($this->lista_dati as $dato){
      if (isset($dato)) {
        $array[] = array_combine($this->header, $dato);
      } else {
        return null;
      }
    }
    $this->lista_dati = $array;
  }
  //Preleva il codice catastale dal file in base al comune passato come parametro
  public function getCodiceCatastale(string $comune){
    foreach($this->lista_dati as $elemento){
      if($comune == $elemento["Denominazione in italiano"]){
        return $elemento["Codice Catastale del comune"];
      }
    }
  }
}
?>