<?php
namespace TrabajoTarjeta;

use PHPUnit\Framework\TestCase;

class MedioTest extends TestCase
{

    /**
     * Comprueba que la tarjeta con media franquicia no puede cargar saldos invalidos.
     */
    public function testCargaSaldoInvalido()
    {
        $tiempo = new Tiempo;
        $medio = new Medio(0, $tiempo);
        $this->assertFalse($medio->recargar(15));
        $this->assertEquals($medio->obtenerSaldo(), 0);
    }

    /**
     * Comprueba que la tarjeta con media franquicia puede restar boletos, con la limitacion de tiempo
     */
    public function testRestarBoletos()
    {
        $tiempo = new TiempoFalso;
        $medio = new Medio(0, $tiempo);
        $this->assertTrue($medio->recargar(50));
        $this->assertEquals($medio->obtenerSaldo(), 50);
        $this->assertEquals($medio->restarSaldo("153"), true);
        $tiempo->avanzar(300);
        $this->assertEquals($medio->obtenerSaldo(), 33.75);
        $this->assertEquals($medio->restarSaldo("153"), true);
        $this->assertEquals($medio->obtenerSaldo(), 17.5);
        $tiempo->avanzar(300);
        $this->assertEquals($medio->restarSaldo("153"), true);
        $tiempo->avanzar(300);
        $this->assertEquals($medio->restarSaldo("153"), true);      
        $this->assertTrue($medio->recargar(2114.11));
        $this->assertEquals($medio->obtenerSaldo(), 2568.75);
        $this->assertEquals($medio->restarSaldo("153"), false);
        $this->assertEquals($medio->restarSaldo("153"), false);
        $this->assertEquals($medio->restarSaldo("153"), false);
        $this->assertEquals($medio->restarSaldo("153"), false);
        $tiempo->avanzar(300);
        for (($i = 0); $i < 155; ++$i) {
            $this->assertEquals($medio->restarSaldo("153"), true);
            $tiempo->avanzar(300);
        }
        $this->assertEquals($medio->restarSaldo("153"), true);
        $this->assertEquals($medio->restarSaldo("153"), false);
        $tiempo->avanzar(300);
        $this->assertEquals($medio->restarSaldo("153"), true);
        $this->assertEquals($medio->restarSaldo("153"), false);
    }

    /**
     * prueba la limitacion de tiempo de 5 minutos
     */
    public function testTiempoInvalido()
    {
        $tiempo = new TiempoFalso;
        $medio = new Medio(0, $tiempo);
        $this->assertTrue($medio->recargar(2114.11));
        $this->assertEquals($medio->restarSaldo("153"), true);
        $tiempo->avanzar(300);
        $this->assertEquals($medio->restarSaldo("153"), true);
        $tiempo->avanzar(50);
        $this->assertEquals($medio->restarSaldo("153"), false);
        $tiempo->avanzar(50);
        $this->assertEquals($medio->restarSaldo("153"), false);
        $tiempo->avanzar(50);
        $this->assertEquals($medio->restarSaldo("153"), false);
        $tiempo->avanzar(50);
        $this->assertEquals($medio->restarSaldo("153"), false);
        $tiempo->avanzar(50);
        $this->assertEquals($medio->restarSaldo("153"), false);
        $tiempo->avanzar(50);
        $this->assertEquals($medio->restarSaldo("153"), true);
        $tiempo->avanzar(265);
        $this->assertEquals($medio->restarSaldo("153"), false);
        $tiempo->avanzar(584);
        $this->assertEquals($medio->restarSaldo("153"), true);
        $this->assertEquals($medio->restarSaldo("153"), false);
    }

    /*
    Se testea si se puede pagar un trasbordo un dia feriado con 90 minutos de espera y cual el texto del boleto
     */
    public function testTrasbordoMedio()
    {
        $tiempo = new TiempoFalso(0);
        $tarjeta = new Medio(0, $tiempo);
        $tiempo->avanzar(28800);
        $tarjeta->recargar(100);
        $tarjeta->recargar(100);
        $colectivo1 = new Colectivo(122, "Semtur", 37);
        $colectivo2 = new Colectivo(134, "RosarioBus", 52);

        /*
        Pruebo pagar un trasbordo un dia feriado con 90 minutos de espera y el texto del boleto
         */
        $boleto = $colectivo1->pagarCon($tarjeta);
        $this->assertEquals(date('N', $tiempo->time()), '4');
        $this->assertEquals(date('G', $tiempo->time()), '8');
        $this->assertEquals(date('d-m', $tiempo->time()), "01-01");
        $this->assertEquals($boleto->obtenerFecha(), "01/01/1970 08:00:00");
        $this->assertEquals($tarjeta->obtenerSaldo(), 183.75);
        $tiempo->avanzar(4200);
        $boleto2 = $colectivo2->pagarCon($tarjeta);
        $this->assertEquals($boleto2->obtenerDescripcion(), "Saldo: 183.75");
        $this->assertEquals($tarjeta->obtenerSaldo(), 183.75);
    }
}
