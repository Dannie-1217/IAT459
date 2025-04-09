-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2025 at 04:25 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pet_adoption`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption_records`
--

CREATE TABLE `adoption_records` (
  `user_id` int(5) NOT NULL,
  `pet_id` int(5) NOT NULL,
  `adopted_before` varchar(20) NOT NULL,
  `other_pets` varchar(20) NOT NULL,
  `suitable_living_space` varchar(20) NOT NULL,
  `reason_for_adoption` text NOT NULL,
  `adoption_date` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adoption_records`
--

INSERT INTO `adoption_records` (`user_id`, `pet_id`, `adopted_before`, `other_pets`, `suitable_living_space`, `reason_for_adoption`, `adoption_date`, `status`) VALUES
(10019, 10000, 'Yes', 'Yes', 'Yes', 'Dog is cute', '2025-04-02', 'Processing'),
(10019, 10001, 'Yes', 'Yes', 'Yes', 'Cat is cute, this is a cat right?', '2025-04-02', 'Approve'),
(10019, 10003, 'Yes', 'Yes', 'Yes', 'Rabbit is cute', '2025-04-06', 'Approve'),
(10019, 10005, 'Yes', 'Yes', 'Yes', 'To feed my cat', '2025-04-06', 'Approve'),
(10019, 10077, 'Yes', 'Yes', 'Yes', 'Rough Collie is cute', '2025-04-07', 'Declined'),
(10019, 10039, 'Yes', 'Yes', 'Yes', 'I do not like bunny actually. But I have no idea why I want this one.', '2025-04-07', 'Processing'),
(10026, 10012, 'Yes', 'Yes', 'Yes', 'He looks cool!', '2025-04-08', 'Approved'),
(10019, 10078, 'Yes', 'Yes', 'Yes', 'I want to eat him.', '2025-04-08', 'Approved'),
(10019, 10077, 'Yes', 'Yes', 'Yes', 'She is cute', '2025-04-09', 'Processing'),
(10019, 10039, 'Yes', 'Yes', 'Yes', 'Cute', '2025-04-09', 'Processing'),
(10019, 10036, 'Yes', 'Yes', 'Yes', 'For eat', '2025-04-09', 'Approved'),
(10028, 10036, 'Yes', 'Yes', 'Yes', 'cute', '2025-04-09', 'Approved'),
(10019, 10071, 'Yes', 'Yes', 'Yes', 'he is cute', '2025-04-09', 'Processing');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `user_id` int(5) NOT NULL,
  `pet_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`user_id`, `pet_id`) VALUES
(10019, 10000),
(10019, 10003),
(10019, 10005),
(10019, 10071),
(10019, 10077),
(10023, 10033),
(10023, 10077),
(10026, 10012),
(10026, 10077);

-- --------------------------------------------------------

--
-- Table structure for table `pet`
--

