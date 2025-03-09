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
    $sql = "UPDATE reservations SET name='$name', date='$date', time='$time' WHERE id=$id";
    $conn->query($sql);
}

// Supprimer une réservation
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM reservations WHERE id=$id");
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
        <input type="text" name="name" placeholder="Nom" required>
        <input type="date" name="date" required>
        <input type="time" name="time" required>
        <button type="submit" name="create">Créer</button>
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
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['time']; ?></td>
                <td><button type="submit" name="update">Mettre à jour</button>
                    <button href="?delete=<?php echo $row['id']; ?>">Supprimer</button></td>

            </form>
            <!--html>
                <a href="?delete=<!?php echo $row['id']; ?>">Supprimer</a>
            </html-->
        </tr>
        <?php endwhile; ?>
    </table>
    <!--script src="script.js"></script-->
</body>
</html>

<?php
$conn->close();
?>
