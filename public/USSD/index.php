<?php
// Read the variables sent via POST from our API
$sessionId   = $_POST["sessionId"] ?? '';
$serviceCode = $_POST["serviceCode"] ?? '';
$phoneNumber = $_POST["phoneNumber"] ?? '';
$text        = $_POST["text"] ?? '';

// Database credentials
define('DB_HOST', '127.0.0.1');
define('DB_DATABASE', 'skygo');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

try {
    // Create a PDO instance (connect to the database)
    $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_DATABASE;
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Handle connection error
    die("END Database connection failed. Please try again later.");
}

// Split the text input into parts for better handling
$inputParts = explode("*", $text);

// Process USSD logic
if ($text == "") {
    // This is the first request. Start the response with CON
    $response  = "CON What would you want to check?\n";
    $response .= "1. Enter secret code\n";
    $response .= "2. Models available\n";
    $response .= "3. Help";

} elseif ($text == "1") {
    // Prompt the user to enter their secret code
    $response = "CON Enter your secret code:";

} elseif (isset($inputParts[1]) && $inputParts[0] == "1") {
    // Handle secret code input
    $inputCode = $inputParts[1];
    $correctCode = "456"; // The correct secret code

    if ($inputCode === $correctCode) {
        // Admin menu after entering the correct secret code
        $response = "CON Admin Menu:\n";
        $response .= "1. Number of sold engines\n";
        $response .= "2. Number of unsold engines\n";
        $response .= "3. Total amount earned today\n";
        $response .= "4. Most sold model";
    } else {
        // Handle incorrect secret code
        $response = "END Invalid secret code. Please try again.";
    }

} elseif ($text == "3") {
    // Help menu
    $supportNumber = "0700 123 456"; // Replace with your support number
    $response = "END For assistance, please call:\n{$supportNumber}";

} elseif (isset($inputParts[2]) && $inputParts[0] == "1" && $inputParts[1] == "456") {
    // Admin menu selections
    $adminOption = $inputParts[2];

    if ($adminOption == "1") {
        // Number of sold engines
        $query = "SELECT COUNT(*) as count FROM engines WHERE status = :status";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['status' => 'sold']);
        $soldEngines = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

        $response = "END Correct code entered.\nThere are {$soldEngines} sold engines.";

    } elseif ($adminOption == "2") {
        // Number of unsold engines
        $query = "SELECT COUNT(*) as count FROM engines WHERE status = :status";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['status' => 'unsold']);
        $unsoldEngines = $stmt->fetch(PDO::FETCH_ASSOC)['count'] ?? 0;

        $response = "END There are {$unsoldEngines} available engines.";

    } elseif ($adminOption == "3") {
        // Total amount earned today
        $query = "SELECT SUM(price) as total FROM engines WHERE status = :status AND DATE(sold_at) = CURDATE()";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['status' => 'sold']);
        $totalEarnings = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

        $response = "END Total amount earned today: Ksh {$totalEarnings}";

    } elseif ($adminOption == "4") {
        // Most sold model
        $query = "SELECT model, COUNT(*) as count FROM engines WHERE status = :status GROUP BY model ORDER BY count DESC LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['status' => 'sold']);
        $mostSoldModel = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($mostSoldModel) {
            $response = "END Most sold model: {$mostSoldModel['model']} ({$mostSoldModel['count']} sold)";
        } else {
            $response = "END No model has been sold yet.";
        }

    } else {
        $response = "END Invalid admin option selected.";
    }

} elseif ($text == "2") {
    // Show available models
    $query = "SELECT model FROM engines WHERE status = :status GROUP BY model HAVING COUNT(*) > 0";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['status' => 'unsold']);
    $models = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (!empty($models)) {
        $response = "END Models available:\n" . implode("\n", $models);
    } else {
        $response = "END No models are available.";
    }

} else {
    // Default fallback for unrecognized input
    $response = "END Invalid option. Please try again.";
}

// Send the response back to the API
header('Content-type: text/plain');
echo $response;
?>
