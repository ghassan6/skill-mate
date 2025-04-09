<x-layout>
    <link rel="stylesheet" href="{{asset('css/about.css')}}">
    <x-slot:title>About Us</x-slot>


    <section class="container py-5 about-page">
        <div class="text-center mb-5">
            <h1 class="display-4">Skill Mate</h1>
            <p class="lead text-muted">Empowering people by bridging the gap between service providers and those who need them.</p>
        </div>

        <x-about-section>
            <x-slot:title>Our Mission</x-slot:title>
            <x-slot:text>
                Our mission is simple — to connect skilled service providers with individuals and businesses seeking trusted and reliable services.
                Whether you're a freelancer, a technician, or a business owner, we provide a platform where your services can reach the right people effortlessly.
            </x-slot:text>

            <x-about-image src="mission"></x-about-image>
        </x-about-section>

        <x-about-section class='order-md-2'>
            <x-slot:title >What We Do</x-slot:title>
            <x-slot:text>
                We simplify the process of finding and offering services by allowing users to post requests and proposals, browse available offers, and communicate securely.
                From home repairs and tutoring to graphic design and more — our platform covers a wide range of services tailored to your needs.
            </x-slot:text>

            <x-about-image src="about-service" class='order-md-1' ></x-about-image>

        </x-about-section>


        <x-about-section>
            <x-slot:title >Why Choose Us?</x-slot:title>
            <x-slot:text>
                <ul class="list-unstyled">
                    <li class="mb-2">✔️ Easy-to-use and intuitive interface</li>
                    <li class="mb-2">✔️ Verified service providers and transparent ratings</li>
                    <li class="mb-2">✔️ Secure messaging and payment options</li>
                    <li class="mb-2">✔️ Built with trust and community in mind</li>
                </ul>
            </x-slot:text>

            <x-about-image src="what-we-do" class='order-md-1' ></x-about-image>


        </x-about-section>

        <div class="text-center mt-5">
            <h4 class="mb-3">Join Us Today</h4>
            <p class="text-muted">Be a part of a growing community that values skills, connections, and great service. Whether you're here to offer your talents or find the help you need — you're in the right place.</p>
            <a href="{{ route('register') }}" class="btn btn-primary px-4 py-2 mt-3">Get Started</a>
        </div>
    </section>
</x-layout>


