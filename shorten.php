<?php
// Database connection
$host = "localhost";
$db = "url_shortener";
$user = "root";
$password = "mysqlserver";

$conn = mysqli_connect($host, $user, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to generate a random short code
function generateShortCode() {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $code = '';
    for ($i = 0; $i < 6; $i++) {
        $code .= $chars[rand(0, strlen($chars) - 1)];
    }
    return $code;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $long_url = $_POST['long_url'];
    $short_code = generateShortCode();

    $sql = "INSERT INTO urls (short_code, long_url) VALUES ('$short_code', '$long_url')";
    if ($conn->query($sql) === TRUE) {
        $shortened_url = "http://yourdomain.com/$short_code"; // Replace with your domain
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>URL Shortener</h1>
        <?php if(isset($shortened_url)): ?>
        <p>Shortened URL: <a href="<?php echo $shortened_url; ?>" target="_blank"><?php echo $shortened_url; ?></a></p>
        <?php endif; ?>
        <a href="index.html">Shorten another URL</a>
    </div>
</body>
</html>
