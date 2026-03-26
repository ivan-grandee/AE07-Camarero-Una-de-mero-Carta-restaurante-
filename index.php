<?php
// Importación del XML
if (file_exists('./datos/carta.xml')) {
    $xml = simplexml_load_file('./datos/carta.xml');
} else {
    exit('Error abriendo el archivo de datos');
}

function getIcono(string $cat): string {
    $cat = strtolower($cat);
    if (str_contains($cat, 'gluten'))        return '<i class="fas fa-bread-slice"></i> ';
    if (str_contains($cat, 'lácteo'))        return '<i class="fas fa-cheese"></i> ';
    if (str_contains($cat, 'huevo'))         return '<i class="fas fa-egg"></i> ';
    if (str_contains($cat, 'frutos secos'))  return '<i class="fas fa-seedling"></i> ';
    if (str_contains($cat, 'soja'))          return '<i class="fas fa-leaf"></i> ';
    if (str_contains($cat, 'apio'))          return '<i class="fas fa-carrot"></i> ';
    if (str_contains($cat, 'mostaza'))       return '<i class="fas fa-pepper-hot"></i> ';
    if (str_contains($cat, 'sulfito'))       return '<i class="fas fa-wine-bottle"></i> ';
    if (str_contains($cat, 'vegano'))        return '<i class="fas fa-spa"></i> ';
    if (str_contains($cat, 'vegetariano'))   return '<i class="fas fa-apple-alt"></i> ';
    return '<i class="fas fa-circle"></i> ';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="icon" type="image" href="imagenes/logo.png">

    <title><?php echo htmlspecialchars((string)$xml->titulo); ?></title>
</head>
<body>

<!-- NAVBAR -->
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
                        echo '<a class="nav-link ' . (isset($_GET['tipo']) && $_GET['tipo'] === $tipo ? 'active' : '') . '" href="?tipo=' . $tipo . '">' . ucfirst($tipo) . '</a>';
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

<!-- CARTA -->
<div class="container carta-container">
    <div class="menu-grid">

        <?php
        foreach ($xml->plato as $plato) {
            if (!isset($_GET['tipo']) || $_GET['tipo'] === (string)$plato['tipo']) {

                $marcadores = [];
                foreach ($plato->marcadores->categoria as $cat) {
                    $marcadores[] = getIcono((string)$cat) . htmlspecialchars((string)$cat);
                }
        ?>

        <div class="menu-card">
            <div class="menu-img">
                <img src="<?php echo htmlspecialchars((string)$plato->foto); ?>" 
                     alt="<?php echo htmlspecialchars((string)$plato->nombre); ?>">
            </div>

            <div class="menu-body">
                <h2><?php echo htmlspecialchars((string)$plato->nombre); ?></h2>

                <p class="descripcion">
                    <?php echo htmlspecialchars((string)$plato->descripcion); ?>
                </p>

                <div class="menu-extra">
                    <span class="precio">
                        <?php echo htmlspecialchars((string)$plato->precio); ?>
                    </span>
                    <span class="calorias">
                        <?php echo htmlspecialchars((string)$plato->calorias); ?>
                    </span>
                </div>

                <div class="alergenos">
                    <?php echo implode('<br>', $marcadores); ?>
                </div>
            </div>
        </div>

        <?php
            }
        }
        ?>

    </div>
</div>

<!-- FOOTER -->
<footer class="text-center py-4">
    <p>&copy; <?php echo date('Y'); ?> Smoke House Saloon - Drink at your own risk</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>