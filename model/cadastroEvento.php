<?php
require_once("evento.php");

class Cadastro extends Evento {

    private $evento;
    private $camera_id;
    private $it2m;
    private $data_abertura;
    private $data_fechamento;
    private $responsavel;
    private $descricao;

    // Métodos Set
    public function setEvento($string){
        $this->evento = $string;
    }

    public function setCameraId($int){
        $this->camera_id = $int;
    }

    public function setIt2m($int){
        $this->it2m = $int;
    }

    public function setDataAbertura($date){
        if ($date instanceof DateTime) {
            $this->data_abertura = $date->format('Y-m-d'); // Formato: YYYY-MM-DD
        } else {
            $this->data_abertura = $date;
        }
    }

    public function setDataFechamento($date){
        if ($date instanceof DateTime) {
            $this->data_fechamento = $date->format('Y-m-d'); // Formato: YYYY-MM-DD
        } else {
            $this->data_fechamento = $date;
        }
    }

    public function setResponsavel($string){
        $this->responsavel = $string;
    }

    public function setDescricao($string){
        $this->descricao = $string;
    }

    public function getEvento(){
        return $this->evento;
    }

    public function getCameraId(){
        return $this->camera_id;
    }

    public function getIt2m(){
        return $this->it2m;
    }

    public function getDataAbertura(){
        return $this->data_abertura;
    }

    public function getDataFechamento(){
        return $this->data_fechamento;
    }

    public function getResponsavel(){
        return $this->responsavel;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function incluir(){
        return $this->setEventoBD(
            $this->getEvento(),
            $this->getCameraId(),
            $this->getIt2m(),
            $this->getDataAbertura(),
            $this->getDataFechamento(),
            $this->getResponsavel(),
            $this->getDescricao(),
        );
    }
}
?>

