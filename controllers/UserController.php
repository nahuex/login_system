<?php
class UserController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register() {
        return registerUser($this->pdo);
    }

    public function viewProfile() {
        // Lógica para mostrar el perfil del usuario
        // Por ahora, solo un ejemplo simple
        if (isset($_SESSION['user_id'])) {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $_SESSION['user_id']);
            $stmt->execute();
            return $stmt->fetch();
        }
        return null;
    }
}
?>
