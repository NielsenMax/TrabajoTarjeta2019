<?php

namespace TrabajoTarjeta;

trait Transbordo{
    protected $Ultimotrasbordo = 1;
    function puedeTrasbordo($linea, $ValorBoleto)
    {
        if ($this->UltimoColectivo == $linea || $this->UltimoValorPagado == 0.0 || $this->Ultimotrasbordo) {
            $this->Ultimotrasbordo = 0;
            return $ValorBoleto;
        }
        if ($this->dependeHora()) {
            if (($this->tiempo->time() - $this->UltimaHora) < 3600) {
                $this->Ultimotrasbordo = 1;
                return ($ValorBoleto * 0.0);
            }
        } else {
            if (($this->tiempo->time() - $this->UltimaHora) < 7200) {
                $this->Ultimotrasbordo = 1;
                return ($ValorBoleto * 0.0);
            }
        }
        $this->Ultimotrasbordo = 0;
        return $ValorBoleto;
 
    }

    protected function dependeHora()
    {
        if ($this->tiempo->esFeriado() || date('N', $this->tiempo->time()) == 7){
            return false;
        }
        if (date('N', $this->tiempo->time()) == 6){
            if (date('G', $this->tiempo->time()) > 6 && date('G', $this->tiempo->time()) < 14){
                return true;
            } else {
                return false;
            }
        } else {
            if (date('G', $this->tiempo->time()) > 6 && date('G', $this->tiempo->time()) < 22){
                return true;
            } else {
                return false;
            }
        }
    }
}

?>