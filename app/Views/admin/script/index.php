<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?= base_url('script/import-file'); ?>" method="post" enctype="multipart/form-data">
        <label>Upload File</label>
        <?= csrf_field(); ?>
        <input type="file" name="fileExcel" required>
        <input type="submit" value="Upload">
    </form>
</body>
</html>