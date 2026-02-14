<?php include 'public/partials/header.php'; ?>

<section class="contact-section">
  <div class="container">
    
    <h1 class="page-title">Contact Us</h1>
    <p class="page-subtitle">
      Have a question? We'd love to hear from you.
    </p>

    <div class="contact-wrapper">
      
      <!-- CONTACT FORM -->
      <form class="contact-form" method="POST" action="">
        
        <div class="form-group">
          <label for="name">Full Name</label>
          <input type="text" id="name" name="name" required>
        </div>

        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
          <label for="message">Message</label>
          <textarea id="message" name="message" rows="5" required></textarea>
        </div>

        <button type="submit" class="primary-btn">Send Message</button>
      </form>

      <!-- CONTACT INFO -->
      <div class="contact-info">
        <h3>Our Details</h3>
        <p><strong>Email:</strong> support@aceonline.co.za</p>
        <p><strong>Phone:</strong> 012 345 6789</p>
        <p><strong>Address:</strong> 123 Main Road, Pretoria</p>

        <a href="index.php" class="back-home-btn">← Back to Home</a>
      </div>

    </div>

  </div>
</section>

<?php include 'public/partials/footer.php'; ?>
