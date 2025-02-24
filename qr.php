<?php include('db.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR code with JavaScript</title>
    <link rel="stylesheet" href="style1.css">
    <script type="module" src="function1.js"></script>
</head>
<body>
    <div id="app">
        <div>
            <strong>Enter the register number</strong>
            <input type="text" id="qrCodeUrl">
            <br><button type="button" id="qrCodeGenerate">Generate the QR Code</button>
        </div>
        <br><img id="qrCodeImage">
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcode/1.4.4/qrcode.js"></script>
</body>
</html>