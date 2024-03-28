<style>
    /* Style for the table */
table {
    width: 100%;
    border-collapse: collapse;
}

/* Style for table header */
th {
    background-color: #f2f2f2;
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

/* Style for table data */
td {
    border: 1px solid #ddd;
    padding: 8px;
}

/* Style for alternate rows */
tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Style for table footer */
tfoot {
    font-weight: bold;
}

</style>
<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'votesystem');

// Perform a query to fetch positions, candidates, and their votes
$sql = "SELECT p.description AS position, CONCAT(c.firstname, ' ', c.lastname) AS candidate_name, COUNT(v.candidate_id) AS votes_count
        FROM positions p
        LEFT JOIN candidates c ON p.id = c.position_id
        LEFT JOIN votes v ON c.id = v.candidate_id
        GROUP BY p.description, c.firstname, c.lastname";

$result = mysqli_query($conn, $sql);

// Check if the query was successful
if ($result) {
    // Output table header
    echo "<table border='1'>";
    echo "<tr><th>Position</th><th>Candidate</th><th>Votes</th></tr>";
    
    // Iterate over each row in the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Extract position, candidate, and votes count
        $position = $row['position'];
        $candidateName = $row['candidate_name'];
        $votesCount = $row['votes_count'];
        
        // Output position, candidate, and votes count in a table row
        echo "<tr><td>$position</td><td>$candidateName</td><td>$votesCount</td></tr>";
    }
    
    // Output table footer
    echo "</table>";
    
    // Free result set
    mysqli_free_result($result);
} else {
    // Handle query error
    echo "Error fetching data: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);
?>
