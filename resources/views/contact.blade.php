<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <style>
        /* Apply the background to the entire page */
        body {
            background-image: url("{{ asset('images/background.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            overflow-x: hidden;
        }
        .rotate-180 {
            transform: rotate(180deg);
        }

        /* Header - kembali ke versi original dengan background transparan */
        header {
            position: absolute;
            top: 0;
            width: 100%;
            z-index: 1000;
            background: transparent;
        }

        /* Mobile Menu Overlay */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Mobile Menu Slide */
        .mobile-menu-slide {
            position: fixed;
            top: 0;
            right: -100%;
            width: 280px;
            height: 100vh;
            background-color: white;
            z-index: 9999;
            transition: right 0.3s ease;
            overflow-y: auto;
            padding: 20px 0;
        }

        .mobile-menu-slide.active {
            right: 0;
        }

        /* Close button */
        .close-menu-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #333;
        }

        /* Menu items styling */
        .mobile-menu-item {
            display: block;
            padding: 15px 25px;
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s ease;
        }

        .mobile-menu-item:hover {
            background-color: #f8f9fa;
            color: #007bff;
            text-decoration: none;
        }

        /* Dropdown styling for mobile */
        .mobile-dropdown {
            background-color: #f8f9fa;
        }

        .mobile-dropdown-item {
            display: block;
            padding: 12px 40px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            border-bottom: 1px solid #e9ecef;
        }

        .mobile-dropdown-item:hover {
            background-color: #e9ecef;
            color: #007bff;
            text-decoration: none;
        }

        /* Arrow rotation */
        .dropdown-arrow {
            transition: transform 0.2s ease;
        }

        .dropdown-arrow.rotate {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="font-sans antialiased bg-transparent">
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>

    <!-- Mobile Menu Slide -->
    <div class="mobile-menu-slide" id="mobile-menu-slide">
        <button class="close-menu-btn" id="close-menu-btn">
            <i class="fas fa-times"></i>
        </button>
        
        <div style="margin-top: 60px;">
            <!-- Our Business Dropdown -->
            <div>
                <a href="#" class="mobile-menu-item flex justify-between items-center" id="mobile-business-toggle">
                    Our Business
                    <i class="fas fa-chevron-down dropdown-arrow" id="mobile-business-arrow"></i>
                </a>
                <div class="mobile-dropdown hidden" id="mobile-business-dropdown">
                    @foreach($navigationSpbus as $navSpbu)
                        <a href="{{ route('spbu.show', $navSpbu->slug) }}" class="mobile-dropdown-item">
                            SPBU {{ $navSpbu->code }} {{ strtoupper($navSpbu->name) }}
                        </a>
                    @endforeach
                </div>
            </div>
            
            <!-- Other Menu Items -->
            <a href="{{ route('aboutus') }}" class="mobile-menu-item">About Us</a>
            <a href="{{ route('career') }}" class="mobile-menu-item">Career</a>
            <a href="{{ route('news.index') }}" class="mobile-menu-item">News</a>
            <a href="{{ route('contact') }}" class="mobile-menu-item">Contact</a>
        </div>
    </div>

    <!-- Header - Kembali ke versi original -->
    <header class="absolute top-0 left-0 w-full z-50 bg-transparent bg-opacity-0">
        <div class="container mx-auto flex items-center justify-between py-4 px-6 md:px-16">
            <!-- Logo dan Nama Perusahaan -->
            <div class="flex items-center space-x-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="h-10">
                </a>
                <span class="text-xl font-bold text-black">PT. SIDOREJO MAKMUR SEJAHTERA</span>
            </div>

            <!-- Navigation -->
            <nav class="hidden md:flex items-center gap-x-6">
                <!-- Dropdown menu Our Business -->
                <div class="relative" x-data="{ open: false }">
                    <a href="#" @click.prevent="open = !open" class="text-black hover:text-blue-500 flex items-center">
                        Our Business
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" :class="{'rotate-180': open}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </a>
                    
                    <!-- Dropdown items -->
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" 
                        x-transition:enter-start="transform opacity-0 scale-95" 
                        x-transition:enter-end="transform opacity-100 scale-100" 
                        x-transition:leave="transition ease-in duration-75" 
                        x-transition:leave-start="transform opacity-100 scale-100" 
                        x-transition:leave-end="transform opacity-0 scale-95" 
                        class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                        
                        @foreach($navigationSpbus as $navSpbu)
                            <a href="{{ route('spbu.show', $navSpbu->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-500 hover:text-black">
                                SPBU {{ $navSpbu->code }} {{ strtoupper($navSpbu->name) }}
                            </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Other navigation items -->
                <a href="{{ route('aboutus') }}" class="text-black hover:text-blue-500">About Us</a>
                <a href="{{ route('career') }}" class="text-black hover:text-blue-500">Career</a>
                <a href="{{ route('news.index') }}" class="text-black hover:text-blue-500">News</a>
                <a href="{{ route('contact') }}" class="text-black hover:text-blue-500">Contact</a>
            </nav>

            <!-- Hamburger Menu Button (Mobile) -->
            <button id="menu-toggle" class="md:hidden text-black focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </header>
    <main>
        <!-- Kontak Kami Section -->
        <section class="py-28 bg-gray-100">
            <div class="container mx-auto px-8">
                <h2 class="text-3xl font-bold text-center mb-8">Kontak Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Form Kontak -->
                    <div class="bg-white p-8 rounded-lg shadow-lg">
                        <form id="contactForm">
                            @csrf
                            <div class="mb-4">
                                <label for="first_name" class="block text-sm font-medium text-gray-700">Nama Depan</label>
                                <input type="text" id="first_name" name="first_name"
                                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                            </div>
                            <div class="mb-4">
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Nama Belakang</label>
                                <input type="text" id="last_name" name="last_name"
                                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email"
                                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                            </div>
                            <div class="mb-4">
                                <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                                <textarea id="message" name="message" rows="5"
                                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required></textarea>
                            </div>
                            <button type="submit"
                                class="bg-[#816C6B] text-white px-4 py-2 rounded-md hover:bg-[#6B5A59]" id="submitBtn">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>

                    <!-- Maps & Info Kontak -->
                    <div class="bg-white p-8 rounded-lg shadow-lg">
                        <h3 class="text-xl font-bold mb-4">Lokasi Kami</h3>
                        <div class="mb-4">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3959.8772077724852!2d110.50436971165038!3d-7.023716992948684!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708d905c79c5c1%3A0xba33c5d46766c340!2sSPBU%20Bandungrejo!5e0!3m2!1sen!2sid!4v1740559647732!5m2!1sen!2sid"
                                width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade" class="rounded-lg"></iframe>
                        </div>
                        <h3 class="text-xl font-bold mb-4">Informasi Kontak</h3>
                        <p class="text-sm text-gray-700 mb-2">
                            <strong>Alamat:</strong> Jl. Raya Semarang - Demak No. Km. 13, Bandungrjeo, Kec. Mranggen, Kabupaten
                            Demak, Jawa Tengah 59567
                        </p>
                        <p class="text-sm text-gray-700 mb-2">
                            <strong>Telepon:</strong> 0246773068
                        </p>
                        <p class="text-sm text-gray-700 mb-2">
                            <strong>Email:</strong> spbu4459518@gmail.com
                        </p>
                    </div>

                </div>
            </div>
        </section>  
    </main>

    <!-- Footer -->
    <footer class="bg-[#816C6B] text-white py-8 md:py-12">
        <div class="container mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 lg:col-span-1">
                    <div class="flex flex-col items-start">
                        <div class="flex items-center space-x-3 mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="Company Logo" class="h-10 md:h-12 w-auto">
                            <span class="text-lg md:text-xl font-bold text-white">PT. SIDOREJO MAKMUR SEJAHTERA</span>
                        </div>
                        <p class="text-sm leading-relaxed text-gray-300 mb-4">
                            PT SIDOREJO MAKMUR SEJAHTERA adalah perusahaan yang bergerak dalam bidang migas dan retail.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-white hover:text-yellow-400 transition-colors"><i class="fab fa-instagram text-xl"></i></a>
                            <a href="#" class="text-white hover:text-yellow-400 transition-colors"><i class="fab fa-linkedin text-xl"></i></a>
                            <a href="#" class="text-white hover:text-yellow-400 transition-colors"><i class="fab fa-facebook text-xl"></i></a>
                        </div>
                    </div>
                </div>

                <!-- About Us Section -->
                <div class="col-span-1">
                    <h3 class="font-semibold text-lg mb-4">About Us</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('aboutus') }}" class="text-gray-300 hover:text-white transition-colors">Profile</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Visi & Misi</a></li>
                    </ul>
                </div>

                <!-- Business Section -->
                <div class="col-span-1">
                    <h3 class="font-semibold text-lg mb-4">Our Business</h3>
                    <ul class="space-y-2">
                        @foreach($allSpbus as $footerSpbu)
                            <li>
                                <a href="{{ route('spbu.show', $footerSpbu->slug) }}" 
                                class="text-gray-300 hover:text-white transition-colors {{ 
                                    request()->route('slug') === $footerSpbu->slug ? 'text-white font-bold' : '' 
                                }}">
                                    SPBU {{ $footerSpbu->code }} {{ $footerSpbu->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact Section -->
                <div class="col-span-1">
                    <h3 class="font-semibold text-lg mb-4">Contact</h3>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-map-marker-alt text-yellow-400 mt-1 flex-shrink-0"></i>
                            <p class="text-sm text-gray-300 leading-relaxed">
                                Jl. Raya Semarang - Demak No. Km. 13, Bandungrjeo, Kec. Mranggen, Kabupaten Demak, Jawa Tengah 59567
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-phone text-yellow-400 flex-shrink-0"></i>
                            <p class="text-sm text-gray-300">+62 8123-2321-1234</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-envelope text-yellow-400 flex-shrink-0"></i>
                            <p class="text-sm text-gray-300">spbu4459518@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-gray-600 mt-8 pt-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-sm text-gray-300 mb-4 md:mb-0">&copy; 2025 PT Sidorejo Makmur Sejahtera. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script AOS dan Typed.js -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const menuToggle = document.getElementById("menu-toggle");
            const mobileMenuSlide = document.getElementById("mobile-menu-slide");
            const mobileMenuOverlay = document.getElementById("mobile-menu-overlay");
            const closeMenuBtn = document.getElementById("close-menu-btn");
            const businessToggle = document.getElementById("mobile-business-toggle");
            const businessDropdown = document.getElementById("mobile-business-dropdown");
            const businessArrow = document.getElementById("mobile-business-arrow");

            // Open mobile menu
            menuToggle.addEventListener("click", function () {
                mobileMenuSlide.classList.add("active");
                mobileMenuOverlay.classList.add("active");
                document.body.style.overflow = "hidden"; // Prevent scrolling
            });

            // Close mobile menu function
            function closeMobileMenu() {
                mobileMenuSlide.classList.remove("active");
                mobileMenuOverlay.classList.remove("active");
                document.body.style.overflow = "auto"; // Restore scrolling
                
                // Reset dropdown
                businessDropdown.classList.add("hidden");
                businessArrow.classList.remove("rotate");
            }

            // Close menu when clicking close button
            closeMenuBtn.addEventListener("click", closeMobileMenu);

            // Close menu when clicking overlay
            mobileMenuOverlay.addEventListener("click", closeMobileMenu);

            // Toggle business dropdown in mobile menu
            businessToggle.addEventListener("click", function(e) {
                e.preventDefault();
                businessDropdown.classList.toggle("hidden");
                businessArrow.classList.toggle("rotate");
            });

            // Close menu when clicking on menu items (except dropdown toggle)
            const menuItems = document.querySelectorAll('.mobile-menu-item:not(#mobile-business-toggle), .mobile-dropdown-item');
            menuItems.forEach(item => {
                item.addEventListener('click', closeMobileMenu);
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleDropdown(event) {
            event.preventDefault();
            const container = event.currentTarget.closest('.dropdown-container');
            const dropdown = container.querySelector('.dropdown-menu');
            const arrow = container.querySelector('.dropdown-arrow');
            
            dropdown.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function closeDropdown(e) {
                if (!container.contains(e.target)) {
                    dropdown.classList.add('hidden');
                    arrow.classList.remove('rotate-180');
                    document.removeEventListener('click', closeDropdown);
                }
            });
        }
    </script>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function (e) {
            e.preventDefault();

            let form = e.target;
            let submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;  // Disable the button during submission
            submitBtn.innerHTML = 'Mengirim... <i class="animate-spin fas fa-spinner"></i>'; // Show loading spinner

            fetch("{{ route('contact.submit') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        first_name: document.getElementById('first_name').value,
                        last_name: document.getElementById('last_name').value,
                        email: document.getElementById('email').value,
                        message: document.getElementById('message').value
                    }),
                })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    confirmButtonText: 'OK'
                });
                form.reset();
                submitBtn.disabled = false;  // Enable button again
                submitBtn.innerHTML = "Kirim Pesan"; // Reset button text
            })
            .catch(error => {
                let message = 'Terjadi kesalahan.';

                if (error.errors) {
                    message = Object.values(error.errors).flat().join('\n');
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: message,
                    confirmButtonText: 'OK'
                });
                submitBtn.disabled = false;  // Enable button again
                submitBtn.innerHTML = "Kirim Pesan"; // Reset button text
            });
        });
    </script>
</body>
</html>
