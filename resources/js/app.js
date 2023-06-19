import "./bootstrap";


import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

$(window).ready(function () {
    $(".datatable").DataTable({
        order: [],
        scrollX: true,
        bAutoWidth:false,
    });
});