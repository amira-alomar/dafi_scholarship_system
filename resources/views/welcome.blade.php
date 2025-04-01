<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- SEO meta description -->
    <meta
      name="description"
      content="DAFI Scholarship System - Empowering your future with innovative scholarship opportunities and expert guidance."
    />
    <title>DAFI Scholarship System - Empower Your Future</title>
    <!-- Google Fonts: Poppins with font-display swap -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />
    <!-- External CSS file -->
    <link rel="stylesheet"  href="{{ asset('css/home.css') }}" />
  </head>
  <body>
    <!-- Header / Navigation -->
    @include('include.header', [
    'links' => [
        'Home' => '#home',
        'How it Works' => '#how-it-works',
        'Scholarships' => '#scholarships',
        'Testimonials' => '#testimonials',
        'FAQ' => '#faq',
        'Login' => route('login') ,
    ]
])


    <!-- Hero Section -->
    <section class="hero" id="home">
      <div class="hero-text reveal reveal-left">
        <h1>Empower Your Future with DAFI Scholarships</h1>
        <p>
          Unlock a world of scholarship opportunities with our innovative system
          that connects you with trusted mentors and top programs.
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Est voluptate blanditiis dolores. Nesciunt illum laudantium provident ipsum nam tempora temporibus, sint perferendis dignissimos maiores reiciendis perspiciatis omnis laboriosam numquam recusandae!
        </p>
        <a href="#scholarships" class="btn">Get Started</a>
        <a href="#how-it-works" class="btn learn-more">Learn More</a>
      </div>
      <div class="hero-image reveal reveal-right">
        <img
          src="images/photo_2025-02-21_16-43-10.jpg"
          alt="Scholarship Illustration"
          loading="lazy"
        />
      </div>
    </section>

    <!-- Count Section -->
    <section id="students-count" class="reveal reveal-bottom">
      <div class="container">
        <h2>Our Students</h2>
        <div class="stats">
          <div class="stat-item">
            <span class="number">+{{ $students }}</span>
            <p>Students Awarded</p>
          </div>
          <div class="stat-item">
            <span class="number">+50</span>
            <p>Successful Graduates</p>
          </div>
          <div class="stat-item">
            <span class="number">+{{ $applicationCount }}</span>
            <p>Applicants Each Year</p>
          </div>
        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works reveal reveal-bottom" id="how-it-works">
      <h2>How it Works</h2>
      <div class="steps">
        <div class="step reveal reveal-left">
          <img
            src="images/formIcon.jpg"
            alt="Step 1"
            loading="lazy"
          />
          <h3>Step 1</h3>
          <p>Register using our simple application process.</p>
        </div>
        <div class="step reveal reveal-bottom">
          <div class="icon">
            <img
              src="images/interview.png"
              alt="Step 2"
              loading="lazy"
            />
          </div>
          <h3>Step 2</h3>
          <p>Explore a wide range of scholarship programs.</p>
        </div>
        <div class="step reveal reveal-right">
          <img
            src="images/exam.png"
            alt="Step 3"
            loading="lazy"
          />
          <h3>Step 3</h3>
          <p>Submit your application and required documents.</p>
        </div>
        <div class="step reveal reveal-left">
          <img
            src="images/result.png"
            alt="Step 4"
            loading="lazy"
          />
          <h3>Step 4</h3>
          <p>Receive your scholarship and start your journey.</p>
        </div>
      </div>
    </section>

    <!-- Scholarships Section -->
    <!-- Scholarships Section -->
<section class="courses-section reveal reveal-bottom" id="scholarships">
  <h2>Available Scholarships</h2>
  <div class="courses-grid">
    @foreach ($scholarships as $scholarship)
      <div class="course reveal reveal-left" onclick="toggleScholarship({{ $scholarship->scholarshipID }})">
        <img src="images/photo_2025-02-21_16-43-21.jpg" alt="{{ $scholarship->name }}" loading="lazy" />
        <div class="course-content">
          <h3>{{ $scholarship->name }}</h3>
          <p>{{ $scholarship->description }}</p>
          <span class="click-info">📌 Click to see details</span>
        </div>
      </div>
    @endforeach
  </div>
</section>

<!-- About Section - initially hidden -->
@foreach ($scholarships as $scholarship)
  <section id="about-scholarship-{{ $scholarship->scholarshipID }}" class="reveal reveal-bottom" style="display: none;">
    <div class="container">
      <h2>About the Scholarship</h2>
      <div class="scholarship-description">
        <h3 class="red-title">Who We Are?</h3>
        <p class="scholarship-text">{{ $scholarship->description }}</p>
      </div>
      <br>
      <div class="scholarship-info">
        <div class="info-item"><strong>Funding Organization:</strong> {{ $scholarship->funding_organization }}</div>
        <div class="info-item"><strong>Country:</strong> Lebanon</div>
        <div class="info-item"><strong>Target Group:</strong> Undergraduate</div>
        <div class="info-item"><strong>Eligibility Criteria:</strong>
          <ul class="custom-list">
            @foreach ($scholarship->criteria as $criterion)
              <li>{{ $criterion->criteria_text }}</li>
            @endforeach
          </ul>
        </div>
        <div class="info-item"><strong>Benefits:</strong>
          <ul class="custom-list">
            @foreach ($scholarship->benefits as $benefit)
              <li>{{ $benefit->Benefit_text }}</li>
            @endforeach
          </ul>
        </div>
        <div class="info-item"><strong>Partners:</strong>
          <ul class="custom-list">
            @foreach ($scholarship->partners as $partner)
              <li>{{ $partner->Partner_name }}</li>
            @endforeach
          </ul>
        </div>
        <div class="info-item"><strong>Important Dates:</strong>
          <table class="schedule-table">
            <tr><th>Stage</th><th>Date</th></tr>
            @foreach ($scholarship->applicationStages->sortBy('order') as $stage)
              <tr><td>{{ $stage->name }}</td><td>date</td></tr>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </section>
@endforeach

    

    <!-- Testimonials Section -->
    <section class="testimonials-section reveal reveal-bottom" id="testimonials">
      <h2>What Our Scholars Say</h2>
      <div class="testimonials-container">
        <div class="testimonial reveal reveal-left">
          <img
            src="images/person1.jpg"
            alt="Scholar 1"
            loading="lazy"
          />
          <p>"The DAFI Scholarship System transformed my career path."</p>
          <h3>- Ahmed Ali</h3>
        </div>
        <div class="testimonial reveal reveal-bottom">
          <img
            src="images/person2.jpg"
            alt="Scholar 2"
            loading="lazy"
          />
          <p>"A seamless application process and excellent support."</p>
          <h3>- Sara Mohamed</h3>
        </div>
        <div class="testimonial reveal reveal-right">
          <img
            src="images/person3.jpg"
            alt="Scholar 3"
            loading="lazy"
          />
          <p>"I received the scholarship and now I'm pursuing my dreams."</p>
          <h3>- John Doe</h3>
        </div>
      </div>
    </section>

  <!-- FAQ Section -->
<section id="faq" class="reveal reveal-bottom">
  <div class="container">
    <h2>Frequently Asked Questions</h2>

    @foreach ($FAQs as $faq)
      <div class="faq-item">
        <div class="question">
          {{ $faq->question }}
          <span class="arrow">&#9660;</span>
        </div>
        <div class="answer">
          {{ $faq->answer }}
        </div>
      </div>
    @endforeach

  </div>
</section>

    <!-- Partners Section -->
    <div class="partners reveal reveal-bottom">
      <img
        src="images/photo_2025-02-09_12-12-03.jpg"
        alt="Partner 1"
        loading="lazy"
      />
      <img src="images/download (1).jpg" alt="Partner 2" loading="lazy" />
      <img src="images/download.png" alt="Partner 3" loading="lazy" />
    </div>

    <!-- Newsletter Section -->
    <section class="newsletter-section reveal reveal-bottom" id="subscribe">
      <h2>Subscribe to Our Newsletter</h2>
      <p>
        Stay updated with the latest scholarship programs and opportunities.
      </p>
      <form class="newsletter-form">
        <input type="email" placeholder="Enter your email" required />
        <button type="submit">Subscribe</button>
      </form>
    </section>

    <!-- Footer -->
    <footer class="reveal reveal-bottom">
      <div class="footer-content">
        <div>
          <h3>DAFI Scholarship</h3>
          <p>Empowering futures through scholarship opportunities.</p>
        </div>
        <div>
          <h3>Programs</h3>
          <ul>
            <li><a href="#scholarships">STEM</a></li>
            <li><a href="#scholarships">Arts</a></li>
            <li><a href="#scholarships">Business</a></li>
            <li><a href="#scholarships">Humanities</a></li>
          </ul>
        </div>
        <div>
          <h3>Resources</h3>
          <ul>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Community</a></li>
            <li><a href="#">Support</a></li>
            <li><a href="#">Guides</a></li>
          </ul>
        </div>
        <div>
          <h3>Contact</h3>
          <ul>
            <li>
              <a href="mailto:info@dafischolarship.org">info@dafischolarship.org</a>
            </li>
            <li><a href="tel:+123456789">+1 234 567 89</a></li>
            <li>1234 Scholarship St, City</li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        &copy; 2025 DAFI Scholarship. All rights reserved.
      </div>
    </footer>
    <!-- External JavaScript file -->
    <script src="{{ asset('js/home.js') }}"></script>
  </body>
</html>
