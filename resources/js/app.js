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
    isAddModalOpen: false,
    isEditModalOpen: false,
    trapCleanup: null,
    openModal() {
      this.isModalOpen = true
      this.trapCleanup = focusTrap(document.querySelector('#modal'))
    },
    closeModal() {
      this.isModalOpen = false
      this.trapCleanup()
    },
    openAddModal() {
      this.isAddModalOpen = true
      this.trapCleanup = focusTrap(document.querySelector('#modal'))
    },
    closeAddModal() {
      this.isAddModalOpen = false
      this.trapCleanup()
    },
    openEditModal() {
      this.isEditModalOpen = true
      this.trapCleanup = focusTrap(document.querySelector('#modal'))
    },
    closeEditModal() {
      this.isEditModalOpen = false
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