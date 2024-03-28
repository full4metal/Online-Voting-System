<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Results</title>
    <style>
        /* CSS Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            
        }
        .result-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .candidate-photo img {
            border-radius: 50%;
            margin-right: 20px;
        }
        .result-details {
            flex-grow: 1;
        }
        .position {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .winner {
            font-size: 16px;
            color: #009688;
            margin-top: 5px;
        }
        .votes {
            font-size: 14px;
            color: #777;
            margin-top: 5px;
        }
        .graph {
            width: 300px; 
            height: 300px; 
            margin: 0 auto; 
            display: block; 
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="container">
                
                <!-- Main content -->
                <section class="content">
                    <h2>Election Results</h2>
                    <?php
                    
                    foreach ($majority_votes as $position_id => $data) {
                        // Retrieve candidate information from the database
                        $candidate_id = $data['candidate_id'];
                        $votes_count = $data['votes_count'];
                        
                        // Retrieve position information from the database
                        $position_sql = "SELECT description FROM positions WHERE id = $position_id";
                        $position_result = $conn->query($position_sql);
                        $position_row = $position_result->fetch_assoc();
                        $position_name = $position_row['description'];
                        
                        // Retrieve candidate information from the database
                        $candidate_sql = "SELECT * FROM candidates WHERE id = $candidate_id";
                        $candidate_result = $conn->query($candidate_sql);
                        $candidate_row = $candidate_result->fetch_assoc();
                        $candidate_name = $candidate_row['firstname'] . ' ' . $candidate_row['lastname'];
                        $candidate_photo = $candidate_row['photo'];
                        
                        // Display the winning candidate's information with CSS styling
                        echo "<div class='result-container'>";
                        echo "<div class='candidate-photo'><img src='images/$candidate_photo' width='100' height='100' alt='no img'></div>";           
                        echo "<div class='result-details'>";
                        echo "<div class='position'>Position: $position_name</div>";
                        echo "<div class='winner'>Winner: $candidate_name</div>";
                        echo "<div class='votes'>Votes: $votes_count</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    
                    ?>
                    
                     
                </section>
              
            </div>
        </div> 
    </div>
    <div class="graph"> <?php include 'graph.php'; ?> </div>
</body>
</html>
