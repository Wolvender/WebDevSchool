<?php
include("config.php");
include("reactions.php");

// Fetch existing reactions (optional, to display later)
$reactions = Reactions::getReactions(); // Fetch reactions

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['send'])) {
    $postArray = [
        'name' => isset($_POST['username']) ? $_POST['username'] : '',
        'email' => isset($_POST['email']) ? $_POST['email'] : '',
        'message' => isset($_POST['message']) ? $_POST['message'] : '',
    ];

    // Validate form fields
    if (!empty($postArray['name']) && !empty($postArray['email']) && !empty($postArray['message'])) {
        // Insert reaction into database
        $setReaction = Reactions::setReaction($postArray);

        // Check if there is an error during the insert process
        if (isset($setReaction['error']) && $setReaction['error'] != '') {
            echo "Error: " . $setReaction['error'];
        }

        // Redirect to prevent re-submission after refresh
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "Please fill in all fields before submitting!";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youtube Clone</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <img id="YTImg" src="assets/imgs/Youtube.png" alt="Img">
    <iframe 
      id="Vid"
      width="560" 
      height="315" 
      src="https://www.youtube.com/embed/MmB9b5njVbA" 
      referrerpolicy="strict-origin-when-cross-origin" 
      allowfullscreen>
    </iframe>

    <h2></h2>
    <p></p>
    <form method="post">
        <label id="email" for="email">Email:</label>
        <input type="email" id="email" name="email">
        <br>

        <label id="username" for="username">Username:</label>
        <input type="text" id="username" name="username">
        <br>
        
        <label id="message" for="message">Message:</label>
        <textarea id="textarea" name="message" rows="4"></textarea>
        <br>

        <button id="Button" name="send" type="submit">Send</button>
    </form>
    <hr>

    <div id="reactions">
    <style>
        #reactions {
            color:rgb(188, 98, 98);
            

        }
    </style>
        <?php if (!empty($reactions)): ?>
            <ul>
                <?php foreach ($reactions as $reaction): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($reaction['name']); ?>:</strong>
                        <?php echo htmlspecialchars($reaction['message']); ?>
                        <small>(<?php echo date('F j, Y, g:i a', strtotime($reaction['date'])); ?>)</small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No reactions yet. Be the first to post one!</p>
        <?php endif; ?>
    </div>
</body>
</html>
