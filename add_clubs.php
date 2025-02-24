<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Club Details</title>
</head>
<body>

<h2>Add a New Club</h2>
<form action="upload_club.php" method="post" enctype="multipart/form-data">
    <label>Club Name:</label>
    <input type="text" name="name" required><br>
    
    <label>Description:</label>
    <textarea name="description" required></textarea><br>
    
    <label>Category:</label>
    <input type="text" name="category" required><br>
    
    <label>Upload Image:</label>
    <input type="file" name="image" accept="image/*" required><br>
    
    <button type="submit">Add Club</button>
</form>

</body>
</html>
