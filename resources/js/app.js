import "./bootstrap";


import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

$(window).ready(function () {
    $(".datatable").DataTable({
        order: [],
        scrollX: true,
        bAutoWidth: false,
    }).columns.adjust();
});


const jenisTransaksi = document.getElementById("jenis_transaksi");
const keteranganField = document.getElementById("keterangan_field");
const karyawanField = document.getElementById("karyawan_field");

keteranganField.style.display =
    jenisTransaksi.value === "Gaji Karyawan" ? "none" : "block";
karyawanField.style.display =
    jenisTransaksi.value === "Gaji Karyawan" ? "block" : "none";

jenisTransaksi.addEventListener("change", () => {
    keteranganField.style.display =
        jenisTransaksi.value === "Gaji Karyawan" ? "none" : "block";
    karyawanField.style.display =
        jenisTransaksi.value === "Gaji Karyawan" ? "block" : "none";
    // keterangan.removeAttribute('required');
});

const selectKaryawan = document.getElementById("karyawan");
const inputJumlah = document.getElementById("jumlah");
const inputKeterangan = document.getElementById("keterangan");

selectKaryawan.addEventListener("change", () => {
    const selectedOption = selectKaryawan.options[selectKaryawan.selectedIndex];
    const gaji = selectedOption.getAttribute("gaji");
    inputJumlah.value = gaji;
    const nama = selectedOption.getAttribute("nama");
    inputKeterangan.value = nama;
});
