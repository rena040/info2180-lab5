<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
    $query = isset($_GET['country']) && !empty($_GET['country']) 
        ? "
            SELECT cities.name AS city_name, cities.district, cities.population 
            FROM cities 
            JOIN countries ON cities.country_code = countries.code 
            WHERE countries.name LIKE :country
        " 
        : "
            SELECT cities.name AS city_name, cities.district, cities.population 
            FROM cities
        ";

    $stmt = $conn->prepare($query);
    if (isset($_GET['country']) && !empty($_GET['country'])) {
        $likeCountry = '%' . $_GET['country'] . '%';
        $stmt->bindParam(':country', $likeCountry);
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<table border="1">
            <thead>
                <tr>
                    <th>City Name</th>
                    <th>District</th>
                    <th>Population</th>
                </tr>
            </thead>
            <tbody>';
    if (count($results) > 0) {
        foreach ($results as $row) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['city_name']) . '</td>
                    <td>' . htmlspecialchars($row['district']) . '</td>
                    <td>' . htmlspecialchars($row['population']) . '</td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="3">No cities found.</td></tr>';
    }
    echo '</tbody></table>';
} else {
    $query = isset($_GET['country']) && !empty($_GET['country']) 
        ? "SELECT * FROM countries WHERE name LIKE :country" 
        : "SELECT * FROM countries";

    $stmt = $conn->prepare($query);
    if (isset($_GET['country']) && !empty($_GET['country'])) {
        $likeCountry = '%' . $_GET['country'] . '%';
        $stmt->bindParam(':country', $likeCountry);
    }
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo '<table border="1">
            <thead>
                <tr>
                    <th>Country Name</th>
                    <th>Continent</th>
                    <th>Independence Year</th>
                    <th>Head of State</th>
                </tr>
            </thead>
            <tbody>';
    if (count($results) > 0) {
        foreach ($results as $row) {
            echo '<tr>
                    <td>' . htmlspecialchars($row['name']) . '</td>
                    <td>' . htmlspecialchars($row['continent']) . '</td>
                    <td>' . htmlspecialchars($row['independence_year']) . '</td>
                    <td>' . htmlspecialchars($row['head_of_state']) . '</td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="4">No countries found.</td></tr>';
    }
    echo '</tbody></table>';
}
?>
