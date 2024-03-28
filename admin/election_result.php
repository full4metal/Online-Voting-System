<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'votesystem');

// Calculate majority vote
$sql = "SELECT position_id, candidate_id, COUNT(*) AS votes_count FROM votes GROUP BY position_id, candidate_id";
$result = mysqli_query($conn, $sql);

$majority_votes = []; // Array to store positions with majority votes

while ($row = mysqli_fetch_assoc($result)) {
    $position_id = $row['position_id'];
    $candidate_id = $row['candidate_id'];
    $votes_count = $row['votes_count'];

    if (!isset($majority_votes[$position_id]) || $majority_votes[$position_id]['votes_count'] < $votes_count) {
        $majority_votes[$position_id] = [
            'candidate_id' => $candidate_id,
            'votes_count' =>  $votes_count
        ];
    }
}

// Update publish_result status for each position with majority votes
foreach ($majority_votes as $position_id => $data) {
    $candidate_id = $data['candidate_id'];
    $votes_count = $data['votes_count'];

    // Retrieve candidate information
    $candidate_sql = "SELECT firstname FROM candidates WHERE id = $candidate_id";
    $candidate_result = mysqli_query($conn, $candidate_sql);
    $candidate_row = mysqli_fetch_assoc($candidate_result);
    $candidate_name = $candidate_row['firstname'];

    // Retrieve position information
    $position_sql = "SELECT description FROM positions WHERE id = $position_id";
    $position_result = mysqli_query($conn, $position_sql);
    $position_row = mysqli_fetch_assoc($position_result);
    $position_name = $position_row['description'];

    // Update publish_result status
    $update_sql = "UPDATE positions SET publish_result = 1 WHERE id = $position_id";
    mysqli_query($conn, $update_sql);
    
   
    // Print the result
    //echo "Position: $position_name, Winner: $candidate_name, Votes: $votes_count<br>";
}
header('location: votes.php');
// Close the connection
mysqli_close($conn);
?>
