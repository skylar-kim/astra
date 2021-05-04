document.querySelector('form').onsubmit = function(){
    if ( document.querySelector('#username-id').value.trim().length == 0 ) {
        document.querySelector('#username-id').classList.add('is-invalid');
    } else {
        document.querySelector('#username-id').classList.remove('is-invalid');
    }

    if ( document.querySelector('#email-id').value.trim().length == 0 ) {
        document.querySelector('#email-id').classList.add('is-invalid');
    } else {
        document.querySelector('#email-id').classList.remove('is-invalid');
    }

    if ( document.querySelector('#password-id').value.trim().length == 0 ) {
        document.querySelector('#password-id').classList.add('is-invalid');
    } else {
        document.querySelector('#password-id').classList.remove('is-invalid');
    }

    return ( !document.querySelectorAll('.is-invalid').length > 0 );


}