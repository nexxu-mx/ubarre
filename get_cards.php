<?php
    include './db.php';
    session_start();
    $idUser = $_SESSION['idUser'];
    $sql = "SELECT id, last_four_digits, payment_method, card_type FROM user_cards WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idUser);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo '<div class="c14">Aún no tienes tarjetas registradas.</div>';
    } else {
        while ($row = $result->fetch_assoc()) {
            $metodp = $row['payment_method'] === 'credit' ? 'Crédito' : 'Débito';
            
            echo '<div class="c13">
                    <div class="btnl use-card-btn delcar">
                        <div class="c7"></div>
                        <p class="c5"><span class="c6">•••• •••• ••••</span> ' . $row['last_four_digits'] . '</p>
                        <p class="c8">'. $metodp . '</p>
                        <div class="c9"><img src="http://img.mlstatic.com/org-img/MP3/API/logos/' . $row['payment_method'] . '.gif" ></div>
                    </div>
                    <div class="c11" onclick="eliminarCard(' . $row['id'] . ')"><ion-icon name="trash-outline" class="c12" aria-hidden="true"></ion-icon></div>
                    </div>';
        }
    }
?>