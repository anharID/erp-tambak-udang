import "./bootstrap";


import Alpine from "alpinejs";

window.Alpine = Alpine;

window.data = () => {
    function getThemeFromLocalStorage() {
      // if user already changed the theme, use it
      if (window.localStorage.getItem('dark')) {
        return JSON.parse(window.localStorage.getItem('dark'))
      }
  
      // else return their preferences
      return (
        !!window.matchMedia &&
        window.matchMedia('(prefers-color-scheme: dark)').matches
      )
    }
  
    function setThemeToLocalStorage(value) {
      window.localStorage.setItem('dark', value)
    }
  
    return {
      dark: getThemeFromLocalStorage(),
      toggleTheme() {
        this.dark = !this.dark
        setThemeToLocalStorage(this.dark)
      },
      isSideMenuOpen: false,
      toggleSideMenu() {
        this.isSideMenuOpen = !this.isSideMenuOpen
      },
      closeSideMenu() {
        this.isSideMenuOpen = false
      },
      isNotificationsMenuOpen: false,
      toggleNotificationsMenu() {
        this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
      },
      closeNotificationsMenu() {
        this.isNotificationsMenuOpen = false
      },
      isProfileMenuOpen: false,
      toggleProfileMenu() {
        this.isProfileMenuOpen = !this.isProfileMenuOpen
      },
      closeProfileMenu() {
        this.isProfileMenuOpen = false
      },
      isPagesMenuOpen: false,
      togglePagesMenu() {
        this.isPagesMenuOpen = !this.isPagesMenuOpen
      },
      // Modal
      isModalOpen: false,
      trapCleanup: null,
      openModal() {
        this.isModalOpen = true
        this.trapCleanup = focusTrap(document.querySelector('#modal'))
      },
      closeModal() {
        this.isModalOpen = false
        this.trapCleanup()
      },
    }
  }
Alpine.start();
  

$(window).ready(function () {
    $(".datatable").DataTable({
        order: [],
        // scrollX: true,
        bAutoWidth: false,
        initComplete: function (settings, json) {  
          $(".datatable").wrap("<div style='overflow:auto; width:100%;position:relative;'></div>");            
        },
    }).columns.adjust();
});


// const jenisTransaksi = document.getElementById("jenis_transaksi");
// const keteranganField = document.getElementById("keterangan_field");
// const karyawanField = document.getElementById("karyawan_field");

// keteranganField.style.display =
//     jenisTransaksi.value === "Gaji Karyawan" ? "none" : "block";
// karyawanField.style.display =
//     jenisTransaksi.value === "Gaji Karyawan" ? "block" : "none";

// jenisTransaksi.addEventListener("change", () => {
//     keteranganField.style.display =
//         jenisTransaksi.value === "Gaji Karyawan" ? "none" : "block";
//     karyawanField.style.display =
//         jenisTransaksi.value === "Gaji Karyawan" ? "block" : "none";
//     // keterangan.removeAttribute('required');
// });

// const selectKaryawan = document.getElementById("karyawan");
// const inputJumlah = document.getElementById("jumlah");
// const inputKeterangan = document.getElementById("keterangan");

// selectKaryawan.addEventListener("change", () => {
//     const selectedOption = selectKaryawan.options[selectKaryawan.selectedIndex];
//     const gaji = selectedOption.getAttribute("gaji");
//     inputJumlah.value = gaji;
//     const nama = selectedOption.getAttribute("nama");
//     inputKeterangan.value = nama;
// });
