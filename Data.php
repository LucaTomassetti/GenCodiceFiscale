<?php
class Data {
    private int $giorno;
    private int $mese;
    private int $anno;

    public function __construct(int $giorno, int $mese, int $anno) {
        $this->giorno = $giorno;
        $this->mese = $mese;
        $this->anno = $anno;
    }
    public function getGiorno():int{
        return $this->giorno;
    }
    public function getMese():int{
        return $this->mese;
    }
    public function getAnno():int{
        return $this->anno;
    }
    public function __toString():string{
        return $this->giorno.'-'.$this->mese.'-'.$this->anno;
    }
}
?>