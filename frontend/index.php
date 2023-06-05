<html>
<head>
    <title>Image Hosting Platform</title>
    <style>
        /* Add some CSS to style the page */
        body {
            font-family: sans-serif;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="submit"] {
            margin-top: 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <h1>Image Hosting Platform</h1>
    <form enctype="multipart/form-data" action="upload.php" method="POST">
        <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg,.png,.gif,.mp4,.ogg,.webm" required />
        <input type="submit" value="Upload" />
    </form>
</body>
</html>