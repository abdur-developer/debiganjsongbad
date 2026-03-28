<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABDUR RAHMAN | Developer & Designer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4cc9f0;
            --light: #f8f9fa;
            --dark: #212529;
            --gold: #ffd700;
            --success: #4bb543;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
            color: var(--light);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .profile-card {
            width: 100%;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .profile-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(67, 97, 238, 0.1) 0%, transparent 70%);
            z-index: -1;
            animation: rotate 15s linear infinite;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .profile-sidebar {
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.2);
            position: relative;
        }
        
        .profile-img-container {
            position: relative;
            width: 180px;
            height: 180px;
            margin-bottom: 30px;
        }
        
        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        
        .profile-img:hover {
            transform: scale(1.05);
            border-color: var(--accent);
        }
        
        .profile-title {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .profile-title h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
            color: white;
        }
        
        .profile-title p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 5px;
        }
        
        .profile-title span {
            display: block;
            font-size: 14px;
            color: var(--accent);
            font-weight: 500;
        }
        
        .contact-info {
            width: 100%;
            margin-top: auto;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
        }
        
        .contact-item:hover {
            color: var(--accent);
            transform: translateX(5px);
        }
        
        .contact-item i {
            margin-right: 10px;
            font-size: 18px;
            width: 30px;
            text-align: center;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            gap: 15px;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            font-size: 18px;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--accent);
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(76, 201, 240, 0.4);
        }
        
        .profile-content {
            padding: 40px;
        }
        
        .section {
            margin-bottom: 30px;
        }
        
        .section-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 15px;
            color: var(--accent);
            position: relative;
            padding-bottom: 8px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: var(--gold);
            border-radius: 3px;
        }
        
        .about-text {
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
        }
        
        .skills-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .skill {
            background: rgba(76, 201, 240, 0.1);
            color: var(--accent);
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid rgba(76, 201, 240, 0.3);
            transition: all 0.3s ease;
        }
        
        .skill:hover {
            background: var(--accent);
            color: var(--dark);
            transform: translateY(-3px);
        }
        
        .btn-contact {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            margin-top: 10px;
        }
        
        .btn-contact:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.6);
            background: linear-gradient(45deg, var(--secondary), var(--primary));
        }
        
        .address-info {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
        }
        
        .address-info i {
            margin-right: 10px;
            color: var(--accent);
        }
        
        @media (max-width: 768px) {
            .profile-card {
                grid-template-columns: 1fr;
            }
            
            .profile-sidebar {
                padding: 30px 20px;
            }
            
            .profile-content {
                padding: 30px 20px;
            }
        }
        
        /* Animated background elements */
        .bg-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }
        
        .bg-elements span {
            position: absolute;
            display: block;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.05);
            animation: animate 15s linear infinite;
            bottom: -150px;
        }
        
        .bg-elements span:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }
        
        .bg-elements span:nth-child(2) {
            left: 10%;
            width: 20px;
            height: 20px;
            animation-delay: 2s;
            animation-duration: 12s;
        }
        
        .bg-elements span:nth-child(3) {
            left: 70%;
            width: 20px;
            height: 20px;
            animation-delay: 4s;
        }
        
        .bg-elements span:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }
        
        .bg-elements span:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
        }
        
        .bg-elements span:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }
        
        .bg-elements span:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }
        
        .bg-elements span:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }
        
        .bg-elements span:nth-child(9) {
            left: 20%;
            width: 15px;
            height: 15px;
            animation-delay: 2s;
            animation-duration: 35s;
        }
        
        .bg-elements span:nth-child(10) {
            left: 85%;
            width: 150px;
            height: 150px;
            animation-delay: 0s;
            animation-duration: 11s;
        }
        
        @keyframes animate {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }
    </style>
</head>
<body>
    <!-- Animated background elements -->
    <div class="bg-elements">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    
    <!-- Profile Card -->
    <div class="profile-card">
        <!-- Sidebar with profile image and basic info -->
        <div class="profile-sidebar">
            <div class="profile-img-container">
                <img src="assets/img/abdur.jpg" alt="Abdur Rahman" class="profile-img">
            </div>
            
            <div class="profile-title">
                <h2>Abdur Rahman</h2>
                <p>Android & Web Developer</p>
                <span>Developer & Designer</span>
            </div>
            
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:abdur09266@gmail.com" style="color: inherit; text-decoration: none;">abdur09266@gmail.com</a>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <a href="tel:+8801709409266" style="color: inherit; text-decoration: none;">+8801709409266</a>
                </div>
                <div class="contact-item">
                    <i class="fab fa-whatsapp"></i>
                    <a href="https://wa.me/8801709409266" style="color: inherit; text-decoration: none;">Chat on WhatsApp</a>
                </div>
            </div>
            
            <div class="social-links">
                <a href="https://facebook.com/abdur.developer" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.linkedin.com/in/abdur-developer/" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://github.com/abdur-developer" target="_blank" title="GitHub"><i class="fab fa-github"></i></a>
            </div>
        </div>
        
        <!-- Main content area -->
        <div class="profile-content">
            <div class="section">
                <h3 class="section-title">About Me</h3>
                <p class="about-text">
                    I'm Md Abdur Rahman, an Android app and web developer with 4 years of experience. 
                    I specialize in designing and building user-centered mobile and web solutions that 
                    deliver functionality and ease of use. My goal is to create impactful digital 
                    experiences that meet clients' needs effectively.
                </p>
                <a href="https://wa.me/8801709409266" class="btn-contact">Send Message</a>
            </div>
            
            <div class="section">
                <h3 class="section-title">Skills</h3>
                <div class="skills-container">
                    <span class="skill">HTML</span>
                    <span class="skill">CSS</span>
                    <span class="skill">Bootstrap</span>
                    <span class="skill">XML</span>
                    <span class="skill">JavaScript</span>
                    <span class="skill">Java</span>
                    <span class="skill">PHP</span>
                    <span class="skill">C++</span>
                    <span class="skill">MySQL</span>
                    <span class="skill">WordPress</span>
                </div>
            </div>
            
            <div class="section">
                <h3 class="section-title">Location</h3>
                <div class="address-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Debiganj, Panchagarh, Bangladesh</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>