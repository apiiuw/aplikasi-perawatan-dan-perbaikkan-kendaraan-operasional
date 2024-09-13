<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start rtl:justify-end">
          <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
              <span class="sr-only">Open sidebar</span>
              <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                 <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
              </svg>
           </button>
          <a href="#" class="flex ms-2 md:me-24">
            <img src="{{ asset('assets/Logo/Logo Jasa Raharja Utama dalam pelindungan, prima dalam pelayanan.png') }}" class="h-8 lg:h-10 me-3" alt="Jasa Raharja Logo" />
            <span class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap"></span>
          </a>
        </div>
        <div class="flex items-center">
            <div class="flex items-center ms-3">
              <div>
                <button type="button" class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300" aria-expanded="false" data-dropdown-toggle="dropdown-user">
                  <span class="sr-only">Open user menu</span>
                  <img class="w-8 h-8 rounded-full object-cover" src="{{ asset('assets/image/user_avatar/' . (auth()->user()->avatar ? auth()->user()->id . '/' . basename(auth()->user()->avatar) : 'default/default_user_profile.png')) }}" alt="user photo">
                </button>
              </div>
              <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow" id="dropdown-user">
               <div class="px-4 py-3" role="none">
                  <p class="text-sm text-gray-900" role="none">
                      {{ Auth::user()->nama_pengabiministrasi }}
                  </p>
                  <p class="text-sm font-medium text-blueJR truncate" role="none">
                      {{ Auth::user()->jabatan }}
                  </p>
              </div>              
                <ul class="py-1" role="none">
                  <li>
                     <form action="/identitas" method="GET" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <button type="submit" class="w-full text-left" role="menuitem">
                           Identitas
                        </button>
                     </form>
                  </li>
                  <li>
                     <form action="{{ route('logout') }}" method="POST" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-500" role="menuitem">
                           Keluar Akun
                        </button>
                     </form>
                  </li>                                 
                </ul>
              </div>
            </div>
          </div>
      </div>
    </div>
  </nav>
  
  <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0" aria-label="Sidebar">
     <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
        <ul class="space-y-2 font-medium">
           <li>
            <a href="/" class="flex items-center p-2 rounded-lg {{ $active === 'beranda' ? 'bg-gray-300 text-black' : 'text-gray-900 hover:bg-gray-200' }} group">     
                <svg class="w-5 h-5 transition duration-75 {{ $active === 'beranda' ? 'text-black' : 'text-gray-500 group-hover:text-black' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                    <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                    <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                </svg>
                <span class="ms-3 {{ $active === 'beranda' ? 'text-black' : '' }}">Beranda</span>
            </a>
           </li>
           <li>
            <a href="/referensi" class="flex items-center p-2 text-gray-900 rounded-lg {{ $active === 'referensi' ? 'bg-gray-300 text-black' : 'text-gray-900 hover:bg-gray-200' }} group">
                <i class="fa-solid fa-folder-open fa-lg transition duration-75 {{ $active === 'referensi' ? 'text-black' : 'text-gray-500 group-hover:text-black' }}"></i>
                <span class="flex-1 ms-3 whitespace-nowrap {{ $active === 'referensi' ? 'text-black' : '' }}">Referensi</span>
            </a>
        </li>        
           <li>
            <button type="button" class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-200" aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
               <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ $active === 'laporan.kategori' || $active === 'laporan.transaksi' ? 'text-black' : 'text-gray-500 group-hover:text-black' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                  <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
              </svg>
              <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap {{ $active === 'laporan.kategori' || $active === 'laporan.transaksi' ? 'text-black' : '' }}">Laporan</span>
              <svg class="w-3 h-3 {{ $active === 'laporan.kategori' || $active === 'laporan.transaksi' ? 'text-black' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
              </svg>              
            </button>
            <ul id="dropdown-example" class="hidden py-2 space-y-2">
                  <li>
                     <a href="/laporan/kategori" class="{{ $active === 'laporan.kategori' ? 'bg-gray-300 text-black' : 'text-gray-900 hover:bg-gray-200' }} flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group">Kategori</a>
                  </li>
                  <li>
                     <a href="/laporan/transaksi" class="{{ $active === 'laporan.transaksi' ? 'bg-gray-300 text-black' : 'text-gray-900 hover:bg-gray-200' }} flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group">Transaksi</a>
                  </li>
            </ul>
           </li>
           <li>
            <a href="/database/kendaraan" class="flex items-center p-2 text-gray-900 rounded-lg {{ $active === 'database.kendaraan' ? 'bg-gray-300 text-black' : 'text-gray-900 hover:bg-gray-200' }} group">
                <i class="fa-solid fa-car fa-lg transition duration-75 {{ $active === 'database.kendaraan' ? 'text-black' : 'text-gray-500 group-hover:text-black' }}"></i>
                <span class="flex-1 ms-3 whitespace-nowrap {{ $active === 'database.kendaraan' ? 'text-black' : '' }}">Database Kendaraan</span>
            </a>
            </li>
            <li>
                  <a href="/database/transaksi" class="flex items-center p-2 text-gray-900 rounded-lg {{ $active === 'database.transaksi' ? 'bg-gray-300 text-black' : 'text-gray-900 hover:bg-gray-200' }} group">
                     <i class="fa-solid fa-money-bills fa-lg transition duration-75 {{ $active === 'database.transaksi' ? 'text-black' : 'text-gray-500 group-hover:text-black' }}"></i>
                     <span class="flex-1 ms-3 whitespace-nowrap {{ $active === 'database.transaksi' ? 'text-black' : '' }}">Database Transaksi</span>
                  </a>
            </li>        
        </ul>
     </div>
  </aside>