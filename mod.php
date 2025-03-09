<?php
// Configuration de la base de données
$servername = "localhost";
$username = "root"; // Changez si nécessaire
$password = ""; // Changez si nécessaire
$dbname = "reservations";

// Connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Créer une réservation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $sql = "INSERT INTO reservation (name, date, time) VALUES ('$name', '$date', '$time')";
    $conn->query($sql);
}

// Lire les réservations
$result = $conn->query("SELECT * FROM reservation");

// Mettre à jour une réservation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $sql = "UPDATE reservation SET name='$name', date='$date', time='$time' WHERE id=$id";
    $conn->query($sql);
}

// Supprimer une réservation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM reservation WHERE id=$id");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservations</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <h1>Réservations</h1>
    <form method="post" class="container">
        <div class="container">
            <input type="text" name="name" placeholder="Nom" required>
            <input type="date" name="date" required>
            <input type="time" name="time" required>
            <button type="submit" name="create">Créer</button>
        </div>
    </form>

    <h2>Liste des réservations</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <form method="post" style="display:inline;">
                <td><?php echo $row['id']; ?></td>
                <td><input type="text" name="name" value="<?php echo $row['name']; ?>" required></td>
                <td><input type="date" name="date" value="<?php echo $row['date']; ?>" required></td>
                <td><input type="time" name="time" value="<?php echo $row['time']; ?>" required></td>
                <td>
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="update">Mettre à jour</button>
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');">Supprimer</a>
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>

