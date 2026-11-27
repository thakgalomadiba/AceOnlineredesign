<?php
include 'public/partials/header.php';
?>

<style>
/* =========================
   ABOUT PAGE
========================= */

.about-page {
    padding-top: 60px;
    padding-bottom: 70px;
    color: #1e293b;
}

/* HERO SECTION */

.about-hero {
    padding: 65px 45px;
    margin-bottom: 65px;
    border-radius: 18px;
    background: linear-gradient(135deg, #101a30, #263e60);
    color: #ffffff;
    text-align: center;
}

.about-eyebrow {
    display: inline-block;
    margin-bottom: 18px;
    color: #65d6d0;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.about-hero h1 {
    margin-bottom: 18px;
    color: #ffffff;
    font-size: clamp(32px, 5vw, 48px);
    line-height: 1.2;
}

.about-hero p {
    max-width: 700px;
    margin: 0 auto;
    color: #d3deeb;
    font-size: 17px;
    line-height: 1.8;
}

/* GENERAL SECTIONS */

.about-section {
    margin-bottom: 70px;
}

.about-section h2 {
    margin-bottom: 18px;
    color: #14213b;
    font-size: 28px;
}

.about-section > p {
    max-width: 850px;
    color: #64748b;
    font-size: 16px;
    line-height: 1.9;
}

/* DEVELOPER SECTION */

.developer-section {
    display: grid;
    grid-template-columns: 0.85fr 1.5fr;
    align-items: center;
    gap: 55px;
}

.developer-image-wrapper {
    display: flex;
    justify-content: center;
}

.developer-image {
    width: 100%;
    max-width: 310px;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    border-radius: 20px;
    box-shadow: 0 15px 40px rgba(15, 23, 42, 0.15);
}

.developer-placeholder {
    width: 250px;
    height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 20px;
    background: linear-gradient(135deg, #14213b, #347c91);
    color: #ffffff;
    font-size: 64px;
    font-weight: 800;
    box-shadow: 0 15px 40px rgba(15, 23, 42, 0.15);
}

.developer-info h2 {
    margin-bottom: 8px;
    font-size: 32px;
}

.developer-role {
    margin-bottom: 22px;
    color: #168b91;
    font-weight: 700;
}

.developer-info p {
    color: #64748b;
    font-size: 16px;
    line-height: 1.9;
}

.developer-links {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 25px;
}

.developer-links a {
    display: inline-block;
    padding: 11px 20px;
    border-radius: 8px;
    background: #14213b;
    color: #ffffff;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s ease;
}

.developer-links a:hover {
    background: #168b91;
    transform: translateY(-2px);
}

/* PROJECT INFORMATION */

.project-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
    margin-top: 30px;
}

.project-card {
    padding: 25px;
    border: 1px solid #e2e8f0;
    border-radius: 13px;
    background: #ffffff;
    transition: 0.2s ease;
}

.project-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(15, 23, 42, 0.08);
}

.project-card h3 {
    margin-bottom: 12px;
    color: #14213b;
    font-size: 19px;
}

.project-card p {
    margin: 0;
    color: #64748b;
    font-size: 14px;
    line-height: 1.8;
}

/* TECHNOLOGIES */

.tech-list {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-top: 25px;
}

.tech-item {
    padding: 10px 17px;
    border: 1px solid #dbe5ee;
    border-radius: 30px;
    background: #f1f7fa;
    color: #263e60;
    font-size: 14px;
    font-weight: 700;
}

/* NOTICE */

.project-notice {
    padding: 25px 30px;
    border-left: 4px solid #168b91;
    border-radius: 8px;
    background: #eef8f8;
}

.project-notice h3 {
    margin-bottom: 10px;
    color: #14213b;
}

.project-notice p {
    margin: 0;
    color: #526477;
    line-height: 1.8;
}

/* RESPONSIVE DESIGN */

@media (max-width: 768px) {
    .about-hero {
        padding: 45px 22px;
    }

    .developer-section {
        grid-template-columns: 1fr;
        gap: 30px;
    }

    .project-grid {
        grid-template-columns: 1fr;
    }

    .developer-info {
        text-align: center;
    }

    .developer-links {
        justify-content: center;
    }

    .about-page {
        padding-top: 35px;
    }
}
</style>

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

        <div class="project-grid">

            <div class="project-card">
                <h3>Product Experience</h3>
                <p>
                    Product browsing, category navigation, product details
                    and shopping cart functionality.
                </p>
            </div>

            <div class="project-card">
                <h3>Database Integration</h3>
                <p>
                    PHP and MySQL integration for managing products,
                    categories and application data.
                </p>
            </div>

            <div class="project-card">
                <h3>Development Workflow</h3>
                <p>
                    Git version control, automated testing and deployment
                    using GitHub Actions.
                </p>
            </div>

        </div>
    </section>


    <!-- =========================
         DEVELOPER PROFILE
    ========================== -->

    <section class="about-section developer-section">

        <div class="developer-image-wrapper">

           

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
                >
                    View My GitHub
                </a>

                <a href="contact.php">
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