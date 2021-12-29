const authorSelect = $('[name="author"]');
const authorNameInput = $('[name="author_name"]');

if (authorSelect.length > 0) {
    toggleAuthorNameInput(authorSelect.children("option:selected").val());
}

authorSelect.on('change', function (e) {
    const $this = $(e.target);

    toggleAuthorNameInput ($this.val());
});

function toggleAuthorNameInput(value) {    
    if (value === 'static') {
        authorNameInput.attr('disabled', false).show();
    } else {
        authorNameInput.attr('disabled', true).hide();
    }
}