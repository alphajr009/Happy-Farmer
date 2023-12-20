<?php
@include 'config.php';

if (isset($_GET['delete'])) {
    $userIdToDelete = $_GET['delete'];
    // Display a confirmation modal before deleting the user
    echo "<script>
            var confirmDelete = confirm('Do you want to delete this user?');
            if (confirmDelete) {
                window.location.href = 'delete_user.php?delete=$userIdToDelete';
            } else {
                window.history.back();
            }
          </script>";
    exit(); // Stop further execution of the page
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Manage</title>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
    :root {
        --green: #006400;
        --white: #fff;
        --bg-color: #eee;
        --box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1);
        --border: .1rem solid var(--white);
    }

    * {
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        outline: none;
        border: none;
        text-decoration: none;
        text-transform: capitalize;
    }

    html {
        font-size: 62.5%;
        overflow-x: hidden;
    }

    body {
        background-color: var(--white);
        color: var(--green);
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        padding: 2rem;
        margin: 0 auto;
    }

    h2 {
        text-align: center;
        font-size: 3rem;
        margin-bottom: 2rem;
        color: var(--green);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 2rem;
        border-radius: 0.5rem;
        box-shadow: var(--box-shadow);
    }

    th,
    td {
        padding: 1.5rem;
        font-size: 2rem;
        border-bottom: var(--border);
        text-align: left;
    }

    th {
        background: var(--bg-color);
    }

    td a {
        display: inline-block;
        padding: 1rem 2rem;
        background: var(--green);
        color: var(--white);
        text-align: center;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: background 0.3s;
    }

    td a:hover {
        background: var(--white);
        color: var(--green);
    }

    @media (max-width: 768px) {
        table {
            overflow-x: auto;
        }
    }
    </style>

</head>

<body>

    <div class="container">
        <h2>User Manage</h2>

        <?php
        $select_users = mysqli_query($conn, "SELECT * FROM users WHERE isAdmin = 0");
        $num_rows = mysqli_num_rows($select_users);

        if ($num_rows > 0) {
        ?>
        <table>
            <thead>
                <tr>
                    <th>UID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = mysqli_fetch_assoc($select_users)) {
                        echo '<tr>';
                        echo '<td>' . $row['user_id'] . '</td>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '<td>' . $row['email'] . '</td>';
                        echo '<td><a href="?delete=' . (isset($row['user_id']) ? $row['user_id'] : '') . '">Delete</a></td>';
                        echo '</tr>';
                    }
                    ?>
            </tbody>
        </table>
        <?php
        } else {
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>UID</th>';
            echo '<th>Name</th>';
            echo '<th>Email</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            echo '<tr>';
            echo '<td colspan="4" style="text-align: center;">No Data Available</td>';
            echo '</tr>';
            echo '</tbody>';
            echo '</table>';
        }
        ?>
    </div>

</body>


</html>