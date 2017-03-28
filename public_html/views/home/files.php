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

<style type="text/css">
.table tbody>tr>td.vert-align{
    vertical-align: middle;
}
</style>

<div class="row">
    <div class="col-md-2">
        <a class="btn btn-action" href="<?php echo BASE_PATH?>/" >
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            Back
        </a>
    </div>
    <div class="col-md-4 col-md-offset-6">
        <form class="form-inline" action="<?php echo BASE_PATH?>/api/createFile" method="POST">
            <div class="form-group">
                <a class="btn btn-success" href="<?php echo BASE_PATH?>/assets/upload/<?php echo $controller->group ?>">
                    Add <span class="glyphicon glyphicon-picture glyphicon-reverse" aria-hidden="true"></span>
                </a>
                <label class="sr-only" for="file">Create New Group</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="New File Name" id="file" name="file">
                    <input type="hidden" name="group" value="<?php echo $controller->group?>">
                </div>
                <button type="submit" class="btn btn-success" name="submit">
                    <span class="glyphicon glyphicon-plus glyphicon-reverse" aria-hidden="true"></span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row">
<div class="col-md-12">
<div class='table-responsive'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th>
                    File
                </th>
                <th>
                    Actions
                </th>
                <th colspan="2">
                    Page URL
                </th>
            </tr>
        </thead>
        <tbody>
<?php
$rowNumber = 0;

// For binding clipboard.js buttons to inputs
$rowNumber++;

$urlScheme    = $_SERVER["REQUEST_SCHEME"];
$urlHost      = $_SERVER["HTTP_HOST"];
// $urlEndPoint  = $_SERVER["REQUEST_URI"];
// $urlDirectory = dirname($urlEndPoint);
$urlBase      = $urlScheme . "://" . $urlHost . BASE_PATH;

// Add a row that holds another table for the files

foreach ($controller->files as $file) {
    $pageUrl       = "/view/md/" . $file["group"] . "/" . $file["name"];
    $pagePdfUrl = "/view/pdf/md/" . $file["group"] . "/" . $file["name"];
    $slidesUrl = "/view/slides/" . $file["group"] . "/" . $file["name"];
    $slidesPdfUrl = "/view/pdf/slides/" . $file["group"] . "/" . $file["name"];
    $pageEditorUrl = "/edit/" . $file["group"] . "/" . $file["name"];
    $pageTextEditorUrl = "/edit/text/" . $file["group"] . "/" . $file["name"];
    $pageDeleteUrl = "/api/removeFile/" . $file["group"] . "/" . $file["name"];

    echo "<tr>";

    echo "<td class='vert-align'>";
    echo $file["name"];
    echo "</td>";

    // Action buttons dropdown
    echo "<td class='vert-align'>";
    echo "<div class='btn-group'>";
    echo "    <button type='button' class='btn btn-primary dropdown-toggle'";
    echo "            data-toggle='dropdown'";
    echo "            aria-haspopup='true' aria-expanded='false'>";
    echo "        Action <span class='caret'></span>";
    echo "    </button>";
    echo "    <ul class='dropdown-menu'>";
    echo "        <li><a href='" . BASE_PATH . $pageEditorUrl . "'>Edit Page</a></li>";
    echo "        <li><a href='" . BASE_PATH . $pageTextEditorUrl . "'>Text Edit Page</a></li>";
    echo "        <li role='separator' class='divider'></li>";
    echo "        <li><a href='" . BASE_PATH . $pageUrl . "' target='_blank'>View Page</a></li>";
    echo "        <li><a href='" . BASE_PATH . $pagePdfUrl . "' target='_blank'>View Page PDF</a></li>";
    echo "        <li><a href='" . BASE_PATH . $slidesUrl . "' target='_blank'>View Slides</a></li>";
    echo "        <li role='separator' class='divider'></li>";
    echo "        <li><a href='" . BASE_PATH . $pageDeleteUrl . "'>Delete Page</a></li>";
    echo "    </ul>";
    echo "</div>";
    echo "</td>";

    // Page URL clipboard input and button
    echo "<td class='vert-align'>";
    echo "<div class='btn-group'>";
    echo "    <button type='button' class='btn btn-primary dropdown-toggle'";
    echo "            data-toggle='dropdown'";
    echo "            aria-haspopup='true' aria-expanded='false'>";
    echo "        URL <span class='caret'></span>";
    echo "    </button>";
    echo "    <ul class='dropdown-menu'>";
    echo "        <li><a class='url' data-row='" . $rowNumber . "' href='" . $urlBase . $pageUrl . "'>Page</a></li>";
    echo "        <li><a class='url' data-row='" . $rowNumber . "' href='" . $urlBase . $slidesUrl . "'>Slides</a></li>";
    // echo "        <li><a class='url' href=''>PDF</a></li>";
    echo "    </ul>";
    echo "</div>";
    echo "</td>";
    echo "<td>";
    echo "<div class='input-group'>";
    echo "    <input id='pageUrl" . $rowNumber . "' type='text' class='form-control' data-auto-select='true'>";
    echo "    <span class='input-group-btn'>";
    echo "        <button class='btn btn-default copyable' type='button' data-clipboard-target='#pageUrl" . $rowNumber . "'>Copy</button>";
    echo "    </span>";
    echo "</div>";
    echo "</td>";

    echo "</tr>";
}
?>
        </tbody>
    </table>
</div>
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="<?php echo BASE_PATH;?>/public_html/js/clipboard.min.js"></script>
<script src="<?php echo BASE_PATH;?>/public_html/js/phpmdadmin.js"></script>
<script>
    $(function() {

        // Wire the URL dropdown link options to the inputs
        $('.url').click(function(e) {
            e.preventDefault();
            var inputId = 'pageUrl' + $(this).data('row');
            $('#' + inputId).attr('value', $(this).attr('href'));
        });

        // Add the clipboard functionality to the inputs
        var clipboard = new Clipboard('.copyable');
        $("input[data-auto-select=true]").click(function() {
            $(this).select();
        });

        // Fix the dropdown when in responsive mode
        $('.table-responsive').on('shown.bs.dropdown', function(e) {
            var $table = $(this),
                $menu = $(e.target).find('.dropdown-menu'),
                tableOffsetHeight = $table.offset().top + $table.height(),
                menuOffsetHeight = $menu.offset().top + $menu.outerHeight(true);

            if (menuOffsetHeight > tableOffsetHeight)
                $table.css("padding-bottom", menuOffsetHeight - tableOffsetHeight);
        });

        $('.table-responsive').on('hide.bs.dropdown', function() {
            $(this).css("padding-bottom", 0);
        })

        // $('.delete').click(function(e) {
        //     e.preventDefault();
        //     var action = $(this).attr("href");
        //     post(action, {
        //         group: $(this).data("group"),
        //         file: $(this).data("file"),
        //     });
        // });
    });
</script>
