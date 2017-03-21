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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<style>
    .CodeMirror, .CodeMirror-scroll {
        max-height:500px;
        overflow:auto;
    }

    form, .editor {
        height: 100%;
    }

    textarea {
        width: 100%;
        height: 80%;
        min-height: 80%;
    }
</style>
<form id="saveForm" action="<?php echo BASE_PATH?>/edit/<?php echo $controller->group ?>/<?php echo $controller->file ?>" method="POST">
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
                <a class="navbar-brand" href="<?php echo BASE_PATH?>">phpMdAdmin</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="#">Help<span class="sr-only">(current)</span></a></li>
                    <li><a href="#">Markdown Reference</a></li>
                </ul>
                <div class="navbar-form navbar-left">
                    <a class="btn btn-warning" href="<?php echo BASE_PATH?>/files/<?php echo $controller->group;?>" id="cancelButton"
                       data-toggle="confirmation" data-title="Lose Changes?" data-placement="bottom" >Close</a>
                    <button type="submit" class="btn btn-primary nav-btn">Save</button>
                </div>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <!--Input does not handle line breaks as nicely as textarea-->
    <div class="editor">
        <textarea name="content"><?php echo htmlspecialchars($controller->text); ?></textarea>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="<?php BASE_PATH ?>/public_html/js/confirmation.min.js"></script>
<script src="<?php echo BASE_PATH; ?>/public_html/js/edit.js"></script>
