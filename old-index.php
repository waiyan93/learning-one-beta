<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Upload PDF</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <style>
        .upload-area {
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark sticky-top bg-dark">
      <a class="navbar-brand" href="#">PDF Editor</a>
    </nav> 
    <div class="container-fluid">
        <div class="row upload-area">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-8 col-md-8 offset-lg-2 offset-md-2">
                        <form action="http://localhost/mmnews/editor.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="card">
                                    <div class="card-header">
                                        Upload PDF
                                    </div>
                                    <div class="card-body">
                                        <input type="file" name="pdf">
                                        <br>
                                        <br>
                                        <input type="submit" name="submit" class="btn btn-primary">
                                    </div> 
                                </div>
                            </div>       
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="assets/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>