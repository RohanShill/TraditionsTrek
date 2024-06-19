<?php
session_start();
include 'db.php';

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle new post submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'new_post') {
    $caption = $_POST['caption'];
    $user_id = $_SESSION['user_id'];
    $uploads_dir = 'uploads/';

    // Create uploads directory if it doesn't exist
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    // Handle file upload
    $image_path = $uploads_dir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)) {
        // Insert new post into the database
        $stmt = $conn->prepare("INSERT INTO posts (user_id, image_path, caption) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $image_path, $caption);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error uploading file.";
    }
}

// Fetch posts from the database
$result = $conn->query("SELECT posts.id, users.username, posts.image_path, posts.caption, posts.created_at, posts.likes FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community - Traditions Trek</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            font-family: 'Arial', sans-serif;
            padding-top: 50px;
            min-height: 100vh;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #28a745;
            color: white;
            text-align: center;
            font-size: 24px;
            border-radius: 10px 10px 0 0;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        .post img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .actions button {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <header class="bg-light py-3">
        <div class="container text-center">
            <h1>Traditions Trek</h1>
        </div>
    </header>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Community
                    </div>
                    <div class="card-body">
                        <form action="community.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="caption">Caption:</label>
                                <input type="text" class="form-control" id="caption" name="caption" required>
                            </div>
                            <div class="form-group">
                                <label for="image">Image:</label>
                                <input type="file" class="form-control-file" id="image" name="image" accept="image/*" required>
                            </div>
                            <button type="submit" name="action" value="new_post" class="btn btn-custom btn-block">Post</button>
                        </form>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <div class="post mt-4">
                                <h4><?php echo htmlspecialchars($row['username']); ?></h4>
                                <p><?php echo htmlspecialchars($row['caption']); ?></p>
                                <img src="<?php echo htmlspecialchars($row['image_path']); ?>" alt="Post Image">
                                <div class="actions mt-2">
                                    <!-- Like and delete buttons can be added here -->
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-light py-3 mt-4">
        <div class="container text-center">
            <p>© 2024 Traditions Trek. All rights reserved.</p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
