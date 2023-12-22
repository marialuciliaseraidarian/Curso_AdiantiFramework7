<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Util\TFullCalendar;

class Calendario extends TPage
{
    private $calendario;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->calendario = new TFullCalendar( date('Y-m-d'), 'month');
        //configura um horário para habilitar o calendário, usa-se para horários de trabalho
        $this->calendario->setTimeRange('06:00:00', '20:00:00');
       //cria um popover e diz qual propriedades mostrar nele
        $this->calendario->enablePopover('Médico: {medico}', '<b>Tipo:</b> {tipo} <br> <b>Cliente: </b> {cliente}');
        
       //simula objetos de dados, pode-se substituir isso trazendo de um BD.
        $obj1 = (object) ['cliente' => 'Maria',    'medico' => 'Peter', 'tipo' => 'Oftalmo' ];
        $obj2 = (object) ['cliente' => 'Pedro',    'medico' => 'John',  'tipo' => 'Gastro' ];
        $obj3 = (object) ['cliente' => 'João',     'medico' => 'Mary',  'tipo' => 'Ortopédico' ];
        $obj4 = (object) ['cliente' => 'Cristina', 'medico' => 'Elton', 'tipo' => 'Oftalmo' ];
        
        //insere eventos
        $this->calendario->addEvent( 1, 'Evento 1', '2023-12-01 12:00:00', '2023-12-01 14:00:00', null, '#C04747', $obj1);
        $this->calendario->addEvent( 2, 'Evento 2', '2023-12-01 16:00:00', '2023-12-01 18:00:00', null, '#668Bc6', $obj2);
        $this->calendario->addEvent( 3, 'Evento 3', '2023-12-04 12:00:00', '2023-12-04 14:00:00', null, '#FF0000', $obj3);
        $this->calendario->addEvent( 4, 'Evento 4', '2023-12-04 16:00:00', '2023-12-04 18:00:00', null, '#5AB34B', $obj4);

        //adiciona ação ao calendário        
        $this->calendario->setEventClickAction( new TAction([$this, 'onEventClick']));//ação ao clicar um evento.
        $this->calendario->setDayClickAction( new TAction([$this, 'onDayClick']));//ação para click em um dia vazio do calendario
        
        parent::add($this->calendario);
    }
    
    public static function onEventClick($param)
    {
        new TMessage('info', str_replace(',', ',<br>', json_encode($param)));
    }
    
    public static function onDayClick($param)
    {
        new TMessage('info', str_replace(',', ',<br>', json_encode($param)));
    }
}