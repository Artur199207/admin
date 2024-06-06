// "use strict"
// document.addEventListener('DOMContentLoaded', function () {
//     const form = document.getElementById('form');
//     form.addEventListener('submit', formSend);


//     async function formSend(e) {
//         e.preventDefault();

//         let error = formValidate(form);
//     }


//     function formValidate(form) {
//         let error = 0;
//         let formReq = document.querySelectorAll('._req');
//         for (let index = 0; index < formReq.lenght; index++) {
//             const input = formReq[index];
//             formRemoveError(input);

//             if (input.classList.contains('_email')) {
//                 if (emailTest(input)) {
//                     formAddError(input);
//                     error++;
//                 } else if (input.getAttribute('type') === 'checkbox' && input.checked === false) {
//                     formAddError(input);
//                     error++;
//                 } else {
//                     if (input.value === "") {
//                         formAddError(input);
//                         error++;
//                     }
//                 }
//             }
//         }
//     }



//     function formAddError(input) {
//         input.parentElement.classList.add('_error');
//         input.classList.add('_error');
//     }
//     function formRemoveError(input) {
//         input.parentElement.classList.remove('_error');
//         input.classList.remove('_error');
//     }


//     function emailTest(input) {
//         return !/^\w+([\.-]?w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.text(input.value)
//     }
// })

"use strict"
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form');
    form.addEventListener('submit', formSend);

    async function formSend(e) {
        e.preventDefault();

        let error = formValidate(form);
        let formData = new FormData(form);
        formData.append('image', formImage.files[0]);
        // You can handle the error here, for example:
        if (error === 0) {
            form.classList.add('_sending');
            let response = await fetch('sendmail.php', {
                method: 'POST',
                body: formData
            });
            if (response.ok) {
                let result = await response.json();
                alert(result.message);
                formPreview.innerHTML = "";
                form.reset();
                form.classList.remove('_sending');
            } else {
                alert('error');
                form.classList.remove('_sending');
            }
        } else {
            alert('create name and email')
        }
    }

    function formValidate(form) {
        let error = 0;
        let formReq = document.querySelectorAll('._req');
        for (let index = 0; index < formReq.length; index++) { // corrected length
            const input = formReq[index];
            formRemoveError(input);

            if (input.classList.contains('_email')) {
                if (emailTest(input)) {
                    formAddError(input);
                    error++;
                }
            } else if (input.getAttribute('type') === 'checkbox' && input.checked === false) { // moved outside the _email check
                formAddError(input);
                error++;
            } else {
                if (input.value === "") {
                    formAddError(input);
                    error++;
                }
            }
        }
        return error; // return the error count
    }

    function formAddError(input) {
        input.parentElement.classList.add('_error');
        input.classList.add('_error');
    }

    function formRemoveError(input) {
        input.parentElement.classList.remove('_error');
        input.classList.remove('_error');
    }

    function emailTest(input) {
        return !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,8})+$/.test(input.value); // corrected to .test
    }


    const formImage = document.getElementById('formImage'); // Corrected ID
    const formPreview = document.getElementById('formPrevew'); // Corrected ID

    formImage.addEventListener('change', () => {
        uploadFile(formImage.files[0]);
    });

    function uploadFile(file) {
        // Validate file type
        if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
            alert('Invalid file type. Only JPEG, PNG, and GIF are allowed.');
            formImage.value = '';
            return;
        }
        // Validate file size
        if (file.size > 2 * 1024 * 1024) {
            alert('File is too large. Maximum size is 2MB.');
            formImage.value = '';
            return;
        }

        // Show the preview
        let reader = new FileReader();
        reader.onload = function (e) {
            formPreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

});

