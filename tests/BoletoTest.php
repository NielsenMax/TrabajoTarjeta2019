<?php

namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class BoletoTest extends TestCase
{

    /**
     * Comprueba que sucede cuando creamos un boleto nuevo.
     */
    public function testSaldoCero()
    {

        $tiempo = new Tiempo();
        $tarjeta = new Tarjeta(0, $tiempo);
        $colectivo = new Colectivo(133, "RosarioBus", 69);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerValor(), null);
        $tarjeta->recargar(100);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerValor(),32.5);

    }

    /**
     * Comprueba retorno de datos Tarjeta Normal
     */
    public function testDatosBoletoTarjeta()
    {
        $colectivo = new Colectivo(133, "RosarioBus", 69);
        $tiempo = new TiempoFalso();
        $tarjeta = new Tarjeta(0, $tiempo);
        $tarjeta->recargar(50);
        $tiempo->avanzar(250);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerColectivo(), $colectivo);

        $this->assertEquals($boleto->obtenerLinea(), 133);

        $PruebaTiempo = date("d/m/Y H:i:s", 250);

        $this->assertEquals($boleto->obtenerFecha(), $PruebaTiempo);

        $this->assertEquals($boleto->obtenerTarjeta(), $tarjeta);

        $this->assertEquals($boleto->obtenerIdTarjeta(), 0);

        $this->assertEquals($boleto->obtenerSaldo(), 17.5);

        $this->assertEquals($boleto->obtenerAbonado(), 32.5);

        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 17.5");

        $this->assertEquals($boleto->obtenerTipo(), "TrabajoTarjeta\Tarjeta");

        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 17.5");      
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Debe 2 plus");
        $tarjeta->recargar(50);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 2.5");

    }

    /**
     * Comprueba retorno de datos Medio
     */
    public function testDatosBoletoMedio()
    {
        $colectivo = new Colectivo(133, "RosarioBus", 69);
        $tiempo = new TiempoFalso();
        $tarjeta = new Medio(0, $tiempo);
        $tarjeta->recargar(30);
        $tiempo->avanzar(250);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerColectivo(), $colectivo);

        $this->assertEquals($boleto->obtenerLinea(), 133);

        $PruebaTiempo = date("d/m/Y H:i:s", 250);

        $this->assertEquals($boleto->obtenerFecha(), $PruebaTiempo);

        $this->assertEquals($boleto->obtenerTarjeta(), $tarjeta);

        $this->assertEquals($boleto->obtenerIdTarjeta(), 0);

        $this->assertEquals($boleto->obtenerSaldo(), 13.75);

        $this->assertEquals($boleto->obtenerAbonado(), 16.25);

        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 13.75");

        $this->assertEquals($boleto->obtenerTipo(), "TrabajoTarjeta\Medio");

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 13.75");
        $this->assertEquals($boleto->obtenerSaldo(), 13.75);        

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Debe 2 plus");

        $tarjeta->recargar(50);
        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 15");

        $tarjeta->recargar(30);
        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 12.5");
    }
    /**
     * Comprueba retorno de datos Medio Universitario
     */
    public function testDatosBoletoMedioUni()
    {
        $colectivo = new Colectivo(133, "RosarioBus", 69);
        $tiempo = new TiempoFalso();
        $tarjeta = new \TrabajoTarjeta\MedioUniversitario(0, $tiempo);
        $tarjeta->recargar(30);
        $tiempo->avanzar(250);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerColectivo(), $colectivo);

        $this->assertEquals($boleto->obtenerLinea(), 133);

        $PruebaTiempo = date("d/m/Y H:i:s", 250);

        $this->assertEquals($boleto->obtenerFecha(), $PruebaTiempo);

        $this->assertEquals($boleto->obtenerTarjeta(), $tarjeta);

        $this->assertEquals($boleto->obtenerIdTarjeta(), 0);

        $this->assertEquals($boleto->obtenerSaldo(), 13.75);

        $this->assertEquals($boleto->obtenerAbonado(), 16.25);

        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 13.75");

        $this->assertEquals($boleto->obtenerTipo(), "TrabajoTarjeta\MedioUniversitario");

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 13.75");
        $this->assertEquals($boleto->obtenerSaldo(), 13.75);        

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Debe 2 plus");

    }

    /**
     * Comprueba retorno de datos Completo
     */
    public function testDatosBoletoCompleto()
    {
        $colectivo = new Colectivo(133, "RosarioBus", 69);
        $tiempo = new TiempoFalso();
        $tarjeta = new \TrabajoTarjeta\Completo(0, $tiempo);

        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerColectivo(), $colectivo);

        $this->assertEquals($boleto->obtenerLinea(), 133);

        $PruebaTiempo = date("d/m/Y H:i:s", 0);

        $this->assertEquals($boleto->obtenerFecha(), $PruebaTiempo);

        $this->assertEquals($boleto->obtenerTarjeta(), $tarjeta);

        $this->assertEquals($boleto->obtenerIdTarjeta(), 0);

        $this->assertEquals($boleto->obtenerSaldo(), 0.0);

        $this->assertEquals($boleto->obtenerAbonado(), 0.0);

        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 0");

        $this->assertEquals($boleto->obtenerTipo(), "TrabajoTarjeta\Completo");

        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 0");
    }

    /**
     * Comprueba retorno de Descripcion De Boleto en Tarjeta al pagar plus
     */
    public function testDatosBoletoTarjetaPlus()
    {
        $colectivo = new Colectivo(133, "RosarioBus", 69);
        $tiempo = new TiempoFalso();
        $tarjeta = new Tarjeta(0, $tiempo);
        $tarjeta->recargar(50);
        $tiempo->avanzar(250);
        $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerColectivo(), $colectivo);

        $this->assertEquals($boleto->obtenerLinea(), 133);

        $PruebaTiempo = date("d/m/Y H:i:s", 250);

        $this->assertEquals($boleto->obtenerFecha(), $PruebaTiempo);

        $this->assertEquals($boleto->obtenerTarjeta(), $tarjeta);

        $this->assertEquals($boleto->obtenerIdTarjeta(), 0);

        $this->assertEquals($boleto->obtenerSaldo(), 17.5);

        $this->assertEquals($boleto->obtenerAbonado(), 0.0);

        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 17.5");

        $this->assertEquals($boleto->obtenerTipo(), "TrabajoTarjeta\Tarjeta");

        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerSaldo(), 17.5);
        $this->assertEquals($boleto->obtenerDescripcion(), "Debe 2 plus");

      
    }
}
