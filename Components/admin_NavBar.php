<?php

if (isset($_SESSION['id'])) {
    $host = "localhost:3306";
    $user = "root";
    $password = "";
    $db_name = "scheduling_project";
    $conn;
    $stmt;
    try {
        $conn = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    $user_id = $_SESSION['id'];

    // Assuming $this->conn is your database connection
    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_fullname = $result['user_fullname'];
    $user_type = $result['user_type'];
}

?>
<nav class="navbar navbar-expand navbar-light" style="background-color: #592720;">
    <div class="container-fluid d-flex justify-content-end">
        <ul class="nav">
            <div class="date me-3">
                <div id="currentDate" style="color: white;"></div>
                <div id="currentTime" style="color: white;"></div>
            </div>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-person-fill-gear h3" style="color: #f0de89;"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end rounded-0">
                    <?php if (isset($user_fullname)): ?>
                    <li class="dropdown-item text-muted">
                        <strong>
                            <?php echo $user_fullname . "|" . $user_type; ?>
                        </strong>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <?php endif; ?>
                    <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>