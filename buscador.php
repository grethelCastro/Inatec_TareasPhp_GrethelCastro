<?php 
$data = file_get_contents('data-1.json');  
$properties = json_decode($data, true);  
$ciudadSeleccionada = $_POST['ciudad'] ?? '';  
$tipoSeleccionado = $_POST['tipo'] ?? '';  
$precioRange = explode(',', $_POST['precio'] ?? '0,1000000');  
$precioMin = (float)str_replace('$', '', str_replace(',', '', $precioRange[0]));  
$precioMax = (float)str_replace('$', '', str_replace(',', '', $precioRange[1]));  
$resultados = array_filter($properties, function($property) use ($ciudadSeleccionada, $tipoSeleccionado, $precioMin, $precioMax) {  
    $precio = (float)str_replace('$', '', str_replace(',', '', $property['Precio']));  
    return ($ciudadSeleccionada == '' || $property['Ciudad'] == $ciudadSeleccionada) &&  
           ($tipoSeleccionado == '' || $property['Tipo'] == $tipoSeleccionado) &&  
           ($precio >= $precioMin && $precio <= $precioMax);  
});  
?>  

<!DOCTYPE html>  
<html>  
<head>  
    <meta charset="utf-8">  
    <link rel="stylesheet" href="css/materialize.min.css">  
    <title>Resultados de Búsqueda</title>  
</head>  
<body>  
    <div class="container">  
        <h1>Resultados de la Búsqueda</h1>  
        <div class="row">  
            <div class="col s12">  
                <h5>Total de Resultados: <?= htmlspecialchars(count($resultados)) ?></h5>  
                <ul class="collection">  
                    <?php if (count($resultados) > 0): ?>  
                        <?php foreach ($resultados as $property): ?>  
                            <li class="collection-item">  
                                <span class="title"><?= htmlspecialchars($property['Id']) . ': ' . htmlspecialchars($property['Dirección'] ?? 'Sin dirección') ?></span>  
                                <p>Ciudad: <?= htmlspecialchars($property['Ciudad'] ?? 'Sin ciudad') ?> | Tipo: <?= htmlspecialchars($property['Tipo'] ?? 'Sin tipo') ?> | Precio: <?= htmlspecialchars($property['Precio'] ?? 'Sin precio') ?></p>  
                            </li>  
                        <?php endforeach; ?>  
                    <?php else: ?>  
                        <li class="collection-item">No se encontraron resultados.</li>  
                    <?php endif; ?>  
                </ul>  
            </div>  
        </div>  
    </div>  
    <script src="js/jquery-3.0.0.js"></script>  
    <script src="js/materialize.min.js"></script>  
</body>  
</html>