@extends('user.layouts.master')

@section('content')
    <section id="billboard" class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center">
                <h1 class="section-title text-center mt-4" data-aos="fade-up">
                    ABOUT US
                </h1>
            </div>
        </div>
    </section>

    <div class="container-fluid my-5 p-5">
        <div class="row d-flex my-3">
            <div class="col-lg-6 d-flex justify-content-center">
                <img src="https://content.api.news/v3/images/bin/e8ca11e55adf43ffe86f13f37c373fbe"
                    class="object-fit-cover rounded" style="max-height: 700px; max-width: 1000px" alt="">
            </div>
            <div class="col-lg-6 d-flex align-items-center">
                <p">At STYLEHUB, we believe that clothing is more than just fabric— it’s a statement of
                    identity, comfort,
                    and creativity. Founded in 2025, our mission has been to craft stylish, sustainable, and affordable
                    apparel for everyone.
                    <br> <br>
                    Every piece we design is made with love, attention to detail, and a commitment to quality. We take pride
                    in blending timeless style with modern trends, making fashion accessible and empowering for all.
                    </p>
            </div>
        </div>
    </div>

    <section class="bg-light py-5">
        <div class="container text-center">
            <h2 class="fw-semi-bold mb-4">Our Mission</h2>
            <p class="lead mx-auto" style="max-width: 700px">
                To inspire confidence and self-expression through fashion that doesn’t
                just look good, but also feels good and respects the planet.
            </p>
        </div>
    </section>
@endsection
