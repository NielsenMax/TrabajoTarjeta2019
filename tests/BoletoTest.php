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
        $tarjeta->recargar(50);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerValor(), 14.8);

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

        $this->assertEquals($boleto->obtenerSaldo(), 35.2);

        $this->assertEquals($boleto->obtenerAbonado(), 14.8);

        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 35.2");

        $this->assertEquals($boleto->obtenerTipo(), "TrabajoTarjeta\Tarjeta");

        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 20.4");
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 5.6");
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 5.6");
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Debe 2 plus");

        $tarjeta->recargar(30);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 6");

        $tarjeta->recargar(30);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 6.4");
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

        $this->assertEquals($boleto->obtenerSaldo(), 22.6);

        $this->assertEquals($boleto->obtenerAbonado(), 7.4);

        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 22.6");

        $this->assertEquals($boleto->obtenerTipo(), "TrabajoTarjeta\Medio");

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 15.2");
        $this->assertEquals($boleto->obtenerSaldo(), 15.2);

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 7.8");
        $this->assertEquals($boleto->obtenerSaldo(), 7.8);

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 0.4");
        $this->assertEquals($boleto->obtenerSaldo(), 0.4);

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 0.4");

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Debe 2 plus");

        $tarjeta->recargar(30);
        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 0.8");

        $tarjeta->recargar(30);
        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 8.6");
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

        $this->assertEquals($boleto->obtenerSaldo(), 22.6);

        $this->assertEquals($boleto->obtenerAbonado(), 7.4);

        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 22.6");

        $this->assertEquals($boleto->obtenerTipo(), "TrabajoTarjeta\MedioUniversitario");

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 15.2");
        $this->assertEquals($boleto->obtenerSaldo(), 15.2);

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 0.4");
        $this->assertEquals($boleto->obtenerSaldo(), 0.4);

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 0.4");

        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Debe 2 plus");

        $tarjeta->recargar(30);
        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 0.8");

        $tarjeta->recargar(30);
        $tiempo->avanzar(300);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 1.2");
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
        $tarjeta->recargar(20);
        $tiempo->avanzar(250);
        $colectivo->pagarCon($tarjeta);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerColectivo(), $colectivo);

        $this->assertEquals($boleto->obtenerLinea(), 133);

        $PruebaTiempo = date("d/m/Y H:i:s", 250);

        $this->assertEquals($boleto->obtenerFecha(), $PruebaTiempo);

        $this->assertEquals($boleto->obtenerTarjeta(), $tarjeta);

        $this->assertEquals($boleto->obtenerIdTarjeta(), 0);

        $this->assertEquals($boleto->obtenerSaldo(), 5.2);

        $this->assertEquals($boleto->obtenerAbonado(), 0.0);

        $this->assertEquals($boleto->obtenerDescripcion(), "Saldo: 5.2");

        $this->assertEquals($boleto->obtenerTipo(), "TrabajoTarjeta\Tarjeta");

        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerSaldo(), 5.2);
        $this->assertEquals($boleto->obtenerDescripcion(), "Debe 2 plus");

        $tarjeta->recargar(10);
        $boleto = $colectivo->pagarCon($tarjeta);
        $this->assertEquals($boleto->obtenerSaldo(), 0.4);
        $this->assertEquals($boleto->obtenerDescripcion(), "Debe 2 plus");
    }
}
