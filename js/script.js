
function submitForm() {
    document.getElementById("uploadForm").submit();
}

// Get the message div
var messageDiv = document.querySelector('.top-right');

// Hide the message div after 5 seconds
setTimeout(function () {
    messageDiv.style.display = 'none';
}, 5000); // 5000 milliseconds = 5 seconds

// document.addEventListener('DOMContentLoaded', function () {
//     var fileRows = document.querySelectorAll('.file-name');

//     fileRows.forEach(function (row) {
//         row.addEventListener('click', function () {
//             var filePath = this.getAttribute('data-filepath');

//             fetch(filePath)
//                 .then(response => response.text())
//                 .then(data => {
//                     var preview = document.getElementById('filePreview');
//                     preview.textContent = data;
//                     preview.style.display = 'block';
//                 })
//                 .catch(error => {
//                     console.error('Error:', error);
//                 });
//         });
//     });
// });