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
<div style="height:0px;overflow:hidden">
    <form>
        <input type="file" id="fileInput" name="fileInput[]" multiple="true" />
    </form>
</div>

<div class="row">
    <div class="col-md-12">
        <a class="btn btn-action" href="<?php echo BASE_PATH?>/files/<?php echo $controller->group ?>" >
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <h3>1. Choose the files you want to upload</h3>
        <button class="btn btn-primary btn-xs picker" type="button">choose files</button>
    </div>
</div>

<div id="results"></div>

<div class="row">
    <div class="col-md-12">
        <h3>2. Upload the files</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-1">
        <button class="btn btn-success btn-xs uploader">Upload Files</button>
    </div>
    <div class="col-md-3">
        <div class="progress">
          <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
            60%
          </div>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script>
    $(function() {
        setProgress(0);

        $('#fileInput').change(function(e) {
            $('#results').empty();

            $.map(this.files, function(val) {
                $('#results')
                    .append($('<div>')
                        .html(val.name)
                    );
            });
        });

        $('.picker').click(function(e) {
            console.log(e);
            $("#fileInput").click();
        });

        $('.uploader').click(function(e) {
            setProgress(0);

            var formData = new FormData($('form')[0]);

            $.ajax({
                url: "<?php echo BASE_PATH?>/assets/upload/<?php echo $controller->group ?>",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                mimeType:"multipart/form-data",
                cache: false,
                xhr: function(){
                    //upload Progress
                    var xhr = $.ajaxSettings.xhr();
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', function(event) {
                            var percent = 0;
                            var position = event.loaded || event.position;
                            var total = event.total;
                            if (event.lengthComputable) {
                                percent = Math.ceil(position / total * 100);
                            }
                            //update progressbar
                            setProgress(percent);
                        }, true);
                    }
                    return xhr;
                }
            })
            .done(function(data) {
                console.log('upload done');
                window.location.href = "<?php echo BASE_PATH?>/files/<?php echo $controller->group ?>";
                console.log(data);
            })
            .fail(function(xhr) {
                console.log('upload failed');
                console.log(xhr);
            })
            .always(function() {
                //console.log('done processing upload');
            });
        });

        function setProgress(percent) {
            $(".progress-bar").css("width", + percent +"%");
            $(".progress-bar").text(percent +"%");
        }
    });

</script>
