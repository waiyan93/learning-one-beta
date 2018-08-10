<?php
    // $upload_dir = '/data';
    // $tmp_name = $_FILES["pdf"]["tmp_name"];
    // $name = basename($_FILES["pdf"]["name"]);
    // move_uploaded_file($tmp_name, "$uploads_dir/$name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF Editor with PDFjs</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/jquery-ui/jquery-ui.min.css">
    <style>
        #viewer {
            background: rgba(0, 0, 0, 0.1);
            overflow: auto;
        }

        .page-canvas {
            display: block;
            margin: 5px 10px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            width: 800px;
            height: 1000px;
        }
        .select-box {
            display: none;
            width: 250px;
            height: 150px;
            background-color: rgb(0, 255, 148);
            opacity: 0.5;
        }
        #select-content {
            z-index: 2;
            margin: 0 10px;
        }

        .select-box h5 {
            margin: 0;
            text-align: center;
        }
        
        #add-link, #cancel {
            display: none;
            color: white;
            background-color: black;
            border: none;
        }
        #add-link:hover, #cancel:hover {
            cursor: pointer;
            color: black;
            background-color: white;
            text-decoration: underline;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark sticky-top bg-dark">
      <a class="navbar-brand" href="#">PDF Linking</a>
      <button id="select-content" class="btn btn-primary mr-5">Select Tool</button>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav">
            <li class="x-position nav-link text-white">X-Position (px) : 0</li>
            <li class="y-position nav-link text-white">Y-Position (px) : 0</li>
            <li class="box-width nav-link text-white">Width (px) : 250</li>
            <li class="box-height nav-link text-white">Height (px) : 150</li>
        </ul>
      </div>
    </nav> 
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="select-box">
                    <button id="add-link" type="button" class="float-right" data-toggle="modal" data-target="#addLinkModal">Add Link</button>
                        <h5 class="ui-widget-header pb-2">Drag Me</h5>
                    <button id="cancel" class="float-left">Deselect</button>
                </div>
                <div id='viewer'>
                </div>
                 <!-- Modal -->
                <div class="modal fade" id="addLinkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Add Link</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="http://localhost/mmnews/output.php" method="POST">
                            <div class="modal-body mx-3">
                                <div class="md-form mb-2">
                                    <label for="link-type">Link Type :</label>
                                    <select name="link_type" id="link-type" class="form-control">
                                        <option value="0">Choose Link Type</option>
                                        <option value="1">Website Link</option>
                                        <option value="2">Video Link</option>
                                    </select>
                                </div>
                                 <div class="md-form mb-2">
                                    <label for="link">Link :</label>
                                    <input type="text" name="link" id="link" class="form-control">
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <input class="x-position" type="hidden" name="x-position" value="">
                                <input class="y-position" type="hidden" name="y-position" value="">
                                <input class="box-width" type="hidden" name="width" value="250">
                                <input class="box-height" type="hidden" name="height" value="150">
                                <input type="hidden" class="page-width" name="page-width" value ="">
                                <input type="hidden" class="page-height" name="page-height" value ="">
                                <button id="btn-save" class="btn btn-success btn-block">Save</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/jquery.min.js"></script>
    <script src="assets/jquery-ui/jquery-ui.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/pdf-js/build/pdf.js"></script>

    <script>

        var url = 'data/1.pdf';
        var thePdf = null;
        var scale = 1;
        PDFJS.getDocument(url).promise.then(function(pdf) {
            thePdf = pdf;
            viewer = document.getElementById('viewer');

            // for(page = 1; page <= pdf.numPages; page++) {
                canvas = document.createElement("canvas");    
                canvas.className = 'page-canvas'; 
                canvas.id = 'page-' + 5;
                viewer.appendChild(canvas);  
                renderPage(5, canvas);
            // } 
        });

        function renderPage(pageNumber, canvas) {
            thePdf.getPage(pageNumber).then(function(page) {
                viewport = page.getViewport(scale);
                canvas.height = viewport.height;
                canvas.width = viewport.width;    
                $('.page-width').val(canvas.width);
                $('.page-height').val(canvas.height);      
                page.render({canvasContext: canvas.getContext('2d'), viewport: viewport});
            });
        }
    </script>
    <script>
        $(document).ready(function(){
            var xPosition = 0;
            var yPosition = 0;
            var boxWidth = 250;
            var boxHeight = 150;
            
            $('#select-content').click(function(){
                $('.select-box').show(); 
                $('.select-box').css('position', 'absolute'); 
                $('.select-box').draggable(); 
                $('.select-box').resizable(); 
            });

            $('.select-box').draggable({
                start: function( event, ui ) {
                    $('.select-box h5').remove();
                    $('#add-link').hide();
                    $('#cancel').hide();
                },
                stop: function( event, ui ) {
                    xPosition = ui.position.left;
                    yPosition = ui.position.top;
                    $('.x-position').html('X-Position(px) : '+ xPosition);
                    $('.y-position').html('Y-Position(px) : '+ yPosition);
                    $('.x-position').val(xPosition);
                    $('.y-position').val(yPosition);
                    $('#add-link').show();
                    $('#cancel').show();
                },
            });

            $('.select-box').resizable({
                stop: function( event, ui ) {
                    boxWidth = ui.size.width;
                    boxHeight = ui.size.height;
                    $('.box-width').html('Width(px) : '+ boxWidth);
                    $('.box-height').html('Height(px) : '+ boxHeight);
                    $('.box-width').val(boxWidth);
                    $('.box-height').val( boxHeight);
                }
            });

            $("#add-link").click(function(){
                modal({show: true,});
            });

            $('#cancel').click(function() {
                $(".select-box").hide();
            });

        });
    </script>
</body>
</html>