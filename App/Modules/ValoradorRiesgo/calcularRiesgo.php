<?php
/**
 * Clase para automatizar la valoración de riesgos según la actividad 3.3
 */
class RiesgoCalculador
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function calcularRiesgo($probabilidad, $impacto)
    {
        return $probabilidad * $impacto;
    }

    public function clasificarRiesgo($nivel)
    {
        if ($nivel >= 6) return 'ALTO';
        if ($nivel >= 3) return 'MEDIO';
        return 'BAJO';
    }
}
?>