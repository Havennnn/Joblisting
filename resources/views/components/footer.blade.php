<!-- Footer Component -->
<footer class="bg-[#222] border-t border-gray-200 mt-auto text-white">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-8">
            <!-- Company Info -->
            <div class="col-span-1 md:col-span-3 flex items-start flex-col">
                <h2 class="text-xl font-bold mb-4">NeksJob</h2>
                <p class="text-sm mb-2">2nd Floor Fuentes Bldg, Waling Waling St. Mla. East Road, San Isidro, Angono, Rizal</p>
                <p class="text-sm mb-2">neksjob.com</p>
                <p class="text-sm mb-4">Monday to Friday, 9:00 AM to 4:00 PM</p>

                <!-- Social Icons -->
                <div class="flex space-x-4 mb-4">
                    <a href="#" class="text-neksjob-blue hover:text-gray-500">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                    <a href="#" class="text-neksjob-blue hover:text-gray-500">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>

                <p class="text-xs">© 2025 Copyright: neksjobph</p>
            </div>

            <!-- Footer Links -->
            <div class="col-span-1">
                <h4 class="text-sm font-bold uppercase tracking-wider mb-4">About</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-sm hover:text-neksjob-blue">About neksjob</a></li>
                    <li><a href="#" class="text-sm hover:text-neksjob-blue">Data Privacy</a></li>
                    <li><a href="#" class="text-sm hover:text-neksjob-blue">FAQ</a></li>
                </ul>
            </div>

            <div class="col-span-1">
                <h4 class="text-sm font-bold uppercase tracking-wider mb-4">Jobseekers</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('applicant.register') }}" class="text-sm hover:text-neksjob-blue">Sign-Up</a></li>
                    <li><a href="{{ route('login') }}" class="text-sm hover:text-neksjob-blue">Sign-In</a></li>
                    <li><a href="#" class="text-sm hover:text-neksjob-blue">Find a Job</a></li>
                </ul>
            </div>

            <div class="col-span-1">
                <h4 class="text-sm font-bold uppercase tracking-wider mb-4">Employers</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('employer.register') }}" class="text-sm hover:text-neksjob-blue">Sign-Up</a></li>
                    <li><a href="{{ route('login') }}" class="text-sm hover:text-neksjob-blue">Sign-In</a></li>
                </ul>
            </div>
        </div>

        <!-- Bottom Links -->
        <div class="mt-12 pt-8 border-t border-gray-200 flex flex-wrap space-x-4 text-sm">
            <a href="#" class="hover:text-neksjob-blue">Privacy Policy</a>
            <span>|</span>
            <a href="#" class="hover:text-neksjob-blue">Terms and Conditions</a>
            <span>|</span>
            <a href="#" class="hover:text-neksjob-blue">About Us</a>
        </div>
    </div>
</footer>
