<?php
try {
    $conn = new PDO("sqlsrv:Server=DESKTOP-VPUKDUT\SQLEXPRESS,1433;Database=CFE-TRANSMISIONES", "sa", "1234");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