CREATE TABLE `pet` (
  `pet_id` int(5) NOT NULL,
  `pet_name` varchar(20) NOT NULL,
  `location` varchar(50) NOT NULL,
  `pet_type` varchar(20) NOT NULL,
  `post_date` date NOT NULL,
  `description` text NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet`
--

INSERT INTO `pet` (`pet_id`, `pet_name`, `location`, `pet_type`, `post_date`, `description`, `status`) VALUES
(10000, 'Bella', 'Vancouver', 'dog', '2025-01-01', 'Bella is a friendly and well-trained golden retriever who loves playing fetch in the park. She is great with kids and other dogs, perfect family pet.', 'Processing'),
(10001, 'Whiskers', 'Burnaby', 'cat', '2025-01-03', 'Whiskers is a gentle gray tabby cat who enjoys lounging by the window and soaking up the sun. She loves cuddles and is very affectionate.', 'Adopted'),
(10002, 'Thunder', 'Richmond', 'horse', '2025-01-04', 'Thunder is a majestic black stallion with a calm temperament. He is trained for trail rides and enjoys open pastures. Ideal for experienced riders.', 'Available'),
(10003, 'Fluffy', 'Coquitlam', 'rabbit', '2025-01-07', 'Fluffy is a cute white bunny with floppy ears who loves being petted. She enjoys hopping around and munching on fresh greens and carrots.', 'Adopted'),
(10004, 'Sunny', 'Surrey', 'bird', '2025-01-08', 'Sunny is a bright yellow parrot known for singing beautiful melodies every morning. He is social and can mimic a few words with regular interaction.', 'Available'),
(10005, 'Goldie', 'North Vancouver', 'fish', '2025-01-12', 'Goldie is a graceful goldfish with shimmering scales. Easy to care for, she adds a calming presence to any aquarium.', 'Adopted'),
(10006, 'Oreo', 'New Westminster', 'cat', '2025-01-15', 'Oreo is a playful black and white kitten who loves chasing toys and exploring new spaces. Very friendly and gets along with other pets.', 'Available'),
(10007, 'Rocky', 'Coquitlam', 'dog', '2025-01-19', 'Rocky is an energetic husky with striking blue eyes. He loves outdoor adventures, long walks, and playing with his favorite ball.', 'Available'),
(10008, 'Shadow', 'Delta', 'horse', '2025-01-22', 'Shadow is a beautiful brown mare with a gentle personality. She is perfect for light riding and enjoys quiet time in the stable or out in the field.', 'Available'),
(10009, 'Nibbles', 'Langley', 'rabbit', '2025-01-28', 'Nibbles is a sweet little bunny who loves attention and treats. She enjoys being held and will happily sit on your lap while nibbling on vegetables.', 'Available'),
(10010, 'Daisy', 'Vancouver', 'dog', '2025-02-01', 'Daisy is a sweet golden doodle who loves long walks along the seawall. Friendly with kids and other dogs, perfect for a family.', 'Available'),
(10011, 'Milo', 'Burnaby', 'cat', '2025-02-03', 'Milo is an adventurous orange tabby who loves exploring high places. He is food-motivated and purrs loudly when happy.', 'Available'),
(10012, 'Spirit', 'Richmond', 'horse', '2025-02-05', 'Spirit is a beautiful young black horse, ideal for trail rides. Calm and bonds quickly with gentle riders.', 'Adopted'),
(10013, 'Mochi', 'Coquitlam', 'rabbit	', '2025-02-06', 'Mochi is a fluffy grey bunny who enjoys fresh greens and hopping around the living room. Loves being hand-fed treats.\n', 'Available'),
(10014, 'Kiwi', 'Surrey', 'bird', '2025-02-08', 'Kiwi is a talkative green parakeet that enjoys learning new words. Social and loves sitting on your shoulder.', 'Available'),
(10015, 'Bubbles', 'North Vancouver', 'fish', '2025-02-10', 'Bubbles is a vibrant betta fish with long flowing fins. Peaceful and easy to care for, perfect for any small tank.', 'Available'),
(10016, 'Luna', 'New Westminster', 'cat', '2025-02-12', 'Luna is a shy black cat who warms up quickly with treats. Loves chin scratches and sunbathing by the window.', 'Available'),
(10017, 'Max', 'Coquitlam', 'dog', '2025-02-14', 'Max is a high-energy Labrador retriever who loves swimming and fetch. Always ready for outdoor adventures.', 'Available'),
(10018, 'Maple', 'Delta', 'horse', '2025-02-17', 'Maple is a gentle brown mare, perfect for beginner riders. She is calm and enjoys peaceful walks through fields and forests.', 'Available'),
(10019, 'Peanut', 'Langley', 'rabbit', '2025-02-19', 'Peanut is a small tan bunny who loves cuddles and chewing on cardboard toys. Great with kids.', 'Available'),
(10020, 'Sky', 'Vancouver', 'bird', '2025-02-20', 'Sky is a blue budgie with a sweet singing voice. Loves sitting by the window and watching the world outside.', 'Available'),
(10021, 'Coral', 'Burnaby', 'fish', '2025-02-22', 'Coral is a bright neon tetra, perfect for community tanks. Loves swimming in schools and creates a colorful display.', 'Available'),
(10022, 'Tiger', 'Richmond', 'cat', '2025-02-25', 'Tiger is a playful tabby cat who loves climbing and exploring. Gets along well with other pets.', 'Available'),
(10023, 'Bruno', 'Coquitlam', 'dog', '2025-02-27', 'Bruno is a loyal German Shepherd who is protective but loving. Excellent family dog with basic obedience training.', 'Available'),
(10024, 'Hazel', 'Surrey', 'rabbit', '2025-03-01', 'Hazel is a gentle brown rabbit who enjoys being brushed. Prefers quiet environments and soft bedding.', 'Available'),
(10025, 'Mango', 'North Vancouver', 'bird', '2025-03-03', 'Mango is a colorful sun conure with a playful personality. Loves fruit treats and knows a few words.', 'Available'),
(10026, 'Neptune', 'New Westminster', 'fish', '2025-03-05', 'Neptune is a large koi fish with stunning orange and white patterns. Peaceful and ideal for ponds.', 'Available'),
(10027, 'Olive', 'Coquitlam', 'cat', '2025-03-07', 'Olive is a sweet rescue cat with mismatched eyes. Loves sleeping in cozy corners and being brushed.', 'Available'),
(10028, 'Diesel', 'Delta', 'dog', '2025-03-09', 'Diesel is a strong Rottweiler with a calm demeanor. Great guard dog but gentle with family.', 'Available'),
(10029, 'Coco', 'Langley', 'rabbit', '2025-03-11', 'Coco is a curious black rabbit who enjoys exploring the backyard. Loves munching on lettuce and carrots.', 'Available'),
(10030, 'Blue', 'Vancouver', 'bird', '2025-03-12', 'Blue is a majestic macaw with bright blue feathers. Enjoys flying in open spaces and mimicking sounds.', 'Available'),
(10031, 'Marble', 'Burnaby', 'fish', '2025-03-14', 'Marble is a marble-patterned angelfish who adds elegance to any tank. Loves swimming through plants.', 'Available'),
(10032, 'Simba', 'Richmond', 'cat', '2025-03-16', 'Simba is a big fluffy Maine Coon who loves being the center of attention. Very social and good with children.', 'Available'),
(10033, 'Rocky', 'Coquitlam', 'dog', '2025-03-18', 'Rocky is a husky mix with endless energy. Enjoys hikes and outdoor play. Best suited for an active family.\n', 'Available'),
(10034, 'Snowball', 'Surrey', 'rabbit', '2025-03-20', 'Snowball is a pure white rabbit with red eyes. Very gentle and loves nibbling on apples.', 'Available'),
(10035, 'Lemon', 'North Vancouver', 'bird', '2025-03-22', 'Lemon is a small canary with a bright yellow coat. Known for singing sweet melodies every morning.', 'Available'),
(10036, 'Flash', 'New Westminster', 'fish', '2025-03-24', 'Flash is a speedy goldfish who loves racing around the tank. Very active and fun to watch.', 'Adopted'),
(10037, 'Bella', 'Coquitlam', 'cat', '2025-03-26', 'Bella is a loving Siamese cat who enjoys being close to people. Loves sitting on laps and purring for hours.', 'Available'),
(10038, 'Rex', 'Delta', 'dog', '2025-03-28', 'Rex is a border collie known for his intelligence and agility. Perfect for someone who loves training and outdoor activities.', 'Available'),
(10039, 'Carrot', 'Langley', 'rabbit', '2025-03-30', 'Carrot is an orange bunny who gets excited every time she sees her food bowl. Very friendly and loves to play.', 'Processing'),
(10071, 'Biscuit', 'Surrey', 'others', '2025-03-30', 'A playful and energetic hamster that loves to run on its wheel and explore its surroundings. Great for first-time pet owners.\r\n', 'Processing'),
(10077, 'Cross', 'Burnaby', 'dog', '2025-04-08', 'Cross is a very beautiful rough collie. She is very playful and gentle for other people. What\'s more, she is well trained and could be a very good friends for your kid!', 'Processing'),
(10078, 'Angus', 'Burnaby', 'others', '2025-04-08', 'Angus is a strong highland cattle. He has a huge horn and ready to ram to the people who wants to adopt him. Great!', 'Adopted');

-- --------------------------------------------------------

--
-- Table structure for table `pet_images`
--

CREATE TABLE `pet_images` (
  `pet_id` int(5) NOT NULL,
  `images` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_images`
--

INSERT INTO `pet_images` (`pet_id`, `images`) VALUES
(10000, '10000_Bella-1.webp'),
(10000, '10000_Bella-2.webp'),
(10000, '10000_Bella-3.webp'),
(10001, 'Whiskers-1.webp'),
(10001, 'Whiskers-2.webp'),
(10001, 'Whiskers-3.webp'),
(10001, 'Whiskers-4.webp'),
(10002, 'Thunder-1.jpg'),
(10002, 'Thunder-2.jpg'),
(10002, 'Thunder-3.jpg'),
(10003, 'Fluffy-1.webp'),
(10003, 'Fluffy-2.webp'),
(10003, 'Fluffy-3.webp'),
(10004, 'Sunny-1.webp'),
(10004, 'Sunny-2.webp'),
(10005, 'Goldie-1.webp'),
(10005, 'Goldie-2.webp'),
(10006, 'Oreo-1.webp'),
(10006, 'Oreo-2.webp'),
(10006, 'Oreo-3.webp'),
(10007, 'Rocky-1.webp'),
(10007, 'Rocky-2.webp'),
(10007, 'Rocky-3.webp'),
(10007, 'Rocky-4.webp'),
(10008, 'Shadow-1.webp'),
(10008, 'Shadow-2.webp'),
(10008, 'Shadow-3.webp'),
(10009, 'Nibbles-1.jpg'),
(10010, 'Daisy-1.jpg'),
(10010, 'Daisy-2.jpg'),
(10010, 'Daisy-3.jpg'),
(10010, 'Daisy-4.jpg'),
(10011, 'Milo-1.webp'),
(10011, 'Milo-2.webp'),
(10011, 'Milo-3.webp'),
(10011, 'Milo-4.webp'),
(10011, 'Milo-5.webp'),
(10012, 'Spirit-1.webp'),
(10012, 'Spirit-2.webp'),
(10012, 'Spirit-3.webp'),
(10012, 'Spirit-4.webp'),
(10012, 'Spirit-5.webp'),
(10013, 'Mochi-1.webp'),
(10013, 'Mochi-2.webp'),
(10013, 'Mochi-3.webp'),
(10014, 'Kiwi-1.webp'),
(10014, 'Kiwi-2.webp'),
(10014, 'Kiwi-3.webp'),
(10014, 'Kiwi-4.webp'),
(10015, 'Bubbles-1.webp'),
(10015, 'Bubbles-2.webp'),
(10016, 'Luna-1.webp'),
(10016, 'Luna-2.webp'),
(10016, 'Luna-3.webp'),
(10017, 'Max-1.webp'),
(10017, 'Max-2.webp'),
(10017, 'Max-3.webp'),
(10018, 'Maple-1.jpg'),
(10018, 'Maple-2.jpg'),
(10018, 'Maple-3.jpg'),
(10019, 'Peanut-1.jpg'),
(10019, 'Peanut-2.jpg'),
(10019, 'Peanut-3.jpg'),
(10020, 'Sky-1.webp'),
(10020, 'Sky-2.webp'),
(10020, 'Sky-3.webp'),
(10021, 'Coral-1.webp'),
(10021, 'Coral-2.webp'),
(10022, 'Tiger-1.webp'),
(10022, 'Tiger-2.webp'),
(10022, 'Tiger-3.webp'),
(10023, 'Bruno-1.webp'),
(10023, 'Bruno-2.webp'),
(10023, 'Bruno-3.webp'),
(10024, 'Hazel-1.webp'),
(10024, 'Hazel-2.webp'),
(10024, 'Hazel-3.webp'),
(10024, 'Hazel-4.webp'),
(10025, 'Mango-1.webp'),
(10025, 'Mango-2.webp'),
(10025, 'Mango-3.webp'),
(10026, 'Neptune.jpeg'),
(10027, 'Olive-1.webp'),
(10027, 'Olive-2.webp'),
(10027, 'Olive-3.webp'),
(10028, 'Diesel-1.webp'),
(10028, 'Diesel-2.webp'),
(10028, 'Diesel-3.webp'),
(10028, 'Diesel-4.webp'),
(10029, 'Coco-1.webp'),
(10029, 'Coco-2.webp'),
(10029, 'Coco-3.webp'),
(10029, 'Coco-4.webp'),
(10030, 'Blue-1.webp'),
(10030, 'Blue-2.webp'),
(10030, 'Blue-3.webp'),
(10031, 'Marble-1.jpg'),
(10031, 'Marble-2.jpg'),
(10032, 'Simba-1.webp'),
(10032, 'Simba-2.webp'),
(10032, 'Simba-3.webp'),
(10032, 'Simba-4.webp'),
(10033, '10033_Rocky-1.webp'),
(10033, '10033_Rocky-2.webp'),
(10033, '10033_Rocky-3.webp'),
(10034, 'Snowball-1.webp'),
(10034, 'Snowball-2.webp'),
(10034, 'Snowball-3.webp'),
(10035, 'Lemon-1.webp'),
(10035, 'Lemon-2.webp'),
(10035, 'Lemon-3.webp'),
(10036, 'Flash.webp'),
(10038, 'Rex-1.webp'),
(10038, 'Rex-2.webp'),
(10038, 'Rex-3.webp'),
(10038, 'Rex-4.webp'),
(10039, 'Carrot-1.webp'),
(10039, 'Carrot-2.webp'),
(10071, '10071_Biscuit-1.jpg'),
(10077, '10077_RoughColliePuppies.jpg'),
(10078, '10078_highland cow1.webp'),
(10078, '10078_Highland-Cattle-Calf.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `pet_tags`
--

CREATE TABLE `pet_tags` (
  `pet_id` int(5) NOT NULL,
  `tag_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_tags`
--

INSERT INTO `pet_tags` (`pet_id`, `tag_id`) VALUES
(10000, 10000),
(10000, 10009),
(10000, 10010),
(10000, 10011),
(10001, 10001),
(10001, 10006),
(10001, 10007),
(10001, 10008),
(10001, 10012),
(10001, 10014),
(10002, 10002),
(10002, 10013),
(10002, 10014),
(10003, 10003),
(10003, 10015),
(10003, 10016),
(10004, 10004),
(10004, 10017),
(10004, 10018),
(10004, 10019),
(10005, 10005),
(10005, 10023),
(10006, 10001),
(10006, 10020),
(10006, 10021),
(10006, 10022),
(10007, 10000),
(10007, 10026),
(10007, 10027),
(10007, 10028),
(10008, 10002),
(10008, 10012),
(10008, 10024),
(10008, 10025),
(10008, 10030),
(10009, 10003),
(10009, 10016),
(10009, 10029),
(10010, 10000),
(10010, 10029),
(10010, 10031),
(10010, 10032),
(10011, 10001),
(10011, 10006),
(10011, 10033),
(10011, 10034),
(10011, 10035),
(10012, 10002),
(10012, 10013),
(10012, 10014),
(10012, 10036),
(10013, 10003),
(10013, 10007),
(10013, 10016),
(10013, 10037),
(10014, 10004),
(10014, 10039),
(10014, 10040),
(10014, 10041),
(10014, 10042),
(10015, 10005),
(10015, 10043),
(10015, 10044),
(10016, 10001),
(10016, 10013),
(10016, 10020),
(10016, 10045),
(10017, 10000),
(10017, 10026),
(10017, 10046),
(10017, 10047),
(10018, 10002),
(10018, 10024),
(10018, 10025),
(10018, 10048),
(10019, 10003),
(10019, 10049),
(10019, 10050),
(10020, 10004),
(10020, 10042),
(10020, 10051),
(10020, 10052),
(10021, 10005),
(10021, 10053),
(10021, 10054),
(10022, 10001),
(10022, 10055),
(10022, 10056),
(10023, 10000),
(10023, 10057),
(10023, 10058),
(10023, 10059),
(10024, 10003),
(10024, 10012),
(10024, 10024),
(10025, 10004),
(10025, 10060),
(10025, 10061),
(10026, 10005),
(10026, 10062),
(10026, 10063),
(10027, 10001),
(10027, 10064),
(10027, 10065),
(10028, 10000),
(10028, 10066),
(10028, 10067),
(10028, 10068),
(10029, 10003),
(10029, 10013),
(10029, 10070),
(10030, 10004),
(10030, 10071),
(10030, 10072),
(10030, 10073),
(10031, 10005),
(10031, 10074),
(10031, 10075),
(10032, 10001),
(10032, 10076),
(10032, 10077),
(10032, 10078),
(10033, 10000),
(10033, 10026),
(10033, 10027),
(10033, 10055),
(10034, 10003),
(10034, 10015),
(10034, 10079),
(10034, 10080),
(10035, 10004),
(10035, 10081),
(10035, 10082),
(10035, 10083),
(10036, 10004),
(10036, 10023),
(10036, 10084),
(10036, 10085),
(10037, 10001),
(10037, 10086),
(10038, 10000),
(10038, 10087),
(10039, 10003),
(10039, 10016),
(10039, 10033),
(10039, 10088),
(10071, 10089),
(10071, 10090),
(10077, 10000),
(10077, 10012),
(10077, 10021),
(10077, 10024),
(10077, 10030),
(10077, 10098),
(10077, 10099),
(10078, 10024),
(10078, 10100),
(10078, 10101),
(10078, 10102);

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `user_id` int(5) NOT NULL,
  `tag_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `preferences`
--

INSERT INTO `preferences` (`user_id`, `tag_id`) VALUES
(10023, 10000),
(10023, 10001),
(10026, 10000),
(10026, 10098),
(10026, 10002),
(10019, 10000),
(10019, 10001),
(10019, 10010);

-- --------------------------------------------------------

--
-- Table structure for table `provide_records`
--

CREATE TABLE `provide_records` (
  `user_id` int(5) NOT NULL,
  `pet_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provide_records`
--

INSERT INTO `provide_records` (`user_id`, `pet_id`) VALUES
(10000, 10000),
(10016, 10001),
(10011, 10002),
(10016, 10003),
(10005, 10004),
(10016, 10005),
(10004, 10006),
(10001, 10007),
(10003, 10008),
(10006, 10009),
(10011, 10010),
(10016, 10011),
(10016, 10012),
(10012, 10013),
(10011, 10014),
(10004, 10015),
(10005, 10016),
(10001, 10017),
(10003, 10018),
(10003, 10019),
(10012, 10020),
(10011, 10021),
(10006, 10022),
(10003, 10023),
(10012, 10024),
(10004, 10025),
(10011, 10026),
(10005, 10027),
(10012, 10028),
(10006, 10029),
(10002, 10030),
(10002, 10031),
(10016, 10032),
(10000, 10033),
(10011, 10034),
(10006, 10035),
(10016, 10036),
(10012, 10037),
(10002, 10038),
(10005, 10039),
(10001, 10071),
(10022, 10077),
(10027, 10078);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tag_id` int(5) NOT NULL,
  `content` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tag_id`, `content`) VALUES
(10000, 'dog'),
(10001, 'cat'),
(10002, 'horse'),
(10003, 'rabbit'),
(10004, 'bird'),
(10005, 'fish'),
(10006, 'tabby cat'),
(10007, 'grey'),
(10008, 'grey fur'),
(10009, 'well trained'),
(10010, 'golden retriever'),
(10011, 'friendly'),
(10012, 'gentle'),
(10013, 'black fur'),
(10014, 'stallion'),
(10015, 'white fur'),
(10016, 'bunny'),
(10017, 'yellow fur'),
(10018, 'parrot'),
(10019, 'singing'),
(10020, 'kitten'),
(10021, 'playful'),
(10022, 'black and white'),
(10023, 'goldfish'),
(10024, 'brown'),
(10025, 'mare'),
(10026, 'energetic'),
(10027, 'husky'),
(10028, 'blue eyes'),
(10029, 'sweet'),
(10030, 'beautiful'),
(10031, 'golden doodle'),
(10032, 'like walking'),
(10033, 'orange'),
(10034, 'orange cat'),
(10035, 'Burnaby'),
(10036, 'trail ride'),
(10037, 'fluffy'),
(10038, 'hopping'),
(10039, 'green'),
(10040, 'green_fur'),
(10041, 'parakeet'),
(10042, 'could talk'),
(10043, 'betta fish'),
(10044, 'peaceful'),
(10045, 'shy'),
(10046, 'Labrador'),
(10047, 'Labrador Retriever'),
(10048, 'good for beginner'),
(10049, 'small'),
(10050, 'tan bunny'),
(10051, 'blue budgie'),
(10052, 'singing'),
(10053, 'bright'),
(10054, 'neon tetra'),
(10055, 'playful'),
(10056, 'love climbing'),
(10057, 'German shepherd'),
(10058, 'protective'),
(10059, 'good training'),
(10060, 'sun conure'),
(10061, 'colorful'),
(10062, 'koi fish'),
(10063, 'orange and white'),
(10064, 'rescue cat'),
(10065, 'mismatched eyes'),
(10066, 'Rottweiler'),
(10067, 'strong'),
(10068, 'calm'),
(10069, 'curious'),
(10070, 'black rabbit'),
(10071, 'majestic'),
(10072, 'macaw'),
(10073, 'blue feathers'),
(10074, 'marble-patterned'),
(10075, 'angelfish'),
(10076, 'big'),
(10077, 'Maine'),
(10078, ',Maine Coon'),
(10079, 'white rabbit'),
(10080, 'red eye'),
(10081, 'small'),
(10082, 'canary'),
(10083, 'bright-yellow'),
(10084, 'speedy'),
(10085, 'like racing'),
(10086, 'Siamese cat'),
(10087, 'border collie'),
(10088, 'orange bunny'),
(10089, 'hamster'),
(10090, 'like running'),
(10093, ''),
(10098, 'rough_collie'),
(10099, 'collie'),
(10100, 'cow'),
(10101, 'high land cattle'),
(10102, 'horn');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(5) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `legal_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `other_contact` varchar(50) NOT NULL,
  `profile_photo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_type`, `user_name`, `password`, `legal_name`, `email`, `other_contact`, `profile_photo`) VALUES
(10000, 'provider', 'jone_doe', '123', 'John Doe', 'john.doe@workmail.com', '123-456-7890', '10000.jpg'),
(10001, 'provider', 'jane_smith', '123', 'Jane Smith', 'jane.smith@workmail.com', '321-645-8790', '10001.jpg'),
(10002, 'provider', 'mike_lee', '123', 'Michael Lee', 'mike.lee@workmail.com', '555-578-1234', '10002.jpg'),
(10003, 'provider', 'sarah_conner', '123', 'Sarah Conner', 'sara.conner@workmail.com', '123-778-0931', '10003.jpg'),
(10004, 'provider', 'alex_wong', '123', 'Alex Wong', 'alex.wong@workmail.com', '789-445-1200', '10004.jpg'),
(10005, 'provider', 'alice_chen', '123', 'Alice Chen', 'alice.chen@workmail.com', '998-778-6523', '10005.jpg'),
(10006, 'provider', 'mark_wang', '123', 'Mark Wang', 'mark.wang@workmail.com', '555-123-7890', '10006.jpg'),
(10007, 'adopter', 'emily_chan', '123', 'Emily Chan', 'emily.chan@workmail.com', '222-333-4444', '10007.jpg'),
(10008, 'adopter', 'tom_huang', '123', 'Tom Huang', 'tom.huang@workmail.com', '666-777-8888', '10008.jpg'),
(10009, 'adopter', 'lucy_kim', '123', 'Lucy Kim', 'lucy.kim@example.com', '424-553-6866', '10009.jpg'),
(10010, 'adopter', 'jone_yang', '123', 'Jone Yang', 'john.yang@workmail.com', '778-062-2451', '10010.jpg'),
(10011, 'provider', 'mary_smith', '123', 'Mary Smith', 'mary.smith@workmail.com', '798-260-2377', '10011.jpg'),
(10012, 'provider', 'james_wilson', '123', 'James Wilson', 'james.wilson@workmail.com', '236-887-1116', '10012.jpg'),
(10013, 'adopter', 'sarah_jones', '123', 'Sarah Jones', 'sarah.jones@workmail.com', 'pass1998', '10013.jpg'),
(10014, 'adopter', 'robert_brown', '123', 'Robert Brown', 'robert.brown@workmail.com', '236-562-7388', '10014.jpg'),
(10015, 'adopter', 'linda_taylor', '123', 'Linda Taylor', 'linda.taylor@workmail.com', '798-181-2233', '10015.jpg'),
(10016, 'provider', 'Dannie', '$2y$10$B8YuSg0bu6ovh8sdSdUAiOA5jhgMyytfeWlmft/86XCUZYmEgqNzO', 'Danni Chen', 'dca158@sfu.ca', '7789981116', 'Dannie_95.jpg'),
(10019, 'adopter', 'Angus', '$2y$10$j2PkTy/A8jRHx2bjXdNA7eD8seU3k.ZXnEr//O8o3Ioztj2RDTe3K', 'Angus Wang', 'wang@sfu.ca', '6047000874', 'Angus_8.jpg'),
(10022, 'provider', 'Angus_Provider', '$2y$10$fpG50IfMBA1H0aYEiAx/f.mJg7z2AeHqifegHd1/Pjgli1xtqGJv2', 'Zekun Wang', 'zekun_wang@sfu.ca', '6047000874', 'Angus_Provider_WeChat Image_20250407211542.jpg'),
(10023, 'adopter', 'Angus Noob', '$2y$10$2lv7xWh2YTeBaB9XGotzoOtS56/PuEwgKqd4rpa1yZM6deHz5shx.', 'Zekun Wang', 'zekun_wang123@sfu.ca', '6047000874', 'Angus Noob_WeChat Image_20250407211554.jpg'),
(10026, 'adopter', 'Angus 2000 Cattle', '$2y$10$FTaIHKB3IbxIEa2RstniH.xenvGml6l9hdgv4.4AMDFFc4gkHSnuu', 'Zekun Wang', 'angus_wang@sfu.ca', '6047000874', 'Angus the Cattle_WeChat Image_20250407211542.jpg'),
(10027, 'provider', 'Angus_2000_Provider', '$2y$10$vsTFFZ4IUDrPZfV0tb9csexNrmHv5krjQ7N4DTL1ZZLJ1EiRriuEy', 'Zekun Wang', 'zekun_wang456@sfu.ca', '6047000874', 'Angus_2000_Provider_WeChat Image_20250407211613.jpg'),
(10028, 'adopter', 'Angus2000Noob', '$2y$10$lfTeDpswQB8YIL/45/DboO2hDj24.vhDrSxUfPctubmozTwrt0ULC', 'Angus Wang', 'zekun_wang567@sfu.ca', '6047000874', 'Angus2000Noob_WeChat Image_20250407211554.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption_records`
--
ALTER TABLE `adoption_records`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`user_id`,`pet_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `pet`
--
ALTER TABLE `pet`
  ADD PRIMARY KEY (`pet_id`);

--
-- Indexes for table `pet_images`
--
ALTER TABLE `pet_images`
  ADD UNIQUE KEY `idx_pet_id_image` (`pet_id`,`images`);

--
-- Indexes for table `pet_tags`
--
ALTER TABLE `pet_tags`
  ADD PRIMARY KEY (`pet_id`,`tag_id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `preferences`
--
ALTER TABLE `preferences`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `provide_records`
--
ALTER TABLE `provide_records`
  ADD PRIMARY KEY (`pet_id`,`user_id`),
  ADD KEY `pet_id` (`pet_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pet`
--
ALTER TABLE `pet`
  MODIFY `pet_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10079;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tag_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10103;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10029;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption_records`
--
ALTER TABLE `adoption_records`
  ADD CONSTRAINT `adoption_records_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`),
  ADD CONSTRAINT `adoption_records_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`);

--
-- Constraints for table `pet_images`
--
ALTER TABLE `pet_images`
  ADD CONSTRAINT `pet_images_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`);

--
-- Constraints for table `pet_tags`
--
ALTER TABLE `pet_tags`
  ADD CONSTRAINT `pet_tags_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`),
  ADD CONSTRAINT `pet_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`);

--
-- Constraints for table `preferences`
--
ALTER TABLE `preferences`
  ADD CONSTRAINT `preferences_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `preferences_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`);

--
-- Constraints for table `provide_records`
--
ALTER TABLE `provide_records`
  ADD CONSTRAINT `provide_records_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pet` (`pet_id`),
  ADD CONSTRAINT `provide_records_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
