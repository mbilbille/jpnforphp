<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>JpnForPhp library - unit tests</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>UNIT TESTS<small> - JpnForPhp library</small></h1>
            </div>
            <div class="tabbable">
                <ul class="nav nav-pills">
                    <li class="disabled"><a href="#">Process test on</a></li>
                    <li><a id="analyzer" href="#tab-analyzer" data-toggle="pill">Analyzer</a></li>
                    <li><a id="helper" href="#tab-helper" data-toggle="pill">Helper</a></li>
                    <li><a id="transliterator" href="#tab-transliterator" data-toggle="pill">Transliterator</a></li>
                </ul>
                <div class="progress">
                  <div class="bar bar-success" style="width: 0%;"></div>
                  <div class="bar bar-danger" style="width: 0%;"></div>
                </div>
                <div class="pill-content">
                    <div class="pill-pane" id="tab-analyzer"></div>
                    <div class="pill-pane" id="tab-helper"></div>
                    <div class="pill-pane" id="tab-transliterator"></div> 
                </div>
            </div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/application.js"></script>
    </body>
</html>
