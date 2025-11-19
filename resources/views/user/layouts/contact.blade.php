@extends('user.layouts.master')

@section('content')
    <section id="billboard" class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <h1 class="section-title text-center mt-4">
                    GET IN TOUCH
                </h1>
            </div>
        </div>
    </section>
    <div class="container-fluid contact pb-5">
        <div class="container py-5">
            @if (session('success'))
                <div style="height: 60px; width: 400px" class="alert alert-success alert-dismissible fade show  offset-1"
                    role="alert">
                    <small class="mb-5">{{ session('success') }}</small>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
            <div class="p-5 rounded">
                <div class="row g-4">
                    <div class="col-12">
                    </div>
                    <div class="col-lg-12">
                        <div class="h-100 rounded">
                            <iframe class="rounded w-100" style="height: 400px;"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7290.773173843275!2d96.1572394040668!3d16.776784298088128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c1ec86c64627b3%3A0xf629281949864a5c!2sSule%20Square!5e0!3m2!1sen!2smm!4v1754145929007!5m2!1sen!2smm"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-7">

                        <form action="{{ route('user#createContact') }}" method="post" class="">
                            @csrf
                            <div class=" mt-3 mb-5">
                                <input type="title" name="subject" value="{{ old('subject') }}"
                                    class="w-100 form-control py-3 @error('subject') is-invalid @enderror"
                                    placeholder="Subject">
                                @error('subject')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class=" my-4">
                                <textarea value="{{ old('message') }}" class="w-100 form-control @error('message') is-invalid @enderror" name="message"
                                    rows="5" cols="10" placeholder="Your Message"></textarea>
                                @error('message')
                                    <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>
                            <button class="w-100 btn rounded form-control btn-primary my-3 py-3"
                                type="submit">Submit</button>
                        </form>
                    </div>
                    <div class="col-lg-5">
                        <div class="d-flex p-3 rounded mb-4 border-bottom">
                            <i class="fas fa-map-marker-alt fa-x text-primary me-4"></i>
                            <div>
                                <h5>Address</h5>
                                <p class="mb-2">Sule, Yangon</p>
                            </div>
                        </div>
                        <div class="d-flex p-3 rounded mb-4 border-bottom">
                            <i class="fas fa-envelope fa-x text-primary me-4"></i>
                            <div>
                                <h5>Mail Us</h5>
                                <p class="mb-2">cos211project.com</p>
                            </div>
                        </div>
                        <div class="d-flex p-3 rounded border-bottom">
                            <i class="fa fa-phone-alt fa-x text-primary me-4"></i>
                            <div>
                                <h5>Telephone</h5>
                                <p class="mb-2">(+959) 09123456</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
