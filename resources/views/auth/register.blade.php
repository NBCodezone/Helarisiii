<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Create Account</h2>
        <p class="text-gray-500">Join Helarisi today and start shopping</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                    class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-helarisi-teal focus:ring focus:ring-helarisi-teal focus:ring-opacity-50 transition duration-150 py-3">
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                    class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-helarisi-teal focus:ring focus:ring-helarisi-teal focus:ring-opacity-50 transition duration-150 py-3">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-helarisi-teal focus:ring focus:ring-helarisi-teal focus:ring-opacity-50 transition duration-150 py-3">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirm Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-helarisi-teal focus:ring focus:ring-helarisi-teal focus:ring-opacity-50 transition duration-150 py-3">
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Terms and Conditions -->
        <div class="flex items-start">
            <div class="flex items-center h-5">
                <input id="terms" type="checkbox" required class="rounded border-gray-300 text-helarisi-teal shadow-sm focus:ring-helarisi-teal">
            </div>
            <div class="ml-3 text-sm">
                <label for="terms" class="text-gray-600">
                    I agree to the <a href="#" onclick="openModal('termsModal'); return false;" class="text-helarisi-teal hover:text-helarisi-teal-dark font-semibold underline">Terms and Conditions</a> and <a href="#" onclick="openModal('privacyModal'); return false;" class="text-helarisi-teal hover:text-helarisi-teal-dark font-semibold underline">Privacy Policy</a>
                </label>
            </div>
        </div>

        <!-- Register Button -->
        <button type="submit" class="w-full bg-gradient-to-r from-helarisi-teal to-helarisi-teal-dark text-white font-semibold py-3 px-4 rounded-lg hover:from-helarisi-teal-dark hover:to-helarisi-maroon transition-all duration-300 transform hover:scale-[1.02] shadow-lg hover:shadow-xl">
            Create Account
        </button>
    </form>

    <!-- Divider -->
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-white text-gray-500 font-medium">Or sign up with</span>
        </div>
    </div>

    <!-- Google Sign Up Button -->
    <a href="{{ route('google.login') }}"
       class="w-full flex items-center justify-center gap-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold px-4 py-3 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 48 48">
            <path fill="#EA4335" d="M24 9.5c3.3 0 6.2 1.1 8.5 3.2l6.3-6.3C34.7 2.5 29.8 0 24 0 14.8 0 7.1 5.4 3.4 13.2l7.3 5.7C12.2 13.3 17.5 9.5 24 9.5z"/>
            <path fill="#34A853" d="M46.1 24.5c0-1.6-.1-3.2-.4-4.7H24v9h12.6c-.5 2.7-2.1 5.1-4.4 6.7l7 5.4c4.1-3.8 6.9-9.5 6.9-16.4z"/>
            <path fill="#4A90E2" d="M10.7 28.9C9.8 26.4 9.4 23.7 9.4 21s.4-5.4 1.3-7.9L3.4 7.4C1.2 11.4 0 16 0 21c0 5 1.2 9.6 3.4 13.6l7.3-5.7z"/>
            <path fill="#FBBC05" d="M24 48c6.5 0 12-2.1 16-5.8l-7-5.4c-2 1.4-4.7 2.3-9 2.3-6.5 0-12-4.4-14-10.3l-7.3 5.7C7.1 42.6 14.8 48 24 48z"/>
        </svg>
        Sign up with Google
    </a>

    <!-- Login Link -->
    <div class="text-center mt-6">
        <p class="text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="text-helarisi-teal hover:text-helarisi-teal-dark font-semibold transition-colors duration-200">
                Sign in here
            </a>
        </p>
    </div>

    <!-- Terms and Conditions Modal -->
    <div id="termsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeModalOnBackdrop(event, 'termsModal')">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-helarisi-teal to-helarisi-teal-dark text-white px-6 py-4 rounded-t-2xl flex justify-between items-center">
                <h3 class="text-2xl font-bold">Terms and Conditions</h3>
                <button onclick="closeModal('termsModal')" class="text-white hover:text-gray-200 text-3xl leading-none">&times;</button>
            </div>

            <!-- Modal Body - Scrollable -->
            <div id="termsContent" class="flex-1 overflow-y-auto px-6 py-6 text-gray-700" onscroll="checkScroll('termsContent', 'termsAgreeBtn')">
                <div class="space-y-4">
                    <p class="text-sm text-gray-500 italic">Last updated: December 2025</p>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">1. Introduction</h4>
                    <p>Welcome to Helarisi! These Terms and Conditions govern your use of our e-commerce platform for purchasing groceries and fresh products. By accessing or using our services, you agree to be bound by these terms.</p>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">2. Account Registration</h4>
                    <p>To use our services, you must:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Provide accurate and complete information during registration</li>
                        <li>Maintain the security of your account credentials</li>
                        <li>Be at least 18 years old or have parental consent</li>
                        <li>Notify us immediately of any unauthorized access to your account</li>
                    </ul>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">3. Product Information and Pricing</h4>
                    <p>We strive to provide accurate product descriptions, images, and pricing. However:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Product availability may change without notice</li>
                        <li>Prices are subject to change and may vary based on location</li>
                        <li>We reserve the right to correct pricing errors</li>
                        <li>Fresh produce weight and appearance may vary slightly from images</li>
                    </ul>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">4. Orders and Payment</h4>
                    <p>When placing an order:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>All orders are subject to acceptance and availability</li>
                        <li>Payment must be completed before order processing</li>
                        <li>We accept major credit cards, debit cards, and digital wallets</li>
                        <li>Order confirmation will be sent via email</li>
                        <li>Minimum order value may apply for delivery</li>
                    </ul>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">5. Delivery and Shipping</h4>
                    <p>Our delivery services include:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Same-day delivery for orders placed before cutoff time</li>
                        <li>Delivery fees based on distance and order value</li>
                        <li>Free delivery on orders above specified amount</li>
                        <li>Contactless delivery options available</li>
                        <li>Temperature-controlled transport for perishables</li>
                    </ul>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">6. Quality Guarantee and Returns</h4>
                    <p>We stand behind the quality of our products:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>100% satisfaction guarantee on all fresh products</li>
                        <li>Report quality issues within 24 hours of delivery</li>
                        <li>Refund or replacement for damaged or spoiled items</li>
                        <li>Photographic evidence may be required for claims</li>
                        <li>Perishable items cannot be returned once delivered</li>
                    </ul>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">7. User Conduct</h4>
                    <p>You agree not to:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Use the platform for any illegal or unauthorized purpose</li>
                        <li>Submit false or misleading information</li>
                        <li>Interfere with the proper functioning of the website</li>
                        <li>Attempt to gain unauthorized access to our systems</li>
                        <li>Abuse promotional offers or loyalty programs</li>
                    </ul>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">8. Intellectual Property</h4>
                    <p>All content on our platform, including text, graphics, logos, and images, is the property of Helarisi and protected by copyright laws. You may not reproduce or distribute our content without permission.</p>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">9. Limitation of Liability</h4>
                    <p>Helarisi shall not be liable for indirect, incidental, or consequential damages arising from the use of our services. Our total liability is limited to the amount paid for the specific order in question.</p>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">10. Changes to Terms</h4>
                    <p>We reserve the right to modify these terms at any time. Continued use of our services after changes constitutes acceptance of the modified terms. We will notify users of significant changes via email.</p>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">11. Contact Information</h4>
                    <p>For questions about these terms, please contact us at:</p>
                    <ul class="list-none pl-0 space-y-1">
                        <li><strong>Email:</strong> support@helarisi.com</li>
                        <li><strong>Phone:</strong> +94 XX XXX XXXX</li>
                        <li><strong>Address:</strong> Helarisi Headquarters, Sri Lanka</li>
                    </ul>

                    <div class="bg-helarisi-teal bg-opacity-10 border-l-4 border-helarisi-teal p-4 mt-6 rounded">
                        <p class="font-semibold text-helarisi-teal-dark">Please scroll to the bottom to accept these terms.</p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex justify-end gap-3 border-t border-gray-200">
                <button onclick="closeModal('termsModal')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-medium transition-colors">
                    Decline
                </button>
                <button id="termsAgreeBtn" disabled class="px-5 py-2 bg-gradient-to-r from-helarisi-teal to-helarisi-teal-dark text-white rounded-lg font-medium transition-all disabled:opacity-50 disabled:cursor-not-allowed hover:from-helarisi-teal-dark hover:to-helarisi-maroon" onclick="agreeToTerms('termsModal')">
                    I Agree
                </button>
            </div>
        </div>
    </div>

    <!-- Privacy Policy Modal -->
    <div id="privacyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeModalOnBackdrop(event, 'privacyModal')">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] flex flex-col" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-helarisi-maroon to-helarisi-orange text-white px-6 py-4 rounded-t-2xl flex justify-between items-center">
                <h3 class="text-2xl font-bold">Privacy Policy</h3>
                <button onclick="closeModal('privacyModal')" class="text-white hover:text-gray-200 text-3xl leading-none">&times;</button>
            </div>

            <!-- Modal Body - Scrollable -->
            <div id="privacyContent" class="flex-1 overflow-y-auto px-6 py-6 text-gray-700" onscroll="checkScroll('privacyContent', 'privacyAgreeBtn')">
                <div class="space-y-4">
                    <p class="text-sm text-gray-500 italic">Last updated: December 2025</p>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">1. Information We Collect</h4>
                    <p>We collect various types of information to provide and improve our services:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li><strong>Personal Information:</strong> Name, email address, phone number, delivery address</li>
                        <li><strong>Payment Information:</strong> Credit/debit card details (securely processed by payment providers)</li>
                        <li><strong>Order Information:</strong> Purchase history, product preferences, shopping patterns</li>
                        <li><strong>Device Information:</strong> IP address, browser type, operating system</li>
                        <li><strong>Usage Data:</strong> Pages visited, time spent on site, click patterns</li>
                    </ul>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">2. How We Use Your Information</h4>
                    <p>Your information is used to:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Process and deliver your orders</li>
                        <li>Communicate about order status and updates</li>
                        <li>Provide customer support and respond to inquiries</li>
                        <li>Personalize your shopping experience</li>
                        <li>Send promotional offers and newsletters (with your consent)</li>
                        <li>Improve our products and services</li>
                        <li>Prevent fraud and enhance security</li>
                        <li>Comply with legal obligations</li>
                    </ul>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">3. Information Sharing and Disclosure</h4>
                    <p>We may share your information with:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li><strong>Delivery Partners:</strong> To fulfill and deliver your orders</li>
                        <li><strong>Payment Processors:</strong> To process transactions securely</li>
                        <li><strong>Service Providers:</strong> Who assist in operating our platform</li>
                        <li><strong>Analytics Partners:</strong> To understand user behavior and improve services</li>
                        <li><strong>Legal Authorities:</strong> When required by law or to protect our rights</li>
                    </ul>
                    <p class="mt-2"><strong>We never sell your personal information to third parties.</strong></p>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">4. Data Security</h4>
                    <p>We implement robust security measures to protect your information:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>SSL/TLS encryption for data transmission</li>
                        <li>Secure storage with industry-standard encryption</li>
                        <li>Regular security audits and updates</li>
                        <li>Access controls and authentication protocols</li>
                        <li>Employee training on data protection</li>
                    </ul>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">5. Cookies and Tracking Technologies</h4>
                    <p>We use cookies and similar technologies to:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Remember your preferences and login status</li>
                        <li>Analyze website traffic and usage patterns</li>
                        <li>Deliver personalized content and advertisements</li>
                        <li>Improve website functionality and user experience</li>
                    </ul>
                    <p class="mt-2">You can control cookie settings through your browser preferences.</p>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">6. Your Privacy Rights</h4>
                    <p>You have the right to:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li><strong>Access:</strong> Request a copy of your personal data</li>
                        <li><strong>Rectification:</strong> Correct inaccurate or incomplete information</li>
                        <li><strong>Deletion:</strong> Request deletion of your personal data</li>
                        <li><strong>Opt-out:</strong> Unsubscribe from marketing communications</li>
                        <li><strong>Data Portability:</strong> Receive your data in a structured format</li>
                        <li><strong>Withdrawal:</strong> Withdraw consent for data processing</li>
                    </ul>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">7. Children's Privacy</h4>
                    <p>Our services are not intended for children under 18. We do not knowingly collect personal information from children. If we become aware of such collection, we will delete the information immediately.</p>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">8. Data Retention</h4>
                    <p>We retain your personal information for as long as necessary to:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Provide our services to you</li>
                        <li>Comply with legal and regulatory requirements</li>
                        <li>Resolve disputes and enforce agreements</li>
                        <li>Maintain business records and analytics</li>
                    </ul>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">9. International Data Transfers</h4>
                    <p>Your information may be transferred to and processed in countries other than your country of residence. We ensure appropriate safeguards are in place to protect your data in compliance with applicable laws.</p>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">10. Changes to Privacy Policy</h4>
                    <p>We may update this Privacy Policy periodically to reflect changes in our practices or legal requirements. We will notify you of significant changes via email or website notice.</p>

                    <h4 class="text-xl font-bold text-helarisi-maroon mt-6">11. Contact Us</h4>
                    <p>For privacy-related questions or to exercise your rights, contact us at:</p>
                    <ul class="list-none pl-0 space-y-1">
                        <li><strong>Email:</strong> privacy@helarisi.com</li>
                        <li><strong>Phone:</strong> +94 XX XXX XXXX</li>
                        <li><strong>Address:</strong> Data Protection Officer, Helarisi, Sri Lanka</li>
                    </ul>

                    <div class="bg-helarisi-maroon bg-opacity-10 border-l-4 border-helarisi-maroon p-4 mt-6 rounded">
                        <p class="font-semibold text-helarisi-maroon">Please scroll to the bottom to accept this privacy policy.</p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl flex justify-end gap-3 border-t border-gray-200">
                <button onclick="closeModal('privacyModal')" class="px-5 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 font-medium transition-colors">
                    Decline
                </button>
                <button id="privacyAgreeBtn" disabled class="px-5 py-2 bg-gradient-to-r from-helarisi-maroon to-helarisi-orange text-white rounded-lg font-medium transition-all disabled:opacity-50 disabled:cursor-not-allowed hover:opacity-90" onclick="agreeToTerms('privacyModal')">
                    I Agree
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript for Modal Functionality -->
    <script>
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            // Reset scroll position
            const contentId = modalId === 'termsModal' ? 'termsContent' : 'privacyContent';
            document.getElementById(contentId).scrollTop = 0;

            // Reset agree button
            const btnId = modalId === 'termsModal' ? 'termsAgreeBtn' : 'privacyAgreeBtn';
            document.getElementById(btnId).disabled = true;
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        function closeModalOnBackdrop(event, modalId) {
            if (event.target.id === modalId) {
                closeModal(modalId);
            }
        }

        function checkScroll(contentId, btnId) {
            const content = document.getElementById(contentId);
            const button = document.getElementById(btnId);

            // Check if scrolled to bottom (with 10px tolerance)
            const isScrolledToBottom = content.scrollHeight - content.scrollTop - content.clientHeight < 10;

            if (isScrolledToBottom) {
                button.disabled = false;
                button.classList.add('animate-pulse');
            }
        }

        function agreeToTerms(modalId) {
            // Check the terms checkbox
            document.getElementById('terms').checked = true;

            // Close the modal
            closeModal(modalId);

            // Show a brief confirmation
            const confirmation = document.createElement('div');
            confirmation.className = 'fixed top-4 right-4 bg-helarisi-teal text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-pulse';
            confirmation.innerHTML = '✓ Terms accepted successfully!';
            document.body.appendChild(confirmation);

            setTimeout(() => {
                confirmation.remove();
            }, 3000);
        }

        // Close modal on ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal('termsModal');
                closeModal('privacyModal');
            }
        });
    </script>
</x-guest-layout>
