<!DOCTYPE html>
<html>
<head>
    <title>To Do List</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
   
</head>

 <h1>My To Do List</h1>
 
<body>
    <?php
    // The database connection sequence
    $conn = mysqli_connect('localhost', 'root', 'Godzilla@1992', 'todolist');

    // The connection is checked
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // The application checks whether a new item was added or not
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $description =filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        
        // A new item is inserted into the database
        $sql = "INSERT INTO todoitems (ItemNum,Title, Description) VALUES ('$itemNum', '$title', '$description')";
        mysqli_query($conn, $sql);
    }

    // The application checks if an item was removed
    if (isset($_GET['remove'])) {
        $itemNum = filter_input(INPUT_GET,'ItemNum', FILTER_SANITIZE_INT);

        
        $sql = "DELETE FROM todoitems WHERE ItemNum = $itemNum";
        mysqli_query($conn, $sql);
    }

    // list items are selected from the database
    $sql = "SELECT * FROM todoitems";
    $result = mysqli_query($conn, $sql);

    // The list items are displayed to the screen
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result))
        {
            $itemNum = $row['ItemNum'];
            $title = $row['Title'];
            $description = $row['Description'];
            echo "<p><b>Task # $itemNum</p></b>";
            echo "<p><b>$title</b></p>";
            echo "<p><b>$description <span class='remove-btn' onclick=\"window.location.href='index.php?remove=$itemNum'\">X</span></b></p>";
        }
    } else {
        echo "No to do list items exist yet.";
    }

    // The connection to the database is closed
    mysqli_close($conn);
    ?>
    
   
    <h2><str>Add Item</str></h2>
    <form method="POST" action="index.php">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required maxlength="20"><br><br>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" required maxlength="50"><br><br>
        <input type="submit" value="Add">
    </form>
</body>
</html>


