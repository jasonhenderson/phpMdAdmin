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
    <div class="col-md-4 col-md-offset-8">
        <form class="form-inline" action="<?php echo BASE_PATH?>/api/createGroup" method="POST">
            <div class="form-group">
                <!--<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>-->
                <label class="sr-only" for="group">Create New Group</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="New Group Name" id="group" name="group">
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
                <th colspan="2">
                    Group Name
                </th>
            </tr>
        </thead>
        <tbody>
<?php
$rowNumber = 0;

foreach ($controller->groups as $group) {
    $groupName = $group["name"];
    $basePath = BASE_PATH;

    echo "<tr>";

    echo "<td class='vert-align'>";
    echo $groupName;
    echo "</td>";


    echo "<td class='vert-align'>";
    echo "<a href='$basePath/files/$groupName' class='btn btn-primary' role='button'>Manage Files</a>";
    echo "&nbsp;";
    echo "<a href='$basePath/assets/$groupName' class='btn btn-primary' role='button'>Manage Assets</a>";
    echo "&nbsp;";
    echo "<a href='$basePath/api/removeGroup/$groupName' class='btn btn-danger' role='button'>Remove Group</a>";
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
