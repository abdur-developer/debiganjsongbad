-- phpMyAdmin SQL Dump
-- Database: debiganj_news

CREATE DATABASE IF NOT EXISTS debiganj_news;
USE debiganj_news;

-- ============================================
-- Table: users (ব্যবহারকারী)
-- ============================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    avatar VARCHAR(255),
    bio TEXT,
    role ENUM('super_admin', 'admin', 'editor', 'reporter', 'moderator') DEFAULT 'reporter',
    status ENUM('active', 'inactive', 'banned') DEFAULT 'active',
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================
-- Table: roles_permissions (অনুমতি)
-- ============================================
CREATE TABLE roles_permissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role VARCHAR(50) UNIQUE NOT NULL,
    permissions JSON NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table: categories (ক্যাটাগরি)
-- ============================================
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_bn VARCHAR(100) NOT NULL,
    name_en VARCHAR(100),
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    parent_id INT DEFAULT 0,
    icon VARCHAR(50),
    sort_order INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- Table: news (সংবাদ)
-- ============================================
CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_bn VARCHAR(255) NOT NULL,
    title_en VARCHAR(255),
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    summary TEXT,
    featured_image VARCHAR(255),
    gallery_images JSON,
    video_url VARCHAR(255),
    category_id INT,
    tags JSON,
    author_id INT,
    editor_id INT,
    views INT DEFAULT 0,
    is_breaking TINYINT(1) DEFAULT 0,
    is_featured TINYINT(1) DEFAULT 0,
    is_trending TINYINT(1) DEFAULT 0,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    published_at DATETIME,
    scheduled_at DATETIME,
    meta_title VARCHAR(255),
    meta_description TEXT,
    meta_keywords TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (editor_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- Table: comments (মন্তব্য)
-- ============================================
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    news_id INT NOT NULL,
    user_id INT,
    name VARCHAR(100),
    email VARCHAR(100),
    comment TEXT NOT NULL,
    status ENUM('pending', 'approved', 'spam') DEFAULT 'pending',
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (news_id) REFERENCES news(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- Table: gallery (ছবি গ্যালারি)
-- ============================================
CREATE TABLE gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title_bn VARCHAR(255) NOT NULL,
    title_en VARCHAR(255),
    image VARCHAR(255) NOT NULL,
    description TEXT,
    category VARCHAR(100),
    uploaded_by INT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- Table: advertisements (বিজ্ঞাপন)
-- ============================================
CREATE TABLE advertisements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    type ENUM('banner', 'sidebar', 'popup', 'video') DEFAULT 'banner',
    position VARCHAR(50),
    image VARCHAR(255),
    code TEXT,
    link VARCHAR(255),
    start_date DATE,
    end_date DATE,
    clicks INT DEFAULT 0,
    impressions INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- Table: settings (সেটিংস)
-- ============================================
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    key_name VARCHAR(100) UNIQUE NOT NULL,
    value TEXT,
    type ENUM('text', 'textarea', 'image', 'json') DEFAULT 'text',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ============================================
-- Table: activity_log (লগ)
-- ============================================
CREATE TABLE activity_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- ============================================
-- ডিফল্ট ডাটা ইনসার্ট
-- ============================================

-- রোল পারমিশন
INSERT INTO roles_permissions (role, permissions) VALUES
('super_admin', '{"news":"all","categories":"all","users":"all","settings":"all","ads":"all","comments":"all","gallery":"all"}'),
('admin', '{"news":"all","categories":"all","users":"view,create,edit","settings":"view","ads":"all","comments":"all","gallery":"all"}'),
('editor', '{"news":"all","categories":"view","users":"none","settings":"none","ads":"none","comments":"approve","gallery":"create,edit"}'),
('reporter', '{"news":"create,edit_own","categories":"view","users":"none","settings":"none","ads":"none","comments":"view","gallery":"create"}'),
('moderator', '{"news":"none","categories":"none","users":"none","settings":"none","ads":"none","comments":"approve,delete","gallery":"none"}');

-- ডিফল্ট সুপার অ্যাডমিন (পাসওয়ার্ড: Admin@123)
INSERT INTO users (username, email, password, full_name, role) VALUES
('superadmin', 'admin@debiganjsongbad.com', '$2y$10$YourHashedPasswordHere', 'সুপার অ্যাডমিন', 'super_admin');

-- ডিফল্ট ক্যাটাগরি
INSERT INTO categories (name_bn, name_en, slug, sort_order) VALUES
('জাতীয়', 'National', 'national', 1),
('আন্তর্জাতিক', 'International', 'international', 2),
('রাজনীতি', 'Politics', 'politics', 3),
('অর্থনীতি', 'Economy', 'economy', 4),
('খেলাধুলা', 'Sports', 'sports', 5),
('বিনোদন', 'Entertainment', 'entertainment', 6),
('প্রযুক্তি', 'Technology', 'technology', 7),
('শিক্ষা', 'Education', 'education', 8),
('স্বাস্থ্য', 'Health', 'health', 9),
('দেবীগঞ্জ', 'Debiganj', 'debiganj', 10),
('ঠাকুরগাঁও', 'Thakurgaon', 'thakurgaon', 11),
('পঞ্চগড়', 'Panchagarh', 'panchagarh', 12),
('লাইফস্টাইল', 'Lifestyle', 'lifestyle', 13),
('ধর্ম', 'Religion', 'religion', 14),
('ভিডিও', 'Video', 'video', 15),
('মতামত', 'Opinion', 'opinion', 16),
('চাকরি', 'Jobs', 'jobs', 17),
('ছবি', 'Gallery', 'gallery', 18);

-- ডিফল্ট সেটিংস
INSERT INTO settings (key_name, value, type) VALUES
('site_title', 'দেবীগঞ্জ সংবাদ', 'text'),
('site_url', 'http://debiganjsongbad.com', 'text'),
('site_description', 'দেবীগঞ্জের সর্বশেষ সংবাদ - বাংলা নিউজ পোর্টাল', 'textarea'),
('site_keywords', 'দেবীগঞ্জ, Debiganj, সংবাদ, নিউজ, বাংলা', 'text'),
('admin_email', 'admin@debiganjsongbad.com', 'text'),
('contact_email', 'contact@debiganjsongbad.com', 'text'),
('phone', '০১৭১২-৩৪৫৬৭৮', 'text'),
('address', 'দেবীগঞ্জ, পঞ্চগড়, বাংলাদেশ', 'text'),
('facebook_url', 'https://facebook.com/debiganjsongbad', 'text'),
('twitter_url', 'https://twitter.com/debiganjsongbad', 'text'),
('youtube_url', 'https://youtube.com/debiganjsongbad', 'text'),
('instagram_url', 'https://instagram.com/debiganjsongbad', 'text'),
('logo', '/assets/images/logo.png', 'image'),
('favicon', '/favicon.ico', 'image'),
('footer_text', '© ২০২৬ দেবীগঞ্জ সংবাদ। সর্বসত্ত্ব সংরক্ষিত।', 'text');