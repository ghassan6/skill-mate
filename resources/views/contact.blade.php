<x-layout>
    <x-slot:title>Contact</x-slot:title>

        <!-- Page Header Start -->
        <div class="container-fluid page-header mb-5 py-5">
        <div class="container">
            <h1 class="display-3 text-white mb-3 animated slideInDown">Contact Us</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb text-uppercase">
                    <li class="breadcrumb-item"><a class="text-white" href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item text-white active" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-4">
          
                <div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-light p-5 h-100 d-flex align-items-center">
                        <form action="{{route('contact.store')}}" method="POST">
                            @csrf
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif


                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                           
                                        <label for="name">Your Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{Auth::check() ? Auth::user()->username : ''}}"    placeholder="{{Auth::check() ? '' : 'e.g. Jon Doe'}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Your Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{Auth::check() ? Auth::user()->email : ''}}"  placeholder="{{Auth::check() ? '' : 'e.g. Email@example.com'}}" >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="subject">Subject</label>
                                        <select name="subject" id="subject" class="form-select" required>
                                            <option value="none" selected disabled>What is your inquery about?</option>
                                            <option value="feedback">Feedback about our website</option>
                                            <option value="problem">Report a problem</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="message">Message</label>
                                        <textarea class="form-control" name="message" placeholder="Leave a message here" id="message" style="height: 150px" required></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3" type="submit">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h6 class="text-secondary text-uppercase">Get In Touch</h6>
                    <h4><i class='bx bxs-location-plus'>Jordan,Amman, Al-Dakhliya Circle </i></h4>
                    <h3 class="mb-4">Contact For Any Query</h3>
                    <iframe class="position-relative w-100"
                        src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3384.53295393485!2d35.9071250753558!3d31.973564974009825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMzHCsDU4JzI0LjgiTiAzNcKwNTQnMzQuOSJF!5e0!3m2!1sen!2sjo!4v1743719129126!5m2!1sen!2sjo"
                        frameborder="0" style="height: 300px; border:0;" allowfullscreen="" aria-hidden="false"
                        tabindex="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</x-layout>