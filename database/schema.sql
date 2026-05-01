-- ═══════════════════════════════════════════════════════════════
-- Expo Cyprus — Database Schema v1.0
-- Charset: utf8mb4_unicode_ci
-- ═══════════════════════════════════════════════════════════════

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ── Admin Users ──────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `admin_users` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name`          VARCHAR(120) NOT NULL,
    `email`         VARCHAR(180) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `role`          ENUM('admin','editor') NOT NULL DEFAULT 'editor',
    `status`        ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `last_login`    DATETIME NULL,
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Pages ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `pages` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug`          VARCHAR(200) NOT NULL UNIQUE,
    `title_tr`      VARCHAR(250) NOT NULL,
    `title_en`      VARCHAR(250) NOT NULL,
    `content_tr`    LONGTEXT,
    `content_en`    LONGTEXT,
    `meta_title_tr` VARCHAR(80),
    `meta_title_en` VARCHAR(80),
    `meta_desc_tr`  VARCHAR(180),
    `meta_desc_en`  VARCHAR(180),
    `og_image`      VARCHAR(300),
    `status`        ENUM('published','draft') NOT NULL DEFAULT 'published',
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Services ──────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `services` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug`          VARCHAR(200) NOT NULL UNIQUE,
    `title_tr`      VARCHAR(250) NOT NULL,
    `title_en`      VARCHAR(250) NOT NULL,
    `summary_tr`    TEXT,
    `summary_en`    TEXT,
    `content_tr`    LONGTEXT,
    `content_en`    LONGTEXT,
    `icon`          VARCHAR(300),
    `image`         VARCHAR(300),
    `sort_order`    TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `status`        ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `meta_title_tr` VARCHAR(80),
    `meta_title_en` VARCHAR(80),
    `meta_desc_tr`  VARCHAR(180),
    `meta_desc_en`  VARCHAR(180),
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Fairs ─────────────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `fairs` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug`          VARCHAR(200) NOT NULL UNIQUE,
    `name_tr`       VARCHAR(250) NOT NULL,
    `name_en`       VARCHAR(250) NOT NULL,
    `summary_tr`    TEXT,
    `summary_en`    TEXT,
    `content_tr`    LONGTEXT,
    `content_en`    LONGTEXT,
    `next_date`     DATE NULL,
    `end_date`      DATE NULL,
    `location`      VARCHAR(300),
    `image_hero`    VARCHAR(300),
    `sort_order`    TINYINT UNSIGNED NOT NULL DEFAULT 0,
    `status`        ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `meta_title_tr` VARCHAR(80),
    `meta_title_en` VARCHAR(80),
    `meta_desc_tr`  VARCHAR(180),
    `meta_desc_en`  VARCHAR(180),
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Catalog Items ────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `catalog_items` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug`          VARCHAR(200) NOT NULL UNIQUE,
    `client`        VARCHAR(200),
    `fair_name`     VARCHAR(200),
    `year`          SMALLINT UNSIGNED,
    `sqm`           SMALLINT UNSIGNED,
    `stand_type`    ENUM('modular','custom','hybrid') DEFAULT 'custom',
    `category`      VARCHAR(100),
    `description`   TEXT,
    `image_main`    VARCHAR(300),
    `gallery_json`  JSON,
    `status`        ENUM('active','inactive') NOT NULL DEFAULT 'active',
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_category`   (`category`),
    INDEX `idx_stand_type` (`stand_type`),
    INDEX `idx_sqm`        (`sqm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Blog Posts ───────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `blog_posts` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `slug`          VARCHAR(250) NOT NULL,
    `lang`          ENUM('tr','en') NOT NULL DEFAULT 'tr',
    `title`         VARCHAR(300) NOT NULL,
    `excerpt`       TEXT,
    `content`       LONGTEXT,
    `image`         VARCHAR(300),
    `author`        VARCHAR(120) DEFAULT 'Expo Cyprus',
    `category`      VARCHAR(100),
    `tags`          VARCHAR(500),
    `status`        ENUM('published','draft') NOT NULL DEFAULT 'draft',
    `meta_title`    VARCHAR(80),
    `meta_desc`     VARCHAR(180),
    `published_at`  DATETIME NULL,
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY `uq_slug_lang` (`slug`, `lang`),
    INDEX `idx_lang_status` (`lang`, `status`),
    INDEX `idx_published_at` (`published_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Form Submissions ─────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `form_submissions` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `form_type`     VARCHAR(50) NOT NULL,
    `data_json`     JSON NOT NULL,
    `source_page`   VARCHAR(300),
    `ip`            VARCHAR(45),
    `user_agent`    VARCHAR(500),
    `is_read`       TINYINT(1) NOT NULL DEFAULT 0,
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX `idx_form_type`  (`form_type`),
    INDEX `idx_is_read`    (`is_read`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Media Files ──────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `media_files` (
    `id`            INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `filename`      VARCHAR(300) NOT NULL,
    `original`      VARCHAR(300) NOT NULL,
    `path`          VARCHAR(400) NOT NULL,
    `type`          VARCHAR(100),
    `size`          INT UNSIGNED,
    `folder`        VARCHAR(100) DEFAULT 'images',
    `uploaded_by`   INT UNSIGNED DEFAULT 0,
    `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_folder` (`folder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Site Settings ─────────────────────────────────────────────────
CREATE TABLE IF NOT EXISTS `site_settings` (
    `id`         INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `key`        VARCHAR(100) NOT NULL UNIQUE,
    `value`      TEXT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
