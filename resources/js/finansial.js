const jenisTransaksi = document.getElementById("jenis_transaksi");
const keteranganField = document.getElementById("keterangan_field");
const karyawanField = document.getElementById("karyawan_field");
const kolamField = document.getElementById("kolam_field");

keteranganField.style.display =
    jenisTransaksi.value === "Gaji Karyawan" || jenisTransaksi.value === "Penjualan Udang"
      ? "none" : "block";
karyawanField.style.display =
    jenisTransaksi.value === "Gaji Karyawan" ? "block" : "none";
kolamField.style.display =
    jenisTransaksi.value === "Penjualan Udang" ? "block" : "none";

jenisTransaksi.addEventListener("change", () => {
    keteranganField.style.display =
    jenisTransaksi.value === "Gaji Karyawan" || jenisTransaksi.value === "Penjualan Udang"
      ? "none" : "block";
karyawanField.style.display =
    jenisTransaksi.value === "Gaji Karyawan" ? "block" : "none";
kolamField.style.display =
    jenisTransaksi.value === "Penjualan Udang" ? "block" : "none";
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

const selectKolam = document.getElementById("kolam");

selectKolam.addEventListener("change", () => {
    const selectedOption = selectKolam.options[selectKolam.selectedIndex];
    const nama = selectedOption.getAttribute("nama");
    inputKeterangan.value = `Kolam ${nama}`;
});

//  // Modal
// const openModalBtn = document.getElementById("openModalBtn");
// const closeModalBtn = document.getElementById("closeModalBtn");
// const modal = document.getElementById("modal");

// openModalBtn.addEventListener("click", () => {
//     console.log("test");
//     modal.classList.remove("hidden");
// });

// closeModalBtn.addEventListener("click", () => {
//     modal.classList.add("hidden");
// });
