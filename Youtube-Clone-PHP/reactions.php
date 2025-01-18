<?php
class Reactions
{
    // Method to save a reaction
    static function setReaction($postArray)
    {
        global $con;
        $array = [];
        if (!empty($postArray)) {

            // Validate and sanitize the name
            if (isset($postArray['name']) && $postArray['name'] != '') {
                $name = stripslashes(trim($postArray['name']));
            } else {
                $array['error'][] = "Name not set in array";
            }

            // Validate and sanitize the email
            if (isset($postArray['email']) && filter_var($postArray['email'], FILTER_VALIDATE_EMAIL)) {
                $email = stripslashes(trim($postArray['email']));
            } else {
                $array['error'][] = "Invalid email format";
            }

            // Validate and sanitize the message
            if (isset($postArray['message']) && $postArray['message'] != '') {
                $message = stripslashes(trim($postArray['message']));
            } else {
                $array['error'][] = "Message not set in array";
            }

            // Proceed if no errors
            if (empty($array['error'])) {
                $srqry = $con->prepare("INSERT INTO reactions (name, email, message, date) VALUES (?, ?, ?, NOW());");
                if ($srqry === false) {
                    prettyDump(mysqli_error($con));
                }

                $srqry->bind_param('sss', $name, $email, $message);
                if ($srqry->execute() === false) {
                    prettyDump(mysqli_error($con));
                } else {
                    $array['success'] = "Reaction saved successfully";
                }

                $srqry->close();
            }

            return $array;
        }
    }
    
    static function getReactions()
    {
        global $con;
        $array = [];

        // Fetch reactions with the date
        $grqry = $con->prepare("SELECT id, name, email, message, date FROM reactions ORDER BY date DESC;");
        if ($grqry === false) {
            prettyDump(mysqli_error($con)); // Error handling
            return false;
        } else {
            $grqry->bind_result($id, $name, $email, $message, $date);
            if ($grqry->execute()) {
                $grqry->store_result();
                while ($grqry->fetch()) {
                    $message = $message ? $message : ''; // Default empty message if null

                    $array[] = [
                        'id' => $id,
                        'name' => $name,
                        'email' => $email,
                        'message' => $message,
                        'date' => $date
                    ];
                }
            }
            $grqry->close();
        }

        return $array;
    }
}