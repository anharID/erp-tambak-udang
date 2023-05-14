          <!-- Desktop sidebar -->
          <aside class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
              <div class="py-4 text-gray-500 dark:text-gray-400">
                  <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
                      ERP
                  </a>
                  <ul class="mt-6">
                      <li class="relative px-6 py-3">
                          {{-- <span
                    class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"
                  ></span> --}}
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200  {{ Request::is('dashboard') ? 'text-gray-800 dark:text-gray-100' : '' }}"
                              href="{{ route('dashboard') }}">
                              <span class="ml-4">Dashboard</span>
                          </a>
                      </li>
                  </ul>
                  <ul>
                      <li class="relative px-6 py-3">
                          <a class="{{ request()->routeIs('users.index') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 "
                              href="{{ route('users.index') }}">
                              <span class="ml-4">Manajemen Akun</span>
                          </a>
                      </li>
                      <li class="relative px-6 py-3">
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                              href="">
                              <span class="ml-4">Manajemen Karyawan</span>
                          </a>
                      </li>
                      <li class="relative px-6 py-3">
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                              href="">
                              <span class="ml-4">Manajemen Finansial</span>
                          </a>
                      </li>
                      <li class="relative px-6 py-3">
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                              href="">
                              <span class="ml-4">Manajemen Inventaris</span>
                          </a>
                      </li>
                      <li class="relative px-6 py-3">
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                              href="modals.html">
                              <span class="ml-4">Manajemen Tambak Udang</span>
                          </a>
                      </li>
                      <li class="relative px-6 py-3">
                          <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                              href="">
                              <span class="ml-4">Manajemen Peralatan</span>
                          </a>
                      </li>
                  </ul>
              </div>
          </aside>
          <!-- Mobile sidebar -->

          <!-- Backdrop -->
          <div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
              x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
              x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0"
              class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>

          <aside
              class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
              x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
              x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
              x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0 transform -translate-x-20" <blade
              click|.away%3D%26%2334%3BcloseSideMenu%26%2334%3B%0D>
              @keydown.escape="closeSideMenu"
                  >
                  <div class="py-4 text-gray-500 dark:text-gray-400">
                      <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="#">
                          ERP
                      </a>
                      <ul class="mt-6">
                          <li class="relative px-6 py-3">
                              {{-- <span
                    class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
                    aria-hidden="true"
                  ></span> --}}
                              <a class="{{ Request::is('dashboard') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold text-gray-800 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200 dark:text-gray-100"
                                  href="{{ route('dashboard') }}">
                                  <span class="ml-4">Dashboard</span>
                              </a>
                          </li>
                      </ul>
                      <ul>
                          <li class="relative px-6 py-3">
                              <a class="{{ request()->routeIs('users.index') ? 'text-gray-800 dark:text-gray-100' : '' }} inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                  href="{{ route('users.index') }}">
                                  <span class="ml-4">Manajemen User</span>
                              </a>
                          </li>
                          <li class="relative px-6 py-3">
                              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                  href="cards.html">
                                  <span class="ml-4">Manajemen Karyawan</span>
                              </a>
                          </li>
                          <li class="relative px-6 py-3">
                              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                  href="charts.html">
                                  <span class="ml-4">Manajemen Finansial</span>
                              </a>
                          </li>
                          <li class="relative px-6 py-3">
                              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                  href="buttons.html">
                                  <span class="ml-4">Manajemen Inventaris</span>
                              </a>
                          </li>
                          <li class="relative px-6 py-3">
                              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                  href="modals.html">
                                  <span class="ml-4">Manajemen Tambak Udang</span>
                              </a>
                          </li>
                          <li class="relative px-6 py-3">
                              <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                                  href="tables.html">
                                  <span class="ml-4">Manajemen Peralatan</span>
                              </a>
                          </li>
                      </ul>
                  </div>
          </aside>
