<?php
require_once("../../includes/db/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);

    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header("Location: team.php?msg=Employee+deleted+successfully");
            exit();
        } else {
            header("Location: team.php?error=Failed+to+delete");
            exit();
        }
    }
}
?>