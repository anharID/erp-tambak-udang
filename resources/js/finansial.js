const jenisTransaksi = document.getElementById("jenis_transaksi");
const keteranganField = document.getElementById("keterangan_field");
const karyawanField = document.getElementById("karyawan_field");
const kolamField = document.getElementById("kolam_field");
const selectKaryawan = document.getElementById("karyawan");
const inputJumlah = document.getElementById("jumlah");
const inputKeterangan = document.getElementById("keterangan");

keteranganField.style.display =
    jenisTransaksi.value === "Gaji Karyawan" ||
    jenisTransaksi.value === "Bonus Karyawan" ||
    jenisTransaksi.value === "Penjualan Udang"
        ? "none"
        : "block";
karyawanField.style.display =
    jenisTransaksi.value === "Gaji Karyawan" ||
    jenisTransaksi.value === "Bonus Karyawan"
        ? "block"
        : "none";
kolamField.style.display =
    jenisTransaksi.value === "Penjualan Udang" ? "block" : "none";

jenisTransaksi.addEventListener("change", () => {
    keteranganField.style.display =
        jenisTransaksi.value === "Gaji Karyawan" ||
        jenisTransaksi.value === "Bonus Karyawan" ||
        jenisTransaksi.value === "Penjualan Udang"
            ? "none"
            : "block";
    karyawanField.style.display =
        jenisTransaksi.value === "Gaji Karyawan" ||
        jenisTransaksi.value === "Bonus Karyawan"
            ? "block"
            : "none";
    kolamField.style.display =
        jenisTransaksi.value === "Penjualan Udang" ? "block" : "none";
    inputJumlah.value = "";
    inputKeterangan.value = "";
    // keterangan.removeAttribute('required');
});

selectKaryawan.addEventListener("change", () => {
    const selectedOption = selectKaryawan.options[selectKaryawan.selectedIndex];
    const gaji = selectedOption.getAttribute("gaji");
    const bonus = selectedOption.getAttribute("bonus");
    const nama = selectedOption.getAttribute("nama");
    if (jenisTransaksi.value === "Gaji Karyawan") {
        inputJumlah.value = gaji;
        inputKeterangan.value = `Gaji Karyawan - ${nama}`;
    } else if (jenisTransaksi.value === "Bonus Karyawan") {
        inputJumlah.value =  Math.round((bonus / 100) * keuntunganKotor);
        inputKeterangan.value = `Bonus Karyawan - ${nama}`;
    }
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
