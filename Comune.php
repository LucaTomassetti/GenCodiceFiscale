<?php
class Comune{
    private string $nome_comune;
    private string $provincia;

    public function __construct(string $nome_comune, string $provincia) {
        $this->nome_comune = $nome_comune;
        $this->provincia = $provincia;
    }
    public function getNomeComune():string{
        return $this->nome_comune;
    }
    public function __toString():string{
        return $this->nome_comune." (".$this->provincia.")";
    }
}
?>