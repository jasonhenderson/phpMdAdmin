$(document).ready(function() {
    $('textarea').keydown(function() {
        flagChanged(this);
    });

    $('textarea').change(function() {
        flagChanged(this);
    });

    // Disable the default
    $(document).bind('keydown', function(e) {
        if (e.metaKey && e.keyCode == 83) {
            e.preventDefault();
            $("#saveForm").submit();
        }
    });
});

function flagChanged(self) {
    if (!self.changed) {
        $('[data-toggle=confirmation]').confirmation({
          rootSelector: '[data-toggle=confirmation]',
          // other options
        });
    }
    self.changed = true;
    $('#cancelButton').html("Cancel");
}
