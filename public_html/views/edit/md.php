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

    #assets img {
        width: 100%;
    }

    .selected {
        border: solid 8px yellow;
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

    <div class="editor">
    <!--This is for available asset picking-->
    <?php
if (!empty($controller->assets)) {
    echo "<a class=\"btn btn-action\" data-toggle=\"collapse\" data-target=\"#assets\">";
    echo "Show <span class=\"glyphicon glyphicon-picture glyphicon-reverse\" aria-hidden=\"true\"></span>";
    echo "</a>";
    echo "<section id=\"assets\" class=\"collapse editor\">";
    for ($i = 0; $i < count($controller->assets); $i++) {
        $addRow = $i % 4;

        $asset = $controller->assets[$i];

        if ($addRow) echo "<div class=\"row\">";

        echo "  <div class=\"col-md-3\">";
        echo "    <img src=\"" . BASE_PATH . "/assets/" . $asset["group"] . "/" . $asset["asset"] . "\" data-asset=\"" . $asset["asset"] . "\" data-group=\"" . $asset["group"] . "\"/>";
        echo "  </div>";

        if ($addRow) echo "</div>";
    }
    echo "</section>";
}

?>
    <!--Input does not handle line breaks as nicely as textarea-->
        <textarea id="content" name="content"></textarea>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="<?php echo BASE_PATH; ?>/public_html/js/confirmation.min.js"></script>
<script src="<?php echo BASE_PATH; ?>/public_html/js/edit.js"></script>
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
    // Most options demonstrate the non-default behavior
    $(document).ready(function() {
        // Add the selection event
        var selectedImage = null;

        $("#assets img").click(function(e) {
            if ($(this).hasClass("selected")) {
                selectedImage = null;
                $("#assets img").removeClass("selected");
            }
            else {
                selectedImage = $(this);
                $("#assets img").removeClass("selected");
                $(this).addClass("selected");
            }
        });

        var simplemde = new SimpleMDE({
            autofocus: true,
            blockStyles: {
                bold: "__",
                italic: "_"
            },
            element: document.getElementById("content"),
            initialValue: <?php echo json_encode($controller->text); ?>,
            indentWithTabs: false,
            insertTexts: {
                horizontalRule: ["", "\n\n-----\n\n"],
                link: ["[", "](http://)"],
                table: ["", "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text     | Text      | Text     |\n\n"],
            },
            toolbar: ["bold", {
    			name: "image",
    			action: function(editor) {
    			    var group = selectedImage ? selectedImage.data("group") : "";
    			    var asset = selectedImage ? selectedImage.data("asset") : "";
    			    var template = "![choose or remove: right|left|full|none](/assets/" + group + "/" + asset;
    			    editor.options.insertTexts["image"] = [template, ")"]
    				SimpleMDE.drawImage(editor);
    			},
    			className: "fa fa-image",
    			title: "Custom Button",
		    }],
            placeholder: "Type here...",
            renderingConfig: {
                codeSyntaxHighlighting: true,
            },
            shortcuts: {
                drawTable: "Cmd-Alt-T"
            },
            showIcons: ["code", "table"],
            spellChecker: true,
            status: ["lines", "words", "cursor", {
                className: "keystrokes",
                defaultValue: function(el) {
                    this.keystrokes = 0;
                    el.innerHTML = "0 Strokes";
                },
                onUpdate: function(el) {
                    el.innerHTML = ++this.keystrokes + " Strokes";
                }
            }], // Another optional usage, with a custom status bar item that counts keystrokes
            tabSize: 4
        });

        simplemde.codemirror.on("change", function() {
            flagChanged(this);
        });
    });

</script>
