<?php

namespace TrabajoTarjeta;

trait Transbordo{
    
    function puedeTrasbordo($linea, $ValorBoleto)
    {
        if ($this->UltimoColectivo == $linea || $this->UltimoValorPagado == 0.0 || $this->Ultimotrasbordo) {
            $this->Ultimotrasbordo = 0;
            return $ValorBoleto;
        }
        if ($this->dependeHora()) {
            if (($this->tiempo->time() - $this->UltimaHora) < 3600) {
                $this->Ultimotrasbordo = 1;
                return ($ValorBoleto * 0.33);
            }
        } else {
            if (($this->tiempo->time() - $this->UltimaHora) < 5400) {
                $this->Ultimotrasbordo = 1;
                return ($ValorBoleto * 0.33);
            }
        }
        $this->Ultimotrasbordo = 0;
        return $ValorBoleto;
    }
}
?>