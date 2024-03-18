<?php
require_once "Persona.php";
require_once "Data.php";
require_once "Comune.php";
require_once "Persistenza.php";
require_once "CodiceFiscale.php";
// ------Dati input di esempio------
$data_nasc = new Data(3,8,1990);
$com = new Comune("Milano","MI");
$p = new Persona("Giuseppe Esposito","Verdi Giulia","M", $data_nasc, $com);
// ---------------------------------
//Stampa dell'anagrafica della persona
echo $p;
//Prelevo il codice catastale
$lista_codici = new Persistenza('Codici-statistici-e-denominazioni-al-22_01_2024.csv');
$cod_catastale = $lista_codici->getCodiceCatastale($com->getNomeComune());
print("Codice catastale di ".$com->getNomeComune()." : ".$cod_catastale);
//Calcolo del codice fiscale
$codice = new CodiceFiscale();
$codice_str = $codice->genFromCognome($p->getCognome()) . 
        $codice->genFromNome($p->getNome()) . 
        $codice->genFromDataNascita($data_nasc->getGiorno(),$data_nasc->getMese(),$data_nasc->getAnno(),$p->getSesso()) . 
          $cod_catastale;

$codice_str .= $codice->_calcolaCifraControllo($codice_str);
print("\nCodice fiscale: ".$codice_str);
?>