<?php
class Persona{
    private string $nome;
    private string $cognome;
    private string $sesso;
    private Data $data_nascita;
    private Comune $comune;

    public function __construct(string $nome, string $cognome, string $sesso, Data $data, Comune $comune) {
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->sesso = $sesso;
        $this->data_nascita = $data;
        $this->comune = $comune;
    }
    //getter
    public function getNome(): string{
        return $this->nome;
    }
    public function getCognome(): string{
        return $this->cognome;
    }
    public function getSesso(): string{
        return $this->sesso;
    }
    public function getData(): Data{
        return $this->data_nascita;
    }
    public function getComune(): Comune{
        return $this->comune;
    }
    //setter
    public function setNome(string $nome) {
        $this->nome = $nome;
    }
    public function setCognome(string $cognome) {
        $this->cognome = $cognome;
    }
    public function setSesso(string $sesso) {
        $this->sesso = $sesso;
    }
    public function setData(Data $datanascita) {
        $this->data_nascita = $datanascita;
    }
    public function setComune(Comune $comune) {
        $this->comune = $comune;
    }
    public function __toString():string{
        return "Nome: ". $this->nome."\n".
               "Cognome : ". $this->cognome."\n".
               "Sesso : ". $this->sesso."\n".
               "Data di nascita : ". $this->data_nascita."\n".
               "Comune : ". $this->comune."\n";
    }
}
?>