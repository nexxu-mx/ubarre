<?php
function reemplazarFavicon($dir) {
    $archivos = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($dir),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($archivos as $archivo) {
        // Solo archivos normales
        if ($archivo->isFile()) {
            $ruta = $archivo->getPathname();
            // Solo archivos con extensión .html, .php o similares
            if (preg_match('/\.(php|html|htm)$/', $ruta)) {
                $contenido = file_get_contents($ruta);
                $nuevoContenido = str_replace('https://wa.me/524792179429?text=Hola,%20Quiero%20más%20información%20de%20SENCIA.', 'https://wa.me/524792179429?text=Hola,%20Quiero%20más%20información%20de%20SENCIA.', $contenido);

                if ($contenido !== $nuevoContenido) {
                    file_put_contents($ruta, $nuevoContenido);
                    echo "Modificado: $ruta\n";
                }
            }
        }
    }
}

// Llama a la función con la ruta base del proyecto
$directorioProyecto = "./"; // o cambia esto por la ruta que quieras
reemplazarFavicon($directorioProyecto);
