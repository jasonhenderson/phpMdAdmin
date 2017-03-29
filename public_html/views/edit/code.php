<?php
/**
 * This file is part of phpMdAdmin.
 *
 *  phpMdAdmin is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  phpMdAdmin is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package phpMdAdmin
 */


?>
<body>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.23.0/codemirror.min.css">
    <form action="<?php echo BASE_PATH?>/edit/page/<?php echo $controller->group ?>" method="POST">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                    <a class="navbar-brand" href="<?php echo BASE_PATH?>">Markdown Manager</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Help<span class="sr-only">(current)</span></a></li>
                        <li><a href="https://simplemde.com/markdown-guide">Markdown Reference</a></li>
                    </ul>
                    <div class="navbar-form navbar-left">
                        <a class="btn btn-warning" href="<?php echo BASE_PATH?>" id="cancelButton"
                           data-toggle="confirmation" data-title="Lose Changes?" data-placement="bottom" >Cancel</a>
                        <button type="submit" class="btn btn-primary nav-btn">Save</button>
                    </div>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
        <!--Input does not handle line breaks as nicely as textarea-->
        <div class="editor">
            <textarea id="content" name="content"></textarea>
        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="<?php echo BASE_PATH?>/public_html/js/confirmation.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.23.0/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.23.0/mode/<?php echo $controller->codeMode ?>/<?php echo $controller->codeMode ?>.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle=confirmation]').confirmation({
              rootSelector: '[data-toggle=confirmation]',
              // other options
            });

<?php
// You have to json_encode to make sure line breaks are processed
echo "$('textarea').val(" . json_encode($controller->text) . ")"
?>
            var myCodeMirror = CodeMirror.fromTextArea($('textarea').get(0));
        });
    </script>
</body>
