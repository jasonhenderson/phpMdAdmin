<?php
/**
 * /home/ubuntu/workspace/phpMdAdmin/public_html/views/md/slideViewer.php
 *
 * @package phpMdAdmin
 */


// Reference global controller
?>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH?>/public_html/css/remark.css">
<textarea id="source">

<?php
echo $controller->markdown;
?>
</textarea>
<script src="https://code.jquery.com/jquery-3.1.0.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/remark/0.14.0/remark.min.js"></script>
<script>
    $(function() {
    var slideshow = remark.create({
        // highlightLanguage: 'javascript',
        highlightStyle : 'solarized-dark',

        ratio: '22:17', // Letter

        // Navigation options
        navigation: {
            // Enable or disable navigating using scroll
            // Default: true
            // Alternatives: false
            scroll: false,

            // Enable or disable navigation using touch
            // Default: true
            // Alternatives: false
            touch: true,

            // Enable or disable navigation using click
            // Default: false
            // Alternatives: true
            click: true
        },

        // Customize slide number label, either using a format string..
        slideNumberFormat: 'Slide %current% of %total%',

        // .. or by using a format function
        slideNumberFormat: function (current, total) {
            return 'Slide ' + current + ' of ' + total;
        },

        // Enable or disable counting of incremental slides in the slide counting
        countIncrementalSlides: true
    });
    });
</script>
