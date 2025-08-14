<?php
// Configuración base de datos
$host = "127.0.0.1";
$dbname = "u379047759_studio";
$username = "u379047759_sencia";
$password = "Sencia25*";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta todos los usuarios con fechaCredit y venceCredit válidos
    $sql = "SELECT id, fechaCredit, venceCredit FROM users WHERE fechaCredit IS NOT NULL AND venceCredit IS NOT NULL";
    $stmt = $pdo->query($sql);
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $hoy = new DateTime();

    foreach ($usuarios as $usuario) {
        $id = $usuario['id'];
        $fechaCredit = new DateTime($usuario['fechaCredit']);
        $venceCredit = (int)$usuario['venceCredit'];

        // Verificamos si la fecha ya venció o es hoy
        if ($fechaCredit <= $hoy) {
            // Sumamos los días a fechaCredit
            $fechaCredit->modify("+$venceCredit days");
            $nuevaFecha = $fechaCredit->format('Y-m-d');

            // Actualizamos en la base de datos
            $update = $pdo->prepare("UPDATE users SET fechaCredit = :nuevaFecha WHERE id = :id");
            $update->execute([
                ':nuevaFecha' => $nuevaFecha,
                ':id' => $id
            ]);

            echo "Usuario ID $id actualizado a $nuevaFecha\n";
        }
    }

} catch (PDOException $e) {
    echo "Error de conexión o consulta: " . $e->getMessage();
}
