<?php
    include 'includes/session.php';

    // Connect to the database
    //$conn = new mysqli('localhost', 'root', '', 'votesystem');

    // Perform a query to fetch positions, candidates, and their votes
    $sql = "SELECT p.description AS position, CONCAT(c.firstname, ' ', c.lastname) AS candidate_name, COUNT(v.candidate_id) AS votes_count, p.election_name
            FROM positions p
            LEFT JOIN candidates c ON p.id = c.position_id
            LEFT JOIN votes v ON c.id = v.candidate_id
            GROUP BY p.description, c.firstname, c.lastname, p.election_name";

    $result = mysqli_query($conn, $sql);

    // Check if the query was successful
    if ($result) {
        // Iterate over each row in the result set
        while ($row = mysqli_fetch_assoc($result)) {
            // Extract position, candidate, votes count, and election name
            $position = $row['position'];
            $candidateName = $row['candidate_name'];
            $votesCount = $row['votes_count'];
            $electionName = $row['election_name'];

            // Insert the data into the election_results table
            $insertSQL = "INSERT INTO election_results (position, candidate_name, votes_count, election_name)
                          VALUES ('$position', '$candidateName', $votesCount, '$electionName')";

            if ($conn->query($insertSQL) !== TRUE) {
                //echo "Error inserting data: " . $conn->error;
            }
        }
        // Free result set
        mysqli_free_result($result);
    } else {
        // Handle query error
        //echo "Error fetching data: " . mysqli_error($conn);
    }

    // Close the database connection


 //END 
    // Delete all votes
    $sqlDeleteVotes = "DELETE FROM votes";
    if ($conn->query($sqlDeleteVotes)) {
        // Reset publish_result in positions table to 0
        $sqlUpdatePositions = "UPDATE positions SET publish_result = 0";
        if ($conn->query($sqlUpdatePositions)) {
            // Delete all candidates
            $sqlDeleteCandidates = "DELETE FROM candidates";
            if ($conn->query($sqlDeleteCandidates)) {
                // Delete all positions
                $sqlDeletePositions = "DELETE FROM positions";
                if ($conn->query($sqlDeletePositions)) {
                    $_SESSION['success'] = "Votes, candidates, and positions reset successfully";
                } else {
                    $_SESSION['error'] = "Something went wrong in deleting positions";
                }
            } else {
                $_SESSION['error'] = "Something went wrong in deleting candidates";
            }
        } else {
            $_SESSION['error'] = "Something went wrong in resetting publish_result";
        }
    } else {
        $_SESSION['error'] = "Something went wrong in resetting votes";
    }

    header('location: votes.php');
?>
