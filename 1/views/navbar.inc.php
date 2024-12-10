<div class="sidebar">
    <h3 class="text-white text-center mb-4">Menú</h3>
    <!-- Se define el menú dinámicamente según el rol del usuario -->
    <?php if (isset($_SESSION['rol'])): ?>
        <?php
        // Obtener el rol del usuario desde la sesión
        $rol = $_SESSION['rol']; 

        // Definir las pantallas disponibles según el rol
        $pantallas = [
                'Objetivo',
                'KPI',
                'Control',
                'ControlDecision',
                'ControlAccion',
                'Riesgo',
                'RiesgoDecision',
                'RiesgoAccion',
                'Norma',
                'NormaDesicion',
                'NormaAccion',
                'Eficiencia',
                'EficienciaDecision',
                'EficienciaAccion',
                'Desempeño',
                'DesempeñoDesicion',
                'DesempeñoAccion',
                'Informe',
                'InformeAccion',
                'Observaciones',
                'Cierre'
                
        ];

        ?>
        <a href="index.php" class="">Inicio</a>
        <?php foreach ($pantallas as $pantalla): ?>
            <a href="<?php echo urlencode($pantalla); ?>.inc.php"><?php echo $pantalla; ?></a>
        <?php endforeach; ?>
        <a href="logout.php">Cerrar sesión</a>
    <?php else: ?>
        <p>Por favor, inicie sesión para ver el menú.</p>
    <?php endif; ?>
</div>
