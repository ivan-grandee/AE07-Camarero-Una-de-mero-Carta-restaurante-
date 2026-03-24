
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Hoja de estilos -->
    <link rel="stylesheet" href="./css/style.css">
    <title><?php echo htmlspecialchars((string)$xml->titulo); ?></title>
</head>
<body>
<?php
// Importación del XML
if (file_exists('./datos/carta.xml')) {
    $xml = simplexml_load_file('./datos/carta.xml');
} else {
    exit('Error abriendo el archivo de datos');
}
?>
<!-- NAVBAR con categorías -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><?php echo htmlspecialchars((string)$xml->titulo); ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMenu">
            <ul class="navbar-nav ms-auto">
                <?php
                $aux = [];
                foreach ($xml->plato as $plato) {
                    $tipo = (string)$plato['tipo'];
                    if (!in_array($tipo, $aux)) {
                        echo '<li class="nav-item">';
                        if (isset($_GET['tipo']) && $_GET['tipo'] === $tipo) {
                            echo '<a class="nav-link active" href="?tipo=' . $tipo . '">' . ucfirst($tipo) . '</a>';
                        } else {
                            echo '<a class="nav-link" href="?tipo=' . $tipo . '">' . ucfirst($tipo) . '</a>';
                        }
                        echo '</li>';
                        array_push($aux, $tipo);
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<!-- HEADER -->
<header class="text-center my-5">
    <h1 class="western-title"><?php echo htmlspecialchars((string)$xml->titulo); ?></h1>
    <p class="subtitle">ESTABLECIDO EN EL VIEJO OESTE · 1885</p>
</header>

<!-- TABLA DE PLATOS -->
<div class="container">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Plato</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Calorías</th>
                <th>Alérgenos</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($xml->plato as $plato) {
                if (!isset($_GET['tipo']) || $_GET['tipo'] === (string)$plato['tipo']) {
                    $marcadores = [];
                    foreach ($plato->marcadores->categoria as $cat) {
                        $marcadores[] = htmlspecialchars((string)$cat);
                    }

                    echo '<tr>';
                    echo '<td>' . htmlspecialchars((string)$plato->nombre) . '</td>';
                    echo '<td>' . htmlspecialchars((string)$plato->descripcion) . '</td>';
                    echo '<td>' . htmlspecialchars((string)$plato->precio) . '</td>';
                    echo '<td>' . htmlspecialchars((string)$plato->calorias) . '</td>';
                    echo '<td>' . implode(', ', $marcadores) . '</td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>
</div>

<!-- FOOTER -->
<footer class="text-center py-4">
    <p>&copy; <?php echo date('Y'); ?> Smoke House Saloon - Drink at your own risk</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>