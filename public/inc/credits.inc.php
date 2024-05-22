<?php
// Include the PDO connection
include "./connect.inc.php";

// Step 1: Validate the input data
if(isset($_POST['recipient']) && isset($_POST['amount'])) {
    $recipient = $_POST['recipient'];
    $amount = (int)$_POST['amount'];

    // Step 2: Ensure recipient exists
    $recipientQuery = "SELECT id FROM users WHERE username = :recipient";
    $recipientStatement = $pdo->prepare($recipientQuery);
    $recipientStatement->execute(['recipient' => $recipient]);

    if($recipientStatement->rowCount() == 0) {
        header("Location: ../dashboard/?error=userNotFound");
        exit(); // You might want to handle this more gracefully
    }

    // Step 3: Check if the sender has enough daily credits
    session_start(); // Start the session
    $senderId = $_SESSION['cuid']; // Assuming user is logged in
    $senderQuery = "SELECT bran_total, bran_daily FROM user_data WHERE user_id = :senderId";
    $senderStatement = $pdo->prepare($senderQuery);
    $senderStatement->execute(['senderId' => $senderId]);
    $senderData = $senderStatement->fetch(PDO::FETCH_ASSOC);
    $senderTotal = $senderData['bran_total'];
    $senderDaily = $senderData['bran_daily'];

    if($amount > $senderDaily) {
        header("Location: ../dashboard/?error=insufficientCredits");
        exit(); // Again, handle this better
    }

    // Step 4: Update bran_daily for sender and bran_total for recipient
    $recipientId = $recipientStatement->fetch(PDO::FETCH_ASSOC)['id'];
    $updateRecipientQuery = "UPDATE user_data SET bran_total = bran_total + :amount WHERE user_id = :recipientId";
    $updateRecipientStatement = $pdo->prepare($updateRecipientQuery);
    $updateRecipientStatement->execute(['amount' => $amount, 'recipientId' => $recipientId]);

    // Update sender's bran_daily by subtracting the sent amount
    $updateSenderQuery = "UPDATE user_data SET bran_daily = bran_daily - :amount WHERE user_id = :senderId";
    $updateSenderStatement = $pdo->prepare($updateSenderQuery);
    $updateSenderStatement->execute(['amount' => $amount, 'senderId' => $senderId]);

    header("Location: ../dashboard/?success=true");
} else {
    header("Location: ../dashboard/?success=false");
}
?>
