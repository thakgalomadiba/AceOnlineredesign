<?php
include 'public/partials/header.php';

?>

<main class="container about-page">

    <!-- =========================
         ABOUT ORVEXA
    ========================== -->

    <section class="about-hero">
        <span class="about-eyebrow">A Software Development Portfolio Project</span>

        <h1>Welcome to Orvexa.</h1>

        <p>
            More than an online shopping experience, Orvexa is a web development
            project built to demonstrate practical software engineering,
            database integration and modern development workflows.
        </p>
    </section>


    <!-- =========================
         PROJECT OVERVIEW
    ========================== -->

    <section class="about-section">
        <h2>About the Project</h2>

        <p>
            Orvexa is a fictional e-commerce platform developed as part of my
            software development portfolio. The project provides an opportunity
            to apply my knowledge of web technologies while building an
            application with practical features and a structured architecture.
        </p>

        <div class="products-grid about-project-grid">

        <article class="product-card about-feature-card">
            <h3>Product Experience</h3>
                <p>
                Product browsing, category navigation, product details
                and shopping cart functionality.
                </p>
        </article>

        <article class="product-card about-feature-card">
            <h3>Database Integration</h3>
                <p>
                PHP and MySQL integration for managing products,
                categories and application data.
                </p>
    </article>

    <article class="product-card about-feature-card">
        <h3>Development Workflow</h3>
        <p>
            Git version control, automated testing and deployment
            using GitHub Actions.
        </p>
    </article>

        </div>
    </section>


    <!-- =========================
         DEVELOPER PROFILE
    ========================== -->

    <section class="about-section developer-section">

        <img
            src="/public/uploads/profile/thakgalo.jpg"
            alt="Photo of Thakgalo Madiba"
            class="developer-image"
            loading="lazy"
        >

</div>

        <div class="developer-info">

            <span class="about-eyebrow">Behind the Code</span>

            <h2>Meet the Developer</h2>

            <h3>Thakgalo Madiba</h3>

            <p class="developer-role">
                Software Developer | IT Professional
            </p>

            <p>
                I'm an Information Technology graduate specialising in
                Software Engineering. I'm passionate about developing
                practical software solutions, learning new technologies
                and understanding how applications are built, tested
                and deployed.
            </p>

            <p>
                Alongside my development journey, I have gained practical
                exposure to IT support and service desk operations.
                I enjoy combining problem-solving with software development
                to create useful and reliable applications.
            </p>

            <div class="developer-links">
                <a
                    href="https://github.com/thakgalomadiba"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn-primary"
                >
                    View My GitHub
                </a>

                <a href="contact.php" class="btn-primary">
                    Contact Me
                </a>
            </div>

        </div>

    </section>


    <!-- =========================
         TECHNOLOGY STACK
    ========================== -->

    <section class="about-section">

        <h2>Technologies & Tools</h2>

        <p>
            The following technologies and tools are used throughout
            the development of Orvexa.
        </p>

        <div class="tech-list">
            <span class="tech-item">PHP</span>
            <span class="tech-item">MySQL</span>
            <span class="tech-item">JavaScript</span>
            <span class="tech-item">HTML5</span>
            <span class="tech-item">CSS3</span>
            <span class="tech-item">Git</span>
            <span class="tech-item">GitHub</span>
            <span class="tech-item">GitHub Actions</span>
            <span class="tech-item">PHPUnit</span>
            <span class="tech-item">CI/CD</span>
        </div>

    </section>


    <!-- =========================
         PROJECT DISCLAIMER
    ========================== -->

    <section class="about-section">

        <div class="project-notice">

            <h3>Portfolio Project Notice</h3>

            <p>
                Orvexa is a fictional, non-commercial e-commerce project
                created for educational and portfolio demonstration purposes.
                Products, prices and other store content are illustrative.
                This website is not an operating retail business.
            </p>

        </div>

    </section>

</main>

<?php include 'public/partials/footer.php'; ?>