<?php
/**
 * Clase para automatizar la valoración de riesgos según la actividad 3.3
 */
class ValoradorRiesgo {
    
    // Escalas definidas
    private const ESCALA = [
        'Baja' => 1, 'Media' => 2, 'Alta' => 3,
        'Bajo' => 1, 'Medio' => 2, 'Alto' => 3
    ];

    /**
     * Calcula el nivel de riesgo y su interpretación
     */
    public static function calcular(int $probabilidad, int $impacto): array {
        $nivel = $probabilidad * $impacto;
        
        $interpretacion = 'Desconocido';
        if ($nivel >= 1 && $nivel <= 2) {
            $interpretacion = 'Bajo';
        } elseif ($nivel >= 3 && $nivel <= 4) {
            $interpretacion = 'Medio';
        } elseif ($nivel >= 6 && $nivel <= 9) {
            $interpretacion = 'Alto';
        }
        
        return [
            'nivel' => $nivel,
            'interpretacion' => $interpretacion
        ];
    }
}

// Ejemplo de uso:
// $resultado = ValoradorRiesgo::calcular(3, 2); 
// echo "Nivel: " . $resultado['nivel'] . " - Interpretación: " . $resultado['interpretacion'];
?>