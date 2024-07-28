-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 28, 2024 at 10:30 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_lansurongnamanh`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `parent_id` int DEFAULT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories_posts`
--

CREATE TABLE `categories_posts` (
  `category_id` int NOT NULL,
  `post_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_12_09_045646_create_settings_table', 1),
(6, '2023_12_09_065715_create_contact_us_table', 1),
(7, '2023_12_14_101936_create_categories_table', 1),
(8, '2023_12_14_101944_create_posts_table', 1),
(9, '2023_12_15_091014_create_categories_posts_table', 1),
(10, '2024_07_14_141402_create_products_table', 1),
(11, '2024_07_28_092352_create_permission_tables', 1),
(12, '2024_07_28_092906_add_status_to_roles_table', 1),
(13, '2024_07_28_100802_add_description_and_status_to_permissions_table', 1),
(14, '2024_07_28_100849_add_description_to_roles_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `description`, `status`) VALUES
(1, 'User Manager', 'web', '2024-07-28 03:27:34', '2024-07-28 03:27:34', NULL, 1),
(2, 'Role Manager', 'web', '2024-07-28 03:27:34', '2024-07-28 03:27:34', NULL, 1),
(3, 'Permission Manager', 'web', '2024-07-28 03:27:34', '2024-07-28 03:27:34', NULL, 1),
(4, 'Products Manager', 'web', '2024-07-28 03:27:34', '2024-07-28 03:27:34', NULL, 1),
(5, 'Contact Manager', 'web', '2024-07-28 03:27:34', '2024-07-28 03:27:34', NULL, 1),
(6, 'Setting Manager', 'web', '2024-07-28 03:27:34', '2024-07-28 03:27:34', NULL, 1),
(7, 'News Manager', 'web', '2024-07-28 03:27:34', '2024-07-28 03:27:34', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `source` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` longtext COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` tinyint NOT NULL DEFAULT '1',
  `is_hot` tinyint NOT NULL DEFAULT '0',
  `publish_date` date DEFAULT NULL,
  `created_by` int NOT NULL,
  `like_number` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `des` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(15,2) NOT NULL,
  `bg_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_hot` tinyint NOT NULL DEFAULT '0',
  `status` tinyint NOT NULL DEFAULT '1',
  `created_by` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` int NOT NULL DEFAULT '1',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`, `status`, `description`) VALUES
(1, 'ADMIN', 'web', '2024-07-28 03:27:40', '2024-07-28 03:27:40', 1, NULL),
(2, 'USER', 'web', '2024-07-28 03:27:40', '2024-07-28 03:27:40', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_by` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `data`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Home', 'a:5:{i:0;a:2:{s:4:\"name\";s:7:\"General\";s:4:\"data\";a:7:{s:10:\"site_title\";s:46:\"[:vi]Nam Anh Shop[:vi][:en]Nam Anh Online[:en]\";s:4:\"logo\";s:39:\"/uploads/settings/home/general/logo.jpg\";s:7:\"favicon\";s:42:\"/uploads/settings/home/general/logo-sm.jpg\";s:7:\"privacy\";a:3:{s:4:\"name\";s:77:\"[:vi]ĐOÀN LÂN SƯ RỒNG NAM ANH[:vi][:en]NAM ANH LION - DRAGON DANCE[:en]\";s:7:\"address\";s:162:\"[:vi]47 xóm 7 Lại Thế , Phú Thượng, Tỉnh Thừa Thiên Huế, Vietnam.[:vi][:en]47 Hamlet 7 Lai The, Phu Thuong, Thua Thien Hue Province, Vietnam.[:en]\";s:5:\"phone\";s:15:\"+84 77 442 6342\";}s:13:\"footer_center\";a:4:{s:7:\"content\";s:65:\"[:vi]Nội dung: Mr. Ben Đơ[:vi][:en]Content: Mr. Ben Đơ[:en]\";s:8:\"products\";s:136:\"[:vi]Chuyên cung cấp các sản phẩm lân sư rồng.[:vi][:en]Specializing in providing lion dance and dragon dance products.[:en]\";s:7:\"service\";s:174:\"[:vi]Nhận nhảy Show cưới hỏi, tân gia, động thổ...[:vi][:en]Accept dance performances for wedding parties, housewarming parties, groundbreaking parties...[:en]\";s:5:\"email\";s:16:\"namanh@gmail.com\";}s:7:\"contact\";a:4:{s:7:\"link_fb\";s:37:\"https://www.facebook.com/cao.dinhngoc\";s:12:\"link_page_fb\";s:55:\"https://www.facebook.com/profile.php?id=100063458805238\";s:7:\"link_tt\";s:67:\"https://www.tiktok.com/@bendo2684?is_from_webapp=1&sender_device=pc\";s:7:\"hotline\";s:15:\"+84 77 442 6342\";}s:13:\"contact_modal\";a:3:{s:4:\"text\";s:37:\"[:vi]Liên hệ[:vi][:en]Contact[:en]\";s:8:\"question\";s:71:\"[:vi]Bạn có câu hỏi gì?[:vi][:en]Do you have any questions?[:en]\";s:6:\"answer\";s:318:\"[:vi]Vui lòng điền vào biểu mẫu và cho chúng tôi biết về mối quan tâm của bạn. Chúng tôi sẽ cố gắng hết sức để cung cấp các giải đáp cho các bạn.[:vi][:en]Please fill out the form and let us know about your concerns. We will do our best to provide you with answers.[:en]\";}}}i:1;a:2:{s:4:\"name\";s:10:\"Slide Sec.\";s:4:\"data\";a:3:{i:0;a:3:{s:3:\"img\";s:37:\"/assets/images/slides-home/slide1.jpg\";s:5:\"title\";s:40:\"[:vi]Hình ảnh 1[:vi][:en]Image 1[:en]\";s:9:\"img_small\";s:43:\"/assets/images/slides-home/slide1-small.jpg\";}i:1;a:3:{s:3:\"img\";s:37:\"/assets/images/slides-home/slide2.jpg\";s:5:\"title\";s:40:\"[:vi]Hình ảnh 2[:vi][:en]Image 2[:en]\";s:9:\"img_small\";s:43:\"/assets/images/slides-home/slide1-small.jpg\";}i:2;a:3:{s:3:\"img\";s:37:\"/assets/images/slides-home/slide3.jpg\";s:5:\"title\";s:40:\"[:vi]Hình ảnh 3[:vi][:en]Image 3[:en]\";s:9:\"img_small\";s:43:\"/assets/images/slides-home/slide1-small.jpg\";}}}i:2;a:2:{s:4:\"name\";s:9:\"News Sec.\";s:4:\"data\";a:2:{s:10:\"main_title\";s:60:\"[:vi]Bài viết nổi bật[:vi][:en]Featured articles[:en]\";s:14:\"news_page_text\";s:42:\"[:vi]Xem tất cả[:vi][:en]View all[:en]\";}}i:3;a:2:{s:4:\"name\";s:13:\"Products Sec.\";s:4:\"data\";a:3:{s:10:\"main_title\";s:61:\"[:vi]Sản phẩm nổi bật[:vi][:en]Featured products[:en]\";s:9:\"more_text\";s:38:\"[:vi]Xem thêm[:vi][:en]View more[:en]\";s:18:\"products_page_text\";s:42:\"[:vi]Xem tất cả[:vi][:en]View all[:en]\";}}i:4;a:2:{s:4:\"name\";s:10:\"About Sec.\";s:4:\"data\";a:4:{s:10:\"main_title\";s:63:\"[:vi]Lân Sư Rồng Nam Anh[:vi][:en]NAM ANH LION DRAGON [:en]\";s:8:\"overview\";a:2:{s:5:\"title\";s:62:\"[:vi]Lân Sư Rồng Nam Anh[:vi][:en]Nam Anh Lion Dragon[:en]\";s:7:\"content\";s:997:\"[:vi]Xin chào và chào mừng bạn đến với Nam Anh! Chúng tôi tự hào là địa chỉ tin cậy trong lĩnh vực cung cấp các sản phẩm và dịch vụ nhảy show lân sư rồng chất lượng cao. Với cam kết mang đến những trải nghiệm đầy ấn tượng và sự chuyên nghiệp, đoàn lân sư rồng luôn lắng nghe và đồng hành cùng bạn trong mọi sự kiện đặc biệt. Hãy cùng chúng tôi tạo nên những khoảnh khắc đáng nhớ và mang đến sự may mắn, thịnh vượng cho mỗi chặng đường của bạn![:vi][:en]Hello and welcome to Nam Anh! We are proud to be a trusted address in the field of providing high quality lion dance products and services. With a commitment to bring impressive experiences and professionalism, the lion dance troupe always listens and accompanies you in every special event. Let\'s create memorable moments with us and bring luck and prosperity to every step of your journey![:en]\";}s:8:\"products\";a:2:{s:5:\"title\";s:60:\"[:vi]Cung Cấp Sản Phẩm [:vi][:en]Provide products[:en]\";s:7:\"content\";s:846:\"[:vi]Khám phá bộ sưu tập lân sư rồng tinh xảo, chất lượng hàng đầu tại shop của chúng tôi - nơi đam mê và truyền thống hội tụ! Từ những mẫu lân sư rồng sống động đến các phụ kiện biểu diễn hoàn hảo, chúng tôi cam kết mang đến cho bạn những sản phẩm xuất sắc để tỏa sáng trong mọi sự kiện. Hãy để chúng tôi đồng hành cùng bạn trong mỗi bước nhảy đầy nghệ thuật và ý nghĩa![:vi][:en]Discover our top quality, spirited lion and dragon collection at our store - where passion and tradition meet! From live lion and dragon models to perfect performance accessories, we are committed to bringing you sharp production products to shine in every event. Let us accompany you in every dance step full of art and meaning![:en]\";}s:7:\"service\";a:2:{s:5:\"title\";s:59:\"[:vi]Dịch Vụ Múa Lân[:vi][:en]Lion Dance Service[:en]\";s:7:\"content\";s:857:\"[:vi]Biến mỗi sự kiện của bạn thành một màn trình diễn đầy sắc màu và sôi động với dịch vụ nhảy lân sư rồng chuyên nghiệp của chúng tôi! Dù là lễ khai trương, tân gia hay các sự kiện đặc biệt, đội ngũ lân sư rồng giàu kinh nghiệm sẽ mang đến may mắn, thịnh vượng và niềm vui cho bạn cùng khách mời. Hãy để chúng tôi góp phần tạo nên những khoảnh khắc đáng nhớ và ấn tượng không thể quên![:vi][:en]Turn any event into a colorful and vibrant spectacle with our professional lion dance services! Whether it is a grand opening, housewarming or a special event, our experienced lion dance team will bring good luck, prosperity and joy to you and your guests. Let us advise you on creating something memorable and unforgettable![:en]\";}}}}', 1, 1, NULL, NULL),
(2, 'About', 'a:3:{i:0;a:2:{s:4:\"name\";s:19:\"Life Our Value Sec.\";s:4:\"data\";a:2:{s:7:\"main_bg\";s:36:\"/uploads/settings/about/1920x898.png\";s:7:\"content\";a:5:{i:0;a:3:{s:5:\"title\";s:39:\"[:vi]TỔNG QUAN[:vi][:en]OVERVIEW[:en]\";s:7:\"content\";s:1746:\"[:vi]<p>Tại Nam Anh Shop, chúng tôi tự hào là điểm đến hàng đầu cho những sản phẩm và dịch vụ liên quan đến lân sư rồng. Với kinh nghiệm nhiều năm trong ngành, chúng tôi cung cấp các bộ đồ lân sư rồng chất lượng cao, được chế tác tỉ mỉ và mang đậm bản sắc văn hóa truyền thống. Bên cạnh đó, chúng tôi còn nhận tổ chức các show nhảy lân sư rồng cho các sự kiện quan trọng như khai trương, đám cưới, và các lễ hội.</p> <p>Chúng tôi cam kết mang đến cho bạn những sản phẩm và dịch vụ tuyệt vời nhất, từ những bộ đồ lân sư rồng đầy màu sắc và tinh xảo, đến những màn biểu diễn ấn tượng và chuyên nghiệp. Đội ngũ nghệ nhân của chúng tôi luôn sẵn sàng đồng hành và làm hài lòng khách hàng bằng sự nhiệt huyết và tâm huyết trong từng sản phẩm và dịch vụ.</p>[:vi][:en]<p>At Nam Anh Shop, we pride ourselves on being a leading destination for products and services related to lion and dragon dance. With many years of experience in the industry, we offer high-quality lion and dragon dance costumes, meticulously crafted and rich in traditional cultural significance. In addition, we provide lion and dragon dance shows for important events such as grand openings, weddings, and festivals.</p> <p>We are committed to delivering the best products and services, from vibrant and exquisite lion and dragon dance costumes to impressive and professional performances. Our team of artisans is always ready to accompany and satisfy our customers with enthusiasm and dedication in every product and service.</p>[:en]\";s:2:\"bg\";s:36:\"/uploads/settings/about/1920x898.png\";}i:1;a:3:{s:5:\"title\";s:44:\"[:vi]SẢN PHẨM[:vi][:en]OUR PRODUCTS[:en]\";s:7:\"content\";s:806:\"[:vi]<p>Khám phá bộ sưu tập đồ lân sư rồng độc đáo tại Nam Anh Shop! Chúng tôi cung cấp các bộ trang phục lân sư rồng được chế tác tinh xảo, mang đậm bản sắc văn hóa truyền thống. Mỗi sản phẩm của chúng tôi được thiết kế với sự chú trọng đến chi tiết và chất lượng, nhằm mang đến cho bạn trải nghiệm biểu diễn hoàn hảo và ấn tượng.</p>[:vi][:en]<p>Explore our unique collection of lion and dragon dance costumes at Nam Anh Shop! We offer intricately crafted lion and dragon dance outfits that embody traditional cultural significance. Each of our products is designed with attention to detail and quality, aiming to provide you with a perfect and impressive performance experience.</p>[:en]\";s:2:\"bg\";s:36:\"/uploads/settings/about/1920x898.png\";}i:2;a:3:{s:5:\"title\";s:43:\"[:vi]DỊCH VỤ[:vi][:en]OUR SERVICES[:en]\";s:7:\"content\";s:1216:\"[:vi]<p>Tại Nam Anh Shop, chúng tôi cung cấp dịch vụ biểu diễn lân sư rồng chuyên nghiệp cho các sự kiện đặc biệt. Chúng tôi nhận tổ chức các show nhảy lân sư rồng cho khai trương, đám cưới, và các lễ hội, mang đến không khí sôi động và đầy màu sắc cho mọi dịp. Đội ngũ nghệ nhân của chúng tôi có kinh nghiệm phong phú và sẵn sàng tùy chỉnh chương trình biểu diễn để phù hợp với nhu cầu và yêu cầu của bạn. Chúng tôi cam kết mang đến một trải nghiệm biểu diễn đáng nhớ, giúp sự kiện của bạn trở nên thật đặc biệt và ấn tượng.</p>[:vi][:en]<p>At Nam Anh Shop, we offer professional lion and dragon dance performance services for special events. We organize lion and dragon dance shows for grand openings, weddings, and festivals, bringing vibrant and dynamic energy to every occasion. Our team of skilled performers has extensive experience and is ready to customize the performance to meet your needs and preferences. We are committed to delivering a memorable performance experience that makes your event truly special and impressive.</p>[:en]\";s:2:\"bg\";s:36:\"/uploads/settings/about/1920x898.png\";}i:3;a:3:{s:5:\"title\";s:37:\"[:vi]LỢI ÍCH[:vi][:en]BENEFIT[:en]\";s:7:\"content\";s:1789:\"[:vi]<p>Khi chọn Nam Anh Shop, bạn sẽ trải nghiệm nhiều lợi ích nổi bật. Chúng tôi cung cấp các sản phẩm đồ lân sư rồng chất lượng cao, được chế tác với sự tinh xảo và chú trọng đến từng chi tiết. Đội ngũ nghệ nhân giàu kinh nghiệm của chúng tôi đảm bảo rằng mỗi sản phẩm đều đạt tiêu chuẩn xuất sắc, mang lại sự hài lòng tuyệt đối cho khách hàng.</p><p>Ngoài ra, dịch vụ biểu diễn của chúng tôi mang đến những màn trình diễn ấn tượng và chuyên nghiệp, góp phần làm cho sự kiện của bạn trở nên đặc biệt hơn. Chúng tôi cam kết đồng hành cùng bạn từ khâu chuẩn bị đến thực hiện, đảm bảo mọi yêu cầu và mong muốn của bạn được đáp ứng một cách tốt nhất. Chọn Nam Anh Shop để nhận được sự phục vụ tận tâm và sản phẩm chất lượng, giúp sự kiện của bạn trở thành một trải nghiệm đáng nhớ.</p>[:vi][:en]<p>When you choose Nam Anh Shop, you will experience several outstanding benefits. We offer high-quality lion and dragon dance costumes, crafted with precision and attention to detail. Our team of experienced artisans ensures that each product meets excellent standards, providing complete satisfaction to our customers.</p><p>Additionally, our performance services deliver impressive and professional shows that enhance the uniqueness of your event. We are committed to supporting you from preparation to execution, ensuring that all your requests and preferences are met to the highest standards. Choose Nam Anh Shop for dedicated service and top-quality products, making your event a memorable experience.</p>[:en]\";s:2:\"bg\";s:36:\"/uploads/settings/about/1920x898.png\";}i:4;a:3:{s:5:\"title\";s:48:\"[:vi]VÀ HƠN THẾ NỮA[:vi][:en]AND MORE[:en]\";s:7:\"content\";s:878:\"[:vi]<p>Chúng tôi còn nhiều hơn nữa, vẫn còn nhiều điều thú vị để khám phá</p> <p>\r\nChúng tôi luôn sẵn sàng hỗ trợ và đáp ứng mọi yêu cầu của bạn. Để biết thêm thông tin về sản phẩm, dịch vụ, hoặc để đặt lịch cho một sự kiện, vui lòng liên hệ với chúng tôi. Đội ngũ nhân viên của Nam Anh Shop sẽ tận tình giúp đỡ bạn và đảm bảo bạn nhận được sự phục vụ tốt nhất.</p>[:vi][:en]<p>There is much more to discover, and plenty of exciting things to explore.</p> <p>We are always ready to assist and meet your needs. For more information about our products, services, or to schedule an event, please contact us. The team at Nam Anh Shop is dedicated to providing you with the best service and ensuring that your needs are met with utmost care.</p>[:en]\";s:2:\"bg\";s:36:\"/uploads/settings/about/1920x898.png\";}}}}i:1;a:2:{s:4:\"name\";s:18:\"Life With You Sec.\";s:4:\"data\";a:2:{s:10:\"main_title\";s:42:\"[:vi]GIỚI THIỆU[:vi][:en]ABOUT US[:en]\";s:5:\"video\";s:18:\"/videos/video2.mp4\";}}i:2;a:2:{s:4:\"name\";s:21:\"Life How We Hire Sec.\";s:4:\"data\";a:2:{s:10:\"main_title\";s:72:\"[:vi]CÂU HỎI THƯỜNG GẶP[:vi][:en]FREQUENTLY ASKED QUESTIONS[:en]\";s:4:\"data\";a:3:{s:8:\"question\";a:4:{i:0;a:2:{s:5:\"title\";s:143:\"[:vi]Bạn có nhận biểu diễn lân sư rồng cho đám cưới không?[:vi][:en]Do you perform lion and dragon dances for weddings?[:en]\";s:6:\"answer\";s:169:\"[:vi]Có, chúng tôi chuyên nhận biểu diễn lân sư rồng cho đám cưới.[:vi][:en]Yes, we specialize in performing lion and dragon dances for weddings.[:en]\";}i:1;a:2:{s:5:\"title\";s:125:\"[:vi]Giá biểu diễn lân sư rồng là bao nhiêu?[:vi][:en]How much does a lion and dragon dance performance cost?[:en]\";s:6:\"answer\";s:275:\"[:vi]Giá biểu diễn phụ thuộc vào loại hình và thời gian biểu diễn. Vui lòng liên hệ để nhận báo giá chi tiết.[:vi][:en]The cost of a performance depends on the type and duration of the performance. Please contact us for a detailed quote.[:en]\";}i:2;a:2:{s:5:\"title\";s:115:\"[:vi]Bạn có biểu diễn cho sự kiện tân gia không?[:vi][:en]Do you perform for housewarming events?[:en]\";s:6:\"answer\";s:167:\"[:vi]Có, chúng tôi nhận biểu diễn lân sư rồng cho các sự kiện tân gia.[:vi][:en]Yes, we perform lion and dragon dances for housewarming events.[:en]\";}i:3;a:2:{s:5:\"title\";s:169:\"[:vi]Cần đặt lịch trước bao lâu để thuê biểu diễn lân sư rồng?[:vi][:en]How far in advance should I book a lion and dragon dance performance?[:en]\";s:6:\"answer\";s:199:\"[:vi]Chúng tôi khuyến khích đặt lịch trước ít nhất 2 tuần để đảm bảo có sẵn lịch.[:vi][:en]We recommend booking at least 2 weeks in advance to ensure availability.[:en]\";}}s:9:\"images_kh\";a:4:{i:0;s:25:\"/images/khachhang/kh1.jpg\";i:1;s:25:\"/images/khachhang/kh1.jpg\";i:2;s:25:\"/images/khachhang/kh1.jpg\";i:3;s:25:\"/images/khachhang/kh1.jpg\";}s:4:\"info\";a:8:{s:5:\"title\";s:141:\"[:vi]Nếu bạn có bất kì thắc mắc nào hãy liên hệ với chúng tôi[:vi][:en]If you have any questions, please contact us[:en]\";s:11:\"title_small\";s:65:\"[:vi]Thông tin hỗ trợ:[:vi][:en]Supporting Information:[:en]\";s:16:\"note_title_small\";s:228:\"[:vi]Bạn có thể nhấp vào các icon nằm phía góc phải dưới cùng màn hình để kết nối với chúng tôi[:vi][:en]You can click on the icons in the bottom right corner of the screen to connect with us[:en]\";s:13:\"hotline_title\";s:84:\"[:vi]Gọi tư vấn đặt hàng online:[:vi][:en]Call online ordering advice:[:en]\";s:10:\"zalo_title\";s:57:\"[:vi]Liên hệ qua zalo:[:vi][:en]Contact via zalo:[:en]\";s:8:\"fb_title\";s:65:\"[:vi]Liên hệ qua Facebook:[:vi][:en]Contact via Facebook:[:en]\";s:13:\"fanpage_title\";s:36:\"[:vi]Fanpage:[:vi][:en]Fanpage:[:en]\";s:14:\"customer_title\";s:40:\"[:vi]Khách hàng[:vi][:en]Customer[:en]\";}}}}}', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `is_lock` tinyint NOT NULL DEFAULT '0',
  `first_login` tinyint NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `status`, `is_lock`, `first_login`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Nam Anh Shop', 'namanhshop@gmail.com', NULL, '$2y$10$5AMQ1CH7Qsh5Tzq5.E86POP/35jIyTj5tLoTutipTx4qWc5FbZWyi', 1, 0, 0, NULL, '2024-07-28 03:27:40', '2024-07-28 03:29:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
