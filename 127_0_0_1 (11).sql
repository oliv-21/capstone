-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2026 at 03:24 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `brightsidedb`
--
CREATE DATABASE IF NOT EXISTS `brightsidedb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `brightsidedb`;

-- --------------------------------------------------------

--
-- Table structure for table `adminandstaff`
--

CREATE TABLE `adminandstaff` (
  `id` int(11) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `role` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `profilepic` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adminandstaff`
--

INSERT INTO `adminandstaff` (`id`, `firstname`, `middlename`, `lastname`, `role`, `user_id`, `profilepic`, `status`) VALUES
(1, 'Admin', '', '', 'Admin', 1, 'default.webp', 'active'),
(2, 'Attendance', 'Attendance', 'Attendance', 'attendance_monitor', 2, 'default.webp', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `admission_id` int(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `class_applied` varchar(250) DEFAULT NULL,
  `father_name` varchar(100) DEFAULT NULL,
  `father_occupation` varchar(100) DEFAULT NULL,
  `mother_name` varchar(100) DEFAULT NULL,
  `mother_occupation` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `status` enum('Pending','Approved','Disapproved','Enrolled','Pre-enrollee','Interview Failed') DEFAULT 'Pending',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `municipality` varchar(250) NOT NULL,
  `barangay` varchar(250) NOT NULL,
  `street` varchar(250) NOT NULL,
  `picture` varchar(250) NOT NULL DEFAULT 'default.webp',
  `user_id` int(11) NOT NULL,
  `psa` varchar(250) NOT NULL,
  `reason` varchar(250) NOT NULL,
  `openingclosing_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admissions`
--

INSERT INTO `admissions` (`admission_id`, `first_name`, `middle_name`, `last_name`, `nickname`, `nationality`, `gender`, `birthday`, `age`, `class_applied`, `father_name`, `father_occupation`, `mother_name`, `mother_occupation`, `contact_number`, `email`, `status`, `submitted_at`, `municipality`, `barangay`, `street`, `picture`, `user_id`, `psa`, `reason`, `openingclosing_id`) VALUES
(91, 'Kalisha Blaire', 'Si', 'Parilla', 'Kali', 'Filipino', 'female', '2020-09-02', 5, 'Senior Kindergarten (K2)', '', '', 'Clair Jolly Si', 'Ofw', '09178449343', 'karencagayat@gmail.com', 'Enrolled', '2025-12-31 08:21:13', 'Santa Cruz', 'Calios', 'Road 2 Atdramm Village', '1767169273_dc0e39e9c199439af704.jpg', 122, '1767169273_b280ea10c5614265d333.png', '', 18),
(92, 'Hanniel', '', 'Tagunicar', 'Hanniel', 'Filipino', 'male', '2020-10-17', 5, 'Senior Kindergarten (K2)', 'Herald Tagunicar', 'Employee', 'Lilianne Grace Tagunicar', '', '09991655382', 'roldanoliveros1001@gmail.com', 'Enrolled', '2025-12-31 09:52:56', 'Santa Cruz', 'Bagumbayan', 'Sitio 5', '1767174776_d78683166265901b39c7.jpg', 123, '1767174776_69dffd9008044bb6e148.png', '', 18),
(93, 'Eloise Margrethe', '', 'Kamatoy', 'Ellie', 'Filipino', 'female', '2020-08-11', 5, 'Senior Kindergarten (K2)', 'Jessielito A. Kamatoy', 'Businessman', 'Marilou T. Kamatoy', '', '09278495736', 'loukamatoy@gmail.com', 'Enrolled', '2025-12-31 11:16:38', 'Santa Cruz', 'Duhat', '', '1767179798_6168deca1a7ef00e593f.jpg', 124, '1767179798_28b0b42e297e9056dbbd.png', '', 18),
(94, 'Gabriel Lorenz', 'Navarro', 'Litan', 'Gab-Gab', 'Filipino', 'male', '2020-11-25', 5, 'Junior Kindergarten (K1)', 'Renz Alfred J. Litan', 'Government Employee', 'Ma. Marielle N. Litan', 'Government Employee', '09556756124', 'litanmayeh@gmail.com', 'Enrolled', '2025-12-31 11:26:35', 'Santa Cruz', 'Bagumbayan', 'Sitio 3', '1767180395_e1d0989f71cefac5da1e.jpg', 125, '1767180395_0455121ffa9e88db683f.png', '', 18),
(95, 'Sia Cassandra', 'Lopez', 'Untivero', 'Sia', 'Filipino', 'female', '2020-06-16', 5, 'Senior Kindergarten (K2)', 'Apollo M. Untivero', 'Teacher', 'Francesca Annies L. Untivero', 'Teacher', '09474558360', 'francescauntivero@deped.gov.ph', 'Enrolled', '2025-12-31 11:37:26', 'Santa Cruz', 'Bagumbayan', 'Blk 9 Lot 25 Lynville 8', '1767181046_440c2dc482c78741cbaf.jpg', 126, '1767181046_a87c0270cd8cd4fd113b.png', '', 18),
(96, 'Alonzo Isaac', '', 'Ledesma', 'Lonzo', 'Filipino', 'male', '2021-05-23', 4, 'Junior Kindergarten (K1)', 'Meldan J. Ledesma', 'Seaman', 'Cristine L. Ledesma', 'Housewife', '09278027749', 'cristine_leonardo@yahoo.com', 'Enrolled', '2025-12-31 11:55:25', 'Santa Cruz', 'Patimbao', 'Sitio 6 Aglahi Subd', '1767182125_e0c1d4f113abb13051ce.jpg', 127, '1767182125_cd0e76419f9f1256cfdc.png', '', 18),
(97, 'Josethen Kenamarie', '', 'Villanueva', 'Keiva', 'Filipino', 'female', '2021-09-08', 4, 'Junior Kindergarten (K1)', 'Gim Kerwin V. Villanueva', 'Dentist', 'Jennifer Kristel C. Villanueva', 'Dentist', '09178795041', 'jenniferkristelcayetano@gmail.com', 'Enrolled', '2025-12-31 12:03:37', 'Santa Cruz', 'Patimbao', '527', '1767182617_dc67162bec7cefc23598.jpg', 128, '1767182617_ba4b7b2b1d05a08183d4.png', '', 18),
(98, 'Amiyah Emerithz', 'Shi', 'Lim', 'Amiya', 'Chinese', 'female', '2020-10-08', 5, 'Senior Kindergarten (K2)', 'Norman Sy Lim', 'Manager', 'Analyn Cai Shi', '', '09272333769', 'roldanoliveros1002@gmail.com', 'Enrolled', '2025-12-31 12:53:39', 'Pagsanjan', 'Biñan', '', '1767185619_8e187498565e049c7396.jpg', 129, '1767185619_f26737a6ac48c3e5cdd4.png', '', 18),
(99, 'Eonna Zerrilmarasigan', '', 'Bartolome', 'Yona', 'Filipino', 'female', '2020-11-30', 5, 'Junior Kindergarten (K1)', 'Noel G. Bartolome Jr.', 'Fire Figther', 'Zerrina M. Bartolome', 'Teacher', '09456709396', 'zemarasigan@gmail.com', 'Enrolled', '2025-12-31 13:11:27', 'Santa Cruz', 'Calios', 'Purok Marcelo', '1767186687_3ac2e06481119341b47b.jpg', 130, '1767186687_a1d8478bb01414149f6a.png', '', 18),
(100, 'Troy', '', 'Perez', 'Troy', 'Filipino', 'male', '2020-07-04', 5, 'Senior Kindergarten (K2)', 'Joshuan Perez', 'Self Employed', 'Ma. Veronica De Fiesta', 'Dentist', '09567382694', 'defiestaveronica4@gmail.com', 'Enrolled', '2025-12-31 15:31:31', 'Santa Cruz', 'Bagumbayan', '', '1767195091_06566f913f7f8d6735cc.jpg', 131, '1767195091_1d20ebc1b6115e0b1c1f.png', '', 18),
(101, 'Seth Levin', '', 'Perante', 'Seth', 'Filipino', 'male', '2020-11-28', 5, 'Junior Kindergarten (K1)', 'Arvin M. Perante', 'Meat Stace Owner', 'Liza L. Perante', 'Teacher', '09291120271', 'liza.perante@deped.gov.ph', 'Enrolled', '2025-12-31 15:41:39', 'Santa Cruz', 'Patimbao', '005 Sitio 3', '1767195699_9783a797bc6c328cecee.jpg', 132, '1767195699_7e44297f049abc72d904.png', '', 18),
(102, 'Dwyane Marcio', '', 'Villanueva', 'Dwyane', 'Filipino', 'male', '2020-10-17', 5, 'Senior Kindergarten (K2)', 'Edmar A. Villanueva', 'Bank Officer', 'Jennifer O. Villanueva', 'House Wife', '09173160908', 'eferorendain@gmail.com', 'Enrolled', '2025-12-31 16:22:09', 'Santa Cruz', 'San Juan', 'Blk 3 Lot 19 Bria Homes', '1767198129_af6adb3b6fc507ebc6fd.jpg', 133, '1767198129_836a7f11ec0f9ee1361e.png', '', 18),
(103, 'Zachary Damian', '', 'Suena', 'Zachy', 'Filipino', 'male', '2020-03-21', 5, 'Senior Kindergarten (K2)', 'Simon T. Maico', '', 'Zyra Mae S. Suena', '', '09708178880', 'suezyramae@gmail.com', 'Enrolled', '2025-12-31 16:31:03', 'Santa Cruz', 'Calios', 'Marcelo Compound', '1767198663_8dcf0e16a850bdd55a42.jpg', 134, '1767198663_5de0770b9b15d25d9b25.png', '', 18),
(104, 'Athalia Mae Veridiano', '', 'De Guzman', 'Tamtam', 'Filipino', 'female', '2022-09-01', 3, 'Nursery', 'Lance Loui L. De Guzman', '', 'Alyza M. Veridiano', 'Self Employed', '09674212253', 'roldanoliveros1003@gmail.com', 'Enrolled', '2025-12-31 17:42:38', 'Santa Cruz', 'Santo Angel Sur', 'Lynville Phase 3 Blk 9', '1767202957_d59a9776071adbc59e10.jpg', 135, '1767202957_2f83ef98a154ccef8465.png', '', 18),
(105, 'Heather Halley', '', 'Martinez', 'Halley', 'Filipino', 'female', '2020-09-01', 5, 'Junior Kindergarten (K1)', 'Bennett M. Martinez', 'Operation Analyst', 'Eyerica Y. Martinez', 'Housewife', '09158684772', 'eyericayoshida@yahoo.com', 'Enrolled', '2025-12-31 17:50:58', 'Santa Cruz', 'Bagumbayan', 'Sitio 3', '1767203458_e0b6b20e393304253d4f.jpg', 136, '1767203458_0ead4762dc50bee6fef5.png', '', 18),
(106, 'Skyler', '', 'Mercurio', 'Haru', 'Filipino', 'male', '2021-05-21', 4, 'Junior Kindergarten (K1)', 'Ralph C. Mercurio', 'Ofw/Business Owner', 'Melanie P. Mercurio', 'Registered Pharmacist', '09957245122', 'parganibanmelanie@gmail.com', 'Enrolled', '2025-12-31 18:16:07', 'Santa Cruz', 'Bagumbayan', 'Sitio 3', '1767204967_6534112d4a052bbe4920.jpg', 137, '1767204967_9c49624b4115d2126e2f.png', '', 18),
(107, 'Marcus Freire', '', 'Balijon', 'Marcus', 'Filipino', 'male', '2021-07-23', 4, 'Junior Kindergarten (K1)', 'Marnold Balijon', 'Seafarer', 'Sheryll Balijon', 'Teacher', '09157778162', 'roldanoliveros1004@gmail.com', 'Enrolled', '2026-01-01 13:33:40', 'Santa Cruz', 'Bagumbayan', '', '1767274420_76732e6429381c30fd06.jpg', 138, '1767274420_eecf161b7d9276228d16.png', '', 18),
(108, 'Eusha Agape', 'Pambuan', 'Mantes', 'Eusha', 'Filipino', 'female', '0001-06-14', 2024, 'Junior Kindergarten (K1)', 'Eugene AñOnuevo Mantes', 'Electrical Engineer', 'Shamaein Pambuan Mantes', 'Civil Engineer', '09338248737', 'maeinpambuan@gmail.com', 'Enrolled', '2026-01-01 13:42:03', 'Santa Cruz', 'San Pablo Norte', 'Blk 3 Lot 3 Green Village Subd', '1767274923_cad72bceb130c0f79563.jpg', 139, '1767274923_cd65ecee318e8313a08a.png', '', 18),
(109, 'Ethaniel Drake', 'Limpengco', 'Zapanta', 'Ethan', 'Filipino', 'male', '2022-08-29', 3, 'Pre-Kindergarten', 'Jorge Benedict Zapanta', 'Ofw', 'Joyce Geraldine Limpengco Zapanta', 'Physician', '09178507705', 'joycelimpengco@gmail.com', 'Enrolled', '2026-01-01 13:59:27', 'Santa Cruz', 'Patimbao', '', '1767275967_33cf249f48ac4932ce5b.jpg', 140, '1767275967_bba91f18f3c7e001f736.png', '', 18),
(110, 'Allynx', '', 'Riguer', 'Ling Ling', 'Filipino', 'female', '2021-07-17', 4, 'Junior Kindergarten (K1)', 'Algy Riguer', 'Police Officer', 'Joan A. Riguer', 'Nurse', '09550661490', 'joanriguer19@gmail.com', 'Enrolled', '2026-01-01 14:19:08', 'Santa Cruz', 'Bagumbayan', '', '1767277148_27da5b2160b5c125dc25.jpg', 141, '1767277148_a7adba51e5bcf07258cb.png', '', 18),
(111, 'Rebecca Helaina', 'Miranda', 'Reyes', 'Vana', 'Filipino', 'male', '2021-10-11', 4, 'Junior Kindergarten (K1)', 'Henry Q. Reyes Jr.', 'Businessman', 'Daun Nerica M. Reyes', 'Office Staff', '09760948755', 'daunnericamiranda@gmail.com', 'Enrolled', '2026-01-01 14:32:51', 'Pagsanjan', 'Biñan', '', '1767277971_d98af27e286c0febcfe5.jpg', 142, '1767277971_a7174fcadab184cf8116.png', '', 18),
(112, 'Arkisha Alliezenth', 'Bornales', 'Escuadro', 'Allie', 'Filipino', 'female', '2022-03-21', 3, 'Toddler/Baby', 'Eunice Milliezeth S. Bornales', 'Ofw', 'Dexter All Tabujara Escuadro', 'Ofw', '09123456789', 'arkishaalliezenth@gmail.com', 'Enrolled', '2026-01-01 15:58:30', 'Santa Cruz', 'Bagumbayan', 'Phase 1 Blk 6 Opal St. Lot 18 Lynville', '1767283110_f5d582ce833fe6f873c6.jpg', 143, '1767283110_74d2a9c3330f5cae4854.png', '', 18),
(113, 'Koleen Natalie', '', 'Angeles', 'Koleen', 'Filipino', 'female', '2022-03-16', 3, 'Pre-Kindergarten', 'Aljames A. Angeles', '', 'Catalyn Rose A. Angeles', 'Nurse', '09457293446', 'catalynrose@gmail.com', 'Enrolled', '2026-01-01 16:07:38', 'Santa Cruz', 'Patimbao', 'Blk 1 Lot 6, Margarette Village', '1767283658_309310725da41c22fdb2.jpg', 144, '1767283658_77e22f980bb625e62dc7.png', '', 18),
(114, 'Zarina Cassidy', '', 'Tan', 'Ina', 'Filipino', 'female', '2021-09-06', 4, 'Pre-Kindergarten', 'Karl Marvin Tan', 'Nurse', 'Ranimor Sherin Tan', 'House Wife', '09163321083', 'karl07tan@yahoo.com', 'Enrolled', '2026-01-01 16:31:50', 'Santa Cruz', 'Calios', '1077', '1767285110_2563fe32d5920df16ccf.jpg', 145, '1767285110_f4633e3e1cb4797643d2.png', '', 18),
(115, 'Dean Castiel', 'Diaz', 'Panganiban', 'Dean', 'Filipino', 'male', '2021-07-13', 4, 'Junior Kindergarten (K1)', 'Domingo G. Panganiban Jr.', 'Businessman', 'Donnafer D. Oanganiban', 'Businessman', '09565743920', 'roldanoliveros1006@gmail.com', 'Enrolled', '2026-01-01 16:43:30', 'Santa Cruz', 'Bagumbayan', 'Lynville 8', '1767285810_c4bc518a0cc048ab5bb5.jpg', 146, '1767285810_3c20658ec9a62722068f.png', '', 18),
(116, 'Antoni Kalen', 'Malolos', 'Guzman', 'Toni', 'Filipino', 'male', '2019-09-21', 6, 'Senior Kindergarten (K2)', 'Xairus Rey Guzman', 'Environment Specialist', 'Corinne Malolos', 'Environment Consultant', '09271439748', 'roldanoliveros0621@gmail.com', 'Enrolled', '2026-01-01 16:53:14', 'Santa Cruz', 'Bagumbayan', '4872', '1767286394_b71f3d5c5fc1f0fa15c2.jpg', 147, '1767286394_da877c77a054965c01ad.png', '', 18),
(117, 'Evee Antonelle', '', 'Llamoso', 'Evee', 'Filipino', 'female', '2022-02-20', 3, 'Pre-Kindergarten', 'Justin Frank M. Llamoso', 'Project Manager', 'Diana Fatima E. Llamoso', 'Operations Manager', '09175008704', 'escobardianef@gmail.com', 'Enrolled', '2026-01-01 17:07:51', 'Santa Cruz', 'Patimbao', '650', '1767287271_ca3c038f7bfeac03d34b.jpg', 148, '1767287271_2767e2d040128e4ac8b7.png', '', 18),
(118, 'Julio Anton', 'Sumaya', 'Choa', 'Anton', 'Filipino', 'male', '2021-07-12', 4, 'Junior Kindergarten (K1)', 'Clinton Choa', 'Businessman', 'Kirsten Ann Sumaya', 'Lawyer', '09177290706', 'kirstensumaya@gmail.com', 'Enrolled', '2026-01-01 18:08:40', 'Pila', 'Bagong Pook', 'Blk 5 Lot 3 Tierra Verde', '1767290919_efd1b9227d9cd4bfad45.jpg', 149, '1767290919_cd47d7bc2b7e6502b4c1.png', '', 18),
(119, 'Avrilla Rain', '', 'Gagalac', 'Renren', 'Filipino', 'female', '2021-04-15', 4, 'Junior Kindergarten (K1)', 'March Michael Gagalac', 'Businessman', 'Jesamin Gagalac', 'Sales Representative', '09176540087', 'jesamingagalac@gmail.com', 'Enrolled', '2026-01-01 18:18:55', 'Santa Cruz', 'Patimbao', '5565 Sitio 6', '1767291535_8248dd21f2bbf0ff1a56.jpg', 150, '1767291535_2c2edca23fcbe6ecac3e.png', '', 18),
(120, 'Sevan Sky Brandt', 'Del Mundo', 'Bernardino', 'Sevan', 'Filipino', 'male', '2019-11-30', 6, 'Senior Kindergarten (K2)', 'Jherome L. Bernardino', 'Ofw', 'Sherleine Dm. Bernardino', 'Public School Teacher', '09086878774', 'roldanoliveros1007@gmail.com', 'Enrolled', '2026-01-01 18:27:13', 'Santa Cruz', 'San Juan', '', '1767292033_ae67c5eb1380602d9005.jpg', 151, '1767292033_e99b59a78e78477f843b.png', '', 18),
(121, 'Hezekiah Jayce', '', 'Ramiro', 'Kai', 'Filipino', 'male', '2021-10-08', 4, 'Nursery', 'Mike Roniel M. Ramiro', 'Fire Figther', 'Joyce Ann L. Ramiro', 'Nurse', '09778533558', 'roldanoliveros1008@gmal.com', 'Enrolled', '2026-01-02 05:15:35', 'Santa Cruz', 'Patimbao', '5565', '1767330935_ee8905c56add6c85e49b.jpg', 152, '1767330935_9d912ba14dac07618ec7.png', '', 18),
(122, 'Christen Brielle', '', 'Sison', 'Cb', 'Filipinio', 'female', '2021-02-01', 4, 'Pre-Kindergarten', 'Christian James C. Sison', '', 'Archellene L. Banca', 'Ofw', '09693175603', 'roldanoliveros1008@gmail.com', 'Enrolled', '2026-01-02 05:24:45', 'Santa Cruz', 'Gatid', '331 Sitio Manggahan', '1767331485_7a3c2e509ef16f731d4c.jpg', 153, '1767331485_d2f85ae997506947efc5.png', '', 18),
(123, 'Miquella', 'Alfonso', 'Villanueva', 'Quella', 'Filipino', 'female', '2019-11-08', 6, 'Junior Kindergarten (K1)', 'Omar De Leon Villanueva', 'Businessman', 'Clarisssa A. Villanueva', 'Bustons Brokerage', '09171628271', 'clarissavillanueva76@gmail.com', 'Enrolled', '2026-01-02 05:32:01', 'Santa Cruz', 'Bagumbayan', '5018 Sitio Uno', '1767331921_6190237930894124ea59.jpg', 154, '1767331921_ae2b78e90baac2ddf0d2.png', '', 18),
(124, 'Azaela', '', 'Belen', 'Zea', 'Filipino', 'female', '2020-02-12', 5, 'Pre-Kindergarten', 'Melvin M. Belen', 'Pnp', 'Chelsea M. Belen', 'Teacher', '09366647115', 'roldanoliveros1010@gmail.com', 'Enrolled', '2026-01-02 05:38:22', 'Santa Cruz', 'Patimbao', '', '1767332302_f06e613ac67d3f7b21e9.jpg', 155, '1767332302_383310cbe48b8784a54e.png', '', 18),
(125, 'Airrah Gabrielle', 'Ananayo', 'Legaspi', 'Airrah', 'Filipino', 'female', '2019-12-19', 6, 'Pre-Kindergarten', 'Airwin Mhel Legaspi', 'Police Officer', 'Deborah Ananayo Legaspi', 'Police Officer', '09678478900', 'roldanoliveros1011@gmail.com', 'Enrolled', '2026-01-02 05:44:54', 'Santa Cruz', 'San Jose', '', '1767332694_501f36af4971008b61c2.jpg', 156, '1767332694_c32b77d231cfd4be67f0.png', '', 18),
(126, 'Stephen Caden', '', 'Caro', 'Caden', 'Filipino', 'male', '2020-03-10', 5, 'Pre-Kindergarten', 'Aljon B. Caro', 'Osr', 'Raquel D. Caro', 'Nurse', '09770919569', '', 'Enrolled', '2026-01-02 05:51:23', 'Santa Cruz', 'Bubukal', '', '1767333083_6851008375e7d2771a77.jpg', 157, '1767333083_50a1a4c60e5f1867a916.png', '', 18),
(127, 'Zhaym Andrew', '', 'Tablate', 'Zhaym', 'Filipino', 'male', '2019-03-18', 6, 'Senior Kindergarten (K2)', 'Joey Andrew Tablate', 'Seaman', 'Diovy Ann A. Tablate', 'Egg Dealer', '09460868688', '', 'Enrolled', '2026-01-02 05:58:55', 'Santa Cruz', 'Santo Angel Norte', '3661 Tsismosa St.', '1767333535_0a9e7dcaf333fe06ebc9.jpg', 158, '1767333535_d36e03df71726652e915.png', '', 18),
(128, 'Skye Tristan', '', 'Galit', 'Skye', 'Filipino', 'male', '2020-05-29', 5, 'Pre-Kindergarten', 'Jonathan Galit', 'Store Supervisor', 'Maria Rita Fay Galit', 'Restaurant Manager', '09155094982', '', 'Enrolled', '2026-01-02 06:10:48', 'Santa Cruz', 'Gatid', '016 Sitio Bukana', '1767334248_0312d5f71622efa1079a.jpg', 159, '1767334248_72ad9162bd3082a77757.png', '', 18),
(129, 'Joseth Kedvin', '', 'Villanueva', 'Seth', 'Filipino', 'male', '2020-03-08', 5, 'Pre-Kindergarten', 'Gim Kerwin V. Villanueva', 'Dentist', 'Jennifer Kristel C. Villanueva', 'Dentist', '09178795041', '', 'Enrolled', '2026-01-02 06:20:49', 'Santa Cruz', 'Patimbao', '527', '1767334849_700a8a4756e7e7ee5240.jpg', 128, '1767334849_bea9497bdd199ccbda89.png', '', 18),
(130, 'Jace Primo', 'Cotez', 'Alagon', 'Primo', 'Filipino', 'male', '2019-09-26', 6, 'Senior Kindergarten (K2)', 'Jake Robert P. Alagon', 'Credit Investigator', 'Candell C. Alagon', 'Water/Ice Manager', '09062446241/', '', 'Enrolled', '2026-01-02 06:43:27', 'Santa Cruz', 'Patimbao', 'Sitio Vi', '1767336207_288c82e47388aba2e8e1.jpg', 161, '1767336207_023cd4f7b6d54b96fa6b.png', '', 18),
(131, 'Calix Winter Jace', '', 'Javier', 'Winter', 'Filipino', 'male', '2019-12-27', 6, 'Senior Kindergarten (K2)', 'John Jacob E. Javier', 'Businessman', 'Rachelle Anne B. Javier', 'Manager', '09392014288', '', 'Enrolled', '2026-01-02 07:39:50', 'Santa Cruz', 'Gatid', 'Bayside 1', '1767339590_618567cb13372fd629f9.jpg', 162, '1767339590_0394cdd299e9a91f3466.png', '', 18),
(132, 'Jazzy Nestar', 'Orfano', 'Barroga', 'Star', 'Filipino', 'female', '2019-10-17', 6, 'Senior Kindergarten (K2)', 'Jim Paul San Juan Barroga', 'Police Officer', 'Mercy Orfano Barroga', 'Police Officer', '09778436830', '', 'Enrolled', '2026-01-02 07:46:27', 'Santa Cruz', 'Gatid', 'Blk 4 Lot 30 Lynville Diamond Subd.', '1767339987_cf4471d25ae4d8d93987.jpg', 163, '1767339987_d30fdd3a2a79dfe15bd8.png', '', 18),
(133, 'Khael Mattias', '', 'Basa', 'Matti', 'Filipino', 'male', '2020-10-19', 5, 'Pre-Kindergarten', 'Alvien Jeric S. Basa', '', 'Lyka Clarissa C. Basa', '', '09158301080', '', 'Enrolled', '2026-01-02 09:22:55', 'Cavinti', 'Kanluran Talaongan', '056', '1752420767_9459efda9027940a87c4.webp', 164, '1767345775_c141d39fb9c3d943be1d.png', '', 18),
(134, 'Jadd Deon', '', 'Castillo', 'Jadd', 'Filipino', 'male', '2020-01-19', 5, 'Pre-Kindergarten', 'Dexter John G. Castillo', '', 'Pamela Z. Castillo', '', '09777343727', '', 'Enrolled', '2026-01-02 09:27:03', 'Santa Cruz', 'Bagumbayan', 'Sitio', '1752420767_9459efda9027940a87c4.webp', 165, '1767346023_70fd2789982eb35f7601.png', '', 18),
(135, 'Philip Xavier', '', 'Dorado', 'Px', 'Filipino', 'male', '2020-05-13', 5, 'Pre-Kindergarten', 'Paul Regine M. Dorado', 'Architect', 'Patricia Xyrille C. Dorado', 'House Wife', '09064042318', '', 'Enrolled', '2026-01-02 09:36:09', 'Santa Cruz', 'Gatid', 'Blk 14 Lot Ii Lynville Diamond Subd', '1752420767_9459efda9027940a87c4.webp', 166, '1767346569_d036f130088960002e2c.png', '', 18),
(136, 'Lucas Gabriel', 'Bolagao', 'Mallanao', 'Lucas', 'Filipino', 'male', '2020-09-15', 5, 'Nursery', 'Elson B. Mallanao', 'Paralegal', 'Glizelle B. Mallanao', 'Branch Manager', '09566896997', '', 'Enrolled', '2026-01-02 10:31:45', 'Santa Cruz', 'Gatid', 'Blk 5 Lot 27 Lynville Diamond Subd', '1752420767_9459efda9027940a87c4.webp', 167, '1767349905_822bd3614fdf5f875388.png', '', 18),
(137, 'Samantha Ysabelle', '', 'Ramos', 'Sam', 'Filipino', 'female', '2020-10-01', 5, 'Pre-Kindergarten', 'Randl S. Ramos', 'Self Employed', 'Kaye C. Ramos', 'House Wife', '09081963814', '', 'Enrolled', '2026-01-02 10:37:45', 'Santa Cruz', 'Bagumbayan', 'Roger Apt. Unit 1', '1752420767_9459efda9027940a87c4.webp', 168, '1767350265_697c33098e8bc81c85ea.png', '', 18),
(138, 'Johana Haniah', 'Punongbayan', 'Calma', 'Haniah', 'Filipino', 'female', '2020-09-27', 5, 'Pre-Kindergarten', 'John Hervin S. Calma', 'It Security Head', 'Dhana Mae Punongbayan Calma', 'Sales Manager', '09088501123', '', 'Enrolled', '2026-01-02 10:42:41', 'Santa Cruz', 'San Juan', 'Sitio 5', '1752420767_9459efda9027940a87c4.webp', 169, '1767350561_48d7ef0e0ea4182b4f21.png', '', 18),
(139, 'Yvanne Noah', '', 'Lim', 'Yno', 'Filipino', 'male', '2021-10-08', 4, 'Nursery', '', '', 'Yvonne Beatrice B. Lim', '', '09052211275', '', 'Enrolled', '2026-01-02 10:46:24', 'Santa Cruz', 'Gatid', 'Capitol Village Subd', '1752420767_9459efda9027940a87c4.webp', 170, '1767350784_ebcab921d12481e2a9e4.png', '', 18),
(140, 'Naomi', 'De Lima', 'Soriano', 'Naomi', 'Filipino', 'female', '2021-04-16', 4, 'Toddler/Baby', 'Benjie Soriano', 'Cook', 'Jovilyn Soriano', 'House Wife', '09686045813', '', 'Enrolled', '2026-01-02 10:51:14', 'Santa Cruz', 'Bagumbayan', 'Sitio 5', '1752420767_9459efda9027940a87c4.webp', 171, '1767351073_f1098c825c85cb861079.png', '', 18),
(141, 'Tomas Primo', '', 'Muli', 'Tomas', 'Filipino', 'male', '2020-10-26', 5, 'Nursery', '', '', 'Katrina C. Muli', 'Lawyer', '09209734883', '', 'Enrolled', '2026-01-02 10:55:29', 'Pagsanjan', 'Sabang', 'Maresco Road Corner San Luis Road', '1752420767_9459efda9027940a87c4.webp', 172, '1767351329_7902d37f0b0aeed1aae9.png', '', 18),
(142, 'Khloe Ann', '', 'Liwag', 'Majesty', 'Filipino', 'female', '2020-10-02', 5, 'Toddler/Baby', 'King Vlar Ian S. Liwag', 'Businessman', 'Ann Kristine S. Liwag', 'House Wife', '09284338658', '', 'Enrolled', '2026-01-02 10:59:04', 'Santa Cruz', 'Bagumbayan', '', '1752420767_9459efda9027940a87c4.webp', 173, '1767351544_04b8114a37b62b2d844b.png', '', 18),
(143, 'Arya Eledelia', '', 'Tabuzo', 'Arya', 'Filipino', 'female', '2021-03-06', 4, 'Toddler/Baby', 'Marlon Tabuzo', 'Aircraft Mechanic', 'Rayechelle Tabuzo', 'House Wife', '09287688125', '', 'Enrolled', '2026-01-02 11:03:03', 'Santa Cruz', 'Santisima Cruz', 'P. Flores St', '1752420767_9459efda9027940a87c4.webp', 174, '1767351783_9d5953e7b8ed801b0f3c.png', '', 18),
(144, 'Jeremiah Rolcy', 'Ocampo', 'Alarva', 'Chibz', 'Filipino', 'male', '2022-05-28', 3, 'Toddler/Baby', 'Jerwyn M. Alarva', 'Gost Employee', 'Marydol O. Alarva', 'Gost Employee', '09778533558', '', 'Enrolled', '2026-01-02 11:08:58', 'Santa Cruz', 'Gatid', '', '1752420767_9459efda9027940a87c4.webp', 175, '1767352138_7c7d0d33d38c6b042fbc.png', '', 18),
(145, 'Maxene', '', 'OrdoñEz', 'Maxene', 'Filipino', 'female', '2021-11-06', 4, 'Nursery', 'Moiss OrdoñEz', 'Business Owner', 'Joyce Carol Valencia', 'House Wife', '09976420440', '', 'Enrolled', '2026-01-02 11:12:29', 'Santa Cruz', 'Gatid', '', '1752420767_9459efda9027940a87c4.webp', 176, '1767352349_ead9e723ab18b8fa0e00.png', '', 18),
(146, 'Aziel Luke', '', 'Gonzales', 'Luke', 'Filipino', 'male', '2021-10-18', 4, 'Nursery', 'Jimwel Gonzalez', '', 'Maycie Bombay', 'Customer Service Representative', '09628773301', '', 'Enrolled', '2026-01-02 11:42:33', 'Santa Cruz', 'San Pablo Sur', '198 Sitio Rosas', '1752420767_9459efda9027940a87c4.webp', 177, '1767354153_885ea4ea71dc3a8186ad.png', '', 18),
(147, 'Cassandra Christelle', 'Devera', 'Calcetas', 'Cassy', 'Filipino', 'female', '2021-11-12', 4, 'Toddler/Baby', 'Winetnino Calcetas', '', 'Vivian Calcetas', '', '09155206271', '', 'Enrolled', '2026-01-02 11:52:42', 'Santa Cruz', 'Bubukal', 'Sitio Rosa', '1752420767_9459efda9027940a87c4.webp', 178, '1767354762_76828c0fbbd16da90b40.png', '', 18),
(148, 'Ruth Anne', '', 'Pamatmat', 'Tuan', 'Filipino', 'female', '2021-11-02', 4, 'Nursery', 'Jan Vincent L. Pamatmat', 'Delivery Rider', 'Arlett A. Tabigay', 'House Wife', '09955689169', '', 'Enrolled', '2026-01-02 11:56:46', 'Santa Cruz', 'Bubukal', 'Sitio Rosal', '1752420767_9459efda9027940a87c4.webp', 179, '1767355006_11a344fc9488e77ce937.png', '', 18),
(149, 'Atasha Zion Primo Matthaeus', '', 'Macalinao', 'Zion', 'Filipino', 'male', '2021-05-30', 4, 'Nursery', 'John Matthew M. Macalinao', 'School Director', 'Jo - Christine E. Macalinao', 'Registrar', '09171208740', '', 'Enrolled', '2026-01-02 12:02:59', 'Pagsanjan', 'Pinagsanjan', '328 Sitio Cubao', '1752420767_9459efda9027940a87c4.webp', 180, '1767355379_bc54067460f4c2a30c91.png', '', 18),
(150, 'Atasha Brielle', '', 'Beguico', 'Atasha', 'Filipino', 'female', '2021-02-11', 4, 'Nursery', 'Albren Beguico', 'Small Business Owner', 'Erila Pauline Beguico', 'Small Business Owner', '09669252143', '', 'Enrolled', '2026-01-02 12:30:09', 'Santa Cruz', 'Bubukal', '093 Sitio Rosal', '1752420767_9459efda9027940a87c4.webp', 181, '1767357009_ec5aa2d0a6e5be7d6f86.png', '', 18),
(151, 'Chase Ephraim Eduria', '', 'Alagon', 'Chase', 'Filipino', 'male', '2021-07-08', 4, 'Nursery', 'Ashley Dee Alagon', 'Architect', 'Aliza Mae Alagon', 'Hr', '09066811930', '', 'Enrolled', '2026-01-02 12:39:43', 'Santa Cruz', 'Patimbao', 'Sitio 6 Ilaya', '1752420767_9459efda9027940a87c4.webp', 182, '1767357583_787b7125fa695e925761.png', '', 18),
(152, 'Avianna Shea', '', 'Villanueva', 'Shea', 'Filipino', 'female', '2022-12-15', 3, 'Toddler/Baby', 'Jayson P. Villanueva', 'Afp Member', 'Jenny Rose C. Villanueva', 'House Wife', '09123456789', '', 'Enrolled', '2026-01-02 12:44:34', 'Santa Cruz', 'Gatid', '', '1752420767_9459efda9027940a87c4.webp', 183, '1767357874_57ad3b2df3385e36527b.png', '', 18),
(153, 'Warren Manuel', '', 'Rondilla', 'Warn', 'Filipino', 'male', '2022-02-14', 3, 'Nursery', 'Hendryx Rondilla', 'Government Employee', 'Berlee Joy Rondilla', 'Hr Admin & Analyst', '09058090081', '', 'Pending', '2026-01-02 12:48:36', 'Santa Cruz', 'Bubukal', '125 Blk 13 Lot 23 Villa Remedios Homes', '1752420767_9459efda9027940a87c4.webp', 184, '1767358116_300623f53144d6cc22f7.png', '', 18),
(154, 'Viela Elise', '', 'Basa', 'Viela', 'Filipino', 'female', '2023-03-07', 2, 'Toddler/Baby', 'Alvien Jeric S. Basa', '', 'Lyka Clarissa C. Basa', '', '09158301080', '', 'Pending', '2026-01-02 12:55:38', 'Cavinti', 'Kanluran Talaongan', '056', '1752420767_9459efda9027940a87c4.webp', 164, '1767358538_836f1c2f25e224a72604.png', '', 18),
(155, 'Riley Brielle', 'Navarro', 'Litan', 'Riley', 'Filipino', 'female', '2022-12-21', 3, 'Toddler/Baby', 'Renz Alfred J. Litan', 'Government Employee', 'Ma. Marielle N. Litan', 'Government Employee', '09556756124', '', 'Pending', '2026-01-02 13:07:02', 'Santa Cruz', 'Bagumbayan', 'Sitio', '1752420767_9459efda9027940a87c4.webp', 125, '1767359222_5e88a95e06c362244d6f.png', '', 18),
(156, 'Michaela Gray', '', 'Casabuena', 'Mic-Mic', 'Filipino', 'female', '2022-07-07', 3, 'Nursery', 'Michael P. Casabuena', '', 'Joan Casabuena', 'House Wife', '09778092270', '', 'Pending', '2026-01-02 13:16:37', 'Santa Cruz', 'Gatid', '', '1752420767_9459efda9027940a87c4.webp', 186, '1767359797_448c47e86d0bb98a328c.png', '', 18),
(157, 'Arlo Evaris', '', 'Tabuzo', 'Arlo', 'Filipino', 'male', '2022-08-23', 3, 'Nursery', 'Rayechelle Tabuzo', 'House Wife', 'Marlon Tabuzo', 'Aircraft Mechanic', '09287688125', '', 'Pending', '2026-01-02 13:39:15', 'Santa Cruz', 'Santisima Cruz', 'P. Flores St. Santisima', '1752420767_9459efda9027940a87c4.webp', 187, '1767361155_2d779b4930b7d03e37de.png', '', 18),
(158, 'Maria Stella', 'Salvador', 'Batitis', 'Ria', 'Filipino', 'female', '2022-12-22', 3, 'Toddler/Baby', 'Jeffrey D. Batitis', 'Store Keeper', 'Marjie Marie S. Batitis', 'House Wife', '09755505767', '', 'Pending', '2026-01-02 13:44:39', 'Santa Cruz', 'Bagumbayan', 'Sitio2', '1752420767_9459efda9027940a87c4.webp', 188, '1767361479_776381bc260bdf8b76a0.png', '', 18),
(159, 'Annedrew', '', 'Lopez', 'Annedrew', 'Filipino', 'male', '2023-01-03', 2, 'Toddler/Baby', 'Jaime Andrew E. Lopez', 'Teacher', 'Rose Michelle U. Lopez', 'Teacher', '09124204339', '', 'Pending', '2026-01-02 13:49:47', 'Santa Cruz', 'Patimbao', '9574 Sitio 2', '1752420767_9459efda9027940a87c4.webp', 189, '1767361787_b922538e4e06e629b001.png', '', 18),
(160, 'Rafaelle Luzio', '', 'Narvadez', 'Rafaelle', 'Filipino', 'male', '2023-01-25', 2, 'Toddler/Baby', 'Reynan Narvadez', 'Cook', 'Camille Narvadez', 'Cook', '09081451165', '', 'Pending', '2026-01-02 13:55:26', 'Santa Cruz', 'Calios', '2216 Road 2 Atdramm Village', '1752420767_9459efda9027940a87c4.webp', 190, '1767362126_3b6fd571a9155202527d.png', '', 18),
(161, 'Mason Bryce', 'Ipapo', 'Lorenzo', 'Mason', 'Filipino', 'male', '2023-06-23', 2, 'Nursery', 'Matthew Lontoc Lorenzo', 'Businessman', 'Kiara Glyzee Ipapo Lorenzo', 'Businesswoman', '09171672617', '', 'Pending', '2026-01-02 14:00:30', 'Pila', 'Bagong Pook', 'Blk 11 Lot 7 Tierra Verde', '1752420767_9459efda9027940a87c4.webp', 191, '1767362430_1f3666f50ff8073141ff.png', '', 18),
(162, 'Pricess Luna', '', 'Galicia', 'Luna', 'Filipino', 'female', '2023-08-03', 2, 'Toddler/Baby', 'John Lester Galicia', 'Driver', 'Hazel Sandoval', 'House Wife', '09539931699', '', 'Pending', '2026-01-02 14:03:56', 'Santa Cruz', 'Bagumbayan', 'Sitio 5', '1752420767_9459efda9027940a87c4.webp', 192, '1767362636_48e1e248addbc35cc542.png', '', 18),
(163, 'Zoe Claire', 'Limpengco', 'Zapanta', 'Zoe', 'Filipino', 'female', '2023-10-05', 2, 'Toddler/Baby', 'Jorge Benedict Zapanta', 'Ofw', 'Joyce Geraldine Limpengco Zapanta', 'Physician', '09178507705', '', 'Pending', '2026-01-02 14:08:44', 'Santa Cruz', 'Patimbao', 'El Basilio', '1752420767_9459efda9027940a87c4.webp', 193, '1767362924_0e149b550bedac1120ef.png', '', 18),
(164, 'Henry Emmanuel', '', 'Chua', 'Emry', 'Filipino', 'male', '2022-02-22', 3, 'Toddler/Baby', 'Rochelle Ann S. Chua', 'Event Planner', 'Jeffrey C, Chua', 'Account Officer', '09178909158', '', 'Pending', '2026-01-02 14:12:49', 'Santa Cruz', 'Patimbao', '', '1752420767_9459efda9027940a87c4.webp', 194, '1767363169_c88ff118d0a470b23a56.png', '', 18),
(165, 'Gabriel Louis', 'Custusio', 'Tan', 'Gabby', 'Filipino', 'male', '2023-02-24', 2, 'Toddler/Baby', 'Aenar Louis De Jesus Tan', 'Ci/ Collector', 'Romalyn Tan', 'Teacher', '09817929889', '', 'Pending', '2026-01-02 14:16:19', 'Santa Cruz', 'Santo Angel Norte', '2927 Hipon St.', '1752420767_9459efda9027940a87c4.webp', 195, '1767363379_86d38321902870a65387.png', '', 18),
(166, 'Emilia Ciel Chan', '', 'Corella', 'Mia', 'Filipino', 'male', '2023-06-26', 2, 'Toddler/Baby', 'Brian Gabriel Corella', 'Businessman', 'Chelsea Ciel C. Corella', 'Creative Director', '09524831781', '', 'Pending', '2026-01-02 14:20:29', 'Santa Cruz', 'Santo Angel Norte', 'Harmel La Cheska Compound, 9110 Rosa St', '1752420767_9459efda9027940a87c4.webp', 196, '1767363629_adc18d3f3dd04ad7d43b.png', '', 18),
(167, 'Julian Ansel', '', 'Calandria', 'Julian', 'Filipino', 'male', '2022-05-23', 3, 'Toddler/Baby', 'Jimuel A. Calandria', 'Seafarer', 'Angela Carla G. Calandria', 'Nurse', '09164830508', '', 'Pending', '2026-01-02 14:23:31', 'Santa Cruz', 'Gatid', 'Blk 6 Lot 5 Lynville Diamond', '1752420767_9459efda9027940a87c4.webp', 197, '1767363811_496e8badb8ab2ac9a07a.png', '', 18);

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `opening_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`id`, `title`, `message`, `status`, `created_at`, `user_id`, `opening_id`) VALUES
(21, 'Parent–Teacher Conference', 'The Parent–Teacher Conference is scheduled on December 12, 2025. This meeting aims to discuss students’ academic progress and classroom performance. We highly encourage all parents to attend.', 'Active', '2025-12-01 11:05:09', 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `arrival_time` time DEFAULT NULL,
  `accompanied_by` varchar(20) NOT NULL,
  `leave_time` time DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `picked_up_by` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL,
  `admission_id` int(11) NOT NULL,
  `done_by` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `action` varchar(250) NOT NULL,
  `status` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `admission_id`, `done_by`, `description`, `action`, `status`, `created_at`, `updated_at`) VALUES
(51, 91, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2025-12-31 17:34:36', '2025-12-31 17:34:36'),
(52, 91, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2025-12-31 17:34:41', '2025-12-31 17:34:41'),
(53, 91, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2025-12-31 17:36:03', '2025-12-31 17:36:03'),
(54, 92, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2025-12-31 17:53:08', '2025-12-31 17:53:08'),
(55, 92, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2025-12-31 17:53:21', '2025-12-31 17:53:21'),
(56, 92, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2025-12-31 17:53:29', '2025-12-31 17:53:29'),
(57, 93, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2025-12-31 19:16:55', '2025-12-31 19:16:55'),
(58, 93, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2025-12-31 19:17:19', '2025-12-31 19:17:19'),
(59, 93, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2025-12-31 19:17:26', '2025-12-31 19:17:26'),
(60, 94, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2025-12-31 19:26:50', '2025-12-31 19:26:50'),
(61, 94, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2025-12-31 19:26:54', '2025-12-31 19:26:54'),
(62, 94, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2025-12-31 19:27:00', '2025-12-31 19:27:00'),
(63, 95, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2025-12-31 19:38:17', '2025-12-31 19:38:17'),
(64, 95, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2025-12-31 19:38:21', '2025-12-31 19:38:21'),
(65, 95, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2025-12-31 19:38:28', '2025-12-31 19:38:28'),
(66, 96, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2025-12-31 19:55:37', '2025-12-31 19:55:37'),
(67, 96, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2025-12-31 19:55:43', '2025-12-31 19:55:43'),
(68, 96, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2025-12-31 19:55:49', '2025-12-31 19:55:49'),
(69, 97, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2025-12-31 20:03:58', '2025-12-31 20:03:58'),
(70, 97, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2025-12-31 20:04:02', '2025-12-31 20:04:02'),
(71, 97, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2025-12-31 20:04:09', '2025-12-31 20:04:09'),
(72, 98, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2025-12-31 20:54:55', '2025-12-31 20:54:55'),
(73, 98, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2025-12-31 20:55:01', '2025-12-31 20:55:01'),
(74, 98, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2025-12-31 20:55:09', '2025-12-31 20:55:09'),
(75, 99, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2025-12-31 21:11:42', '2025-12-31 21:11:42'),
(76, 99, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2025-12-31 21:11:46', '2025-12-31 21:11:46'),
(77, 99, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2025-12-31 21:11:53', '2025-12-31 21:11:53'),
(78, 100, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2025-12-31 23:33:48', '2025-12-31 23:33:48'),
(79, 100, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2025-12-31 23:33:52', '2025-12-31 23:33:52'),
(80, 100, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2025-12-31 23:33:59', '2025-12-31 23:33:59'),
(81, 101, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2025-12-31 23:41:55', '2025-12-31 23:41:55'),
(82, 101, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2025-12-31 23:41:59', '2025-12-31 23:41:59'),
(83, 101, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2025-12-31 23:42:05', '2025-12-31 23:42:05'),
(84, 102, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-01 00:22:24', '2026-01-01 00:22:24'),
(85, 102, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-01 00:22:28', '2026-01-01 00:22:28'),
(86, 102, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-01 00:22:33', '2026-01-01 00:22:33'),
(87, 103, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-01 00:32:41', '2026-01-01 00:32:41'),
(88, 103, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-01 00:32:56', '2026-01-01 00:32:56'),
(89, 103, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-01 00:33:06', '2026-01-01 00:33:06'),
(90, 104, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-01 01:43:13', '2026-01-01 01:43:13'),
(91, 104, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-01 01:43:18', '2026-01-01 01:43:18'),
(92, 104, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-01 01:43:24', '2026-01-01 01:43:24'),
(93, 105, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-01 01:51:12', '2026-01-01 01:51:12'),
(94, 105, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-01 01:51:16', '2026-01-01 01:51:16'),
(95, 105, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-01 01:51:23', '2026-01-01 01:51:23'),
(96, 106, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-01 02:16:19', '2026-01-01 02:16:19'),
(97, 106, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-01 02:16:24', '2026-01-01 02:16:24'),
(98, 106, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-01 02:16:30', '2026-01-01 02:16:30'),
(99, 107, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-01 21:35:08', '2026-01-01 21:35:08'),
(100, 107, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-01 21:35:13', '2026-01-01 21:35:13'),
(101, 107, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-01 21:35:20', '2026-01-01 21:35:20'),
(102, 108, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-01 21:42:43', '2026-01-01 21:42:43'),
(103, 108, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-01 21:42:47', '2026-01-01 21:42:47'),
(104, 108, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-01 21:42:56', '2026-01-01 21:42:56'),
(105, 109, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-01 21:59:38', '2026-01-01 21:59:38'),
(106, 109, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-01 21:59:43', '2026-01-01 21:59:43'),
(107, 109, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-01 21:59:48', '2026-01-01 21:59:48'),
(108, 110, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-01 22:19:42', '2026-01-01 22:19:42'),
(109, 110, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-01 22:19:46', '2026-01-01 22:19:46'),
(110, 110, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-01 22:19:53', '2026-01-01 22:19:53'),
(111, 111, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-01 22:33:06', '2026-01-01 22:33:06'),
(112, 111, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-01 22:33:12', '2026-01-01 22:33:12'),
(113, 111, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-01 22:33:19', '2026-01-01 22:33:19'),
(114, 112, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-01 23:58:42', '2026-01-01 23:58:42'),
(115, 112, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-01 23:58:49', '2026-01-01 23:58:49'),
(116, 112, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-01 23:58:54', '2026-01-01 23:58:54'),
(117, 113, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 00:07:51', '2026-01-02 00:07:51'),
(118, 113, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 00:07:55', '2026-01-02 00:07:55'),
(119, 113, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 00:08:01', '2026-01-02 00:08:01'),
(120, 114, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 00:32:06', '2026-01-02 00:32:06'),
(121, 114, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 00:32:10', '2026-01-02 00:32:10'),
(122, 114, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 00:32:18', '2026-01-02 00:32:18'),
(123, 115, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 00:43:45', '2026-01-02 00:43:45'),
(124, 115, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 00:43:52', '2026-01-02 00:43:52'),
(125, 115, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 00:43:57', '2026-01-02 00:43:57'),
(126, 116, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 00:53:51', '2026-01-02 00:53:51'),
(127, 116, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 00:53:55', '2026-01-02 00:53:55'),
(128, 116, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 00:54:01', '2026-01-02 00:54:01'),
(129, 117, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 01:08:19', '2026-01-02 01:08:19'),
(130, 117, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 01:08:23', '2026-01-02 01:08:23'),
(131, 117, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 01:09:16', '2026-01-02 01:09:16'),
(132, 118, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 02:08:54', '2026-01-02 02:08:54'),
(133, 118, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 02:08:58', '2026-01-02 02:08:58'),
(134, 118, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 02:09:06', '2026-01-02 02:09:06'),
(135, 119, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 02:19:10', '2026-01-02 02:19:10'),
(136, 119, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 02:19:13', '2026-01-02 02:19:13'),
(137, 119, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 02:19:18', '2026-01-02 02:19:18'),
(138, 119, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 02:19:24', '2026-01-02 02:19:24'),
(139, 120, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 03:22:13', '2026-01-02 03:22:13'),
(140, 120, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 03:22:17', '2026-01-02 03:22:17'),
(141, 120, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 03:22:49', '2026-01-02 03:22:49'),
(142, 121, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 13:18:00', '2026-01-02 13:18:00'),
(143, 121, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 13:18:09', '2026-01-02 13:18:09'),
(144, 121, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 13:18:16', '2026-01-02 13:18:16'),
(145, 122, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 13:24:56', '2026-01-02 13:24:56'),
(146, 122, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 13:25:00', '2026-01-02 13:25:00'),
(147, 122, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 13:25:04', '2026-01-02 13:25:04'),
(148, 122, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 13:25:12', '2026-01-02 13:25:12'),
(149, 123, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 13:32:13', '2026-01-02 13:32:13'),
(150, 123, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 13:32:17', '2026-01-02 13:32:17'),
(151, 123, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 13:32:23', '2026-01-02 13:32:23'),
(152, 124, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 13:38:42', '2026-01-02 13:38:42'),
(153, 124, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 13:38:47', '2026-01-02 13:38:47'),
(154, 124, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 13:38:53', '2026-01-02 13:38:53'),
(155, 125, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 13:45:05', '2026-01-02 13:45:05'),
(156, 125, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 13:45:12', '2026-01-02 13:45:12'),
(157, 125, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 13:45:19', '2026-01-02 13:45:19'),
(158, 126, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 13:53:25', '2026-01-02 13:53:25'),
(159, 126, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 13:53:29', '2026-01-02 13:53:29'),
(160, 126, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 13:53:35', '2026-01-02 13:53:35'),
(161, 127, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 13:59:09', '2026-01-02 13:59:09'),
(162, 127, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 13:59:15', '2026-01-02 13:59:15'),
(163, 127, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 13:59:24', '2026-01-02 13:59:24'),
(164, 128, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 14:10:58', '2026-01-02 14:10:58'),
(165, 128, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 14:11:04', '2026-01-02 14:11:04'),
(166, 128, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 14:11:09', '2026-01-02 14:11:09'),
(167, 129, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 14:21:02', '2026-01-02 14:21:02'),
(168, 129, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 14:21:07', '2026-01-02 14:21:07'),
(169, 129, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 14:21:13', '2026-01-02 14:21:13'),
(170, 130, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 14:43:45', '2026-01-02 14:43:45'),
(171, 130, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 14:43:50', '2026-01-02 14:43:50'),
(172, 130, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 14:43:56', '2026-01-02 14:43:56'),
(173, 131, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 15:40:01', '2026-01-02 15:40:01'),
(174, 131, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 15:40:06', '2026-01-02 15:40:06'),
(175, 131, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 15:40:12', '2026-01-02 15:40:12'),
(176, 132, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 15:46:38', '2026-01-02 15:46:38'),
(177, 132, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 15:46:42', '2026-01-02 15:46:42'),
(178, 132, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 15:46:47', '2026-01-02 15:46:47'),
(179, 133, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 17:23:16', '2026-01-02 17:23:16'),
(180, 133, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 17:23:21', '2026-01-02 17:23:21'),
(181, 133, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 17:23:28', '2026-01-02 17:23:28'),
(182, 134, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 17:30:39', '2026-01-02 17:30:39'),
(183, 134, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 17:30:46', '2026-01-02 17:30:46'),
(184, 134, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 17:31:11', '2026-01-02 17:31:11'),
(185, 135, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 17:36:20', '2026-01-02 17:36:20'),
(186, 135, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 17:36:24', '2026-01-02 17:36:24'),
(187, 135, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 17:36:32', '2026-01-02 17:36:32'),
(188, 136, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 18:32:22', '2026-01-02 18:32:22'),
(189, 136, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 18:32:28', '2026-01-02 18:32:28'),
(190, 136, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 18:32:33', '2026-01-02 18:32:33'),
(191, 137, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 18:37:54', '2026-01-02 18:37:54'),
(192, 137, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 18:37:58', '2026-01-02 18:37:58'),
(193, 137, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 18:38:04', '2026-01-02 18:38:04'),
(194, 138, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 18:42:53', '2026-01-02 18:42:53'),
(195, 138, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 18:43:00', '2026-01-02 18:43:00'),
(196, 138, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 18:43:08', '2026-01-02 18:43:08'),
(197, 139, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 18:46:32', '2026-01-02 18:46:32'),
(198, 139, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 18:46:38', '2026-01-02 18:46:38'),
(199, 139, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 18:46:44', '2026-01-02 18:46:44'),
(200, 140, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 18:51:22', '2026-01-02 18:51:22'),
(201, 140, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 18:51:28', '2026-01-02 18:51:28'),
(202, 140, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 18:51:48', '2026-01-02 18:51:48'),
(203, 141, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 18:55:41', '2026-01-02 18:55:41'),
(204, 141, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 18:55:47', '2026-01-02 18:55:47'),
(205, 141, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 18:55:53', '2026-01-02 18:55:53'),
(206, 142, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 20:57:24', '2026-01-02 20:57:24'),
(207, 143, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 20:57:32', '2026-01-02 20:57:32'),
(208, 144, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 20:57:40', '2026-01-02 20:57:40'),
(209, 145, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 20:57:49', '2026-01-02 20:57:49'),
(210, 146, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 20:57:56', '2026-01-02 20:57:56'),
(211, 147, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 20:58:04', '2026-01-02 20:58:04'),
(212, 148, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 20:58:12', '2026-01-02 20:58:12'),
(213, 149, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 20:58:20', '2026-01-02 20:58:20'),
(214, 142, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 20:58:26', '2026-01-02 20:58:26'),
(215, 143, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 20:58:31', '2026-01-02 20:58:31'),
(216, 144, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 20:58:36', '2026-01-02 20:58:36'),
(217, 145, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 20:58:41', '2026-01-02 20:58:41'),
(218, 145, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 20:58:47', '2026-01-02 20:58:47'),
(219, 142, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 20:58:57', '2026-01-02 20:58:57'),
(220, 143, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 20:59:06', '2026-01-02 20:59:06'),
(221, 144, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 20:59:15', '2026-01-02 20:59:15'),
(222, 150, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 20:59:28', '2026-01-02 20:59:28'),
(223, 146, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 20:59:34', '2026-01-02 20:59:34'),
(224, 146, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 20:59:40', '2026-01-02 20:59:40'),
(225, 147, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 20:59:49', '2026-01-02 20:59:49'),
(226, 147, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 20:59:57', '2026-01-02 20:59:57'),
(227, 148, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 21:00:04', '2026-01-02 21:00:04'),
(228, 149, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 21:00:09', '2026-01-02 21:00:09'),
(229, 150, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 21:00:13', '2026-01-02 21:00:13'),
(230, 148, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 21:00:22', '2026-01-02 21:00:22'),
(231, 149, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 21:00:31', '2026-01-02 21:00:31'),
(232, 150, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 21:00:43', '2026-01-02 21:00:43'),
(233, 151, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 21:00:55', '2026-01-02 21:00:55'),
(234, 152, 'Admin ', 'Status changed to Approved. Reason: ', 'Update Status', 'Approved', '2026-01-02 21:01:05', '2026-01-02 21:01:05'),
(235, 151, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 21:01:11', '2026-01-02 21:01:11'),
(236, 152, 'Admin ', 'Status changed to Pre-enrollee. Reason: ', 'Update Status', 'Pre-enrollee', '2026-01-02 21:01:16', '2026-01-02 21:01:16'),
(237, 151, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 21:01:23', '2026-01-02 21:01:23'),
(238, 152, 'Admin ', 'Pay Registration paid: ₱2000.00 via Cash.', 'payment Miscellaneous', 'success', '2026-01-02 21:01:38', '2026-01-02 21:01:38');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `classname` varchar(250) NOT NULL,
  `tuitionfee` decimal(11,0) NOT NULL,
  `monthly_payment` decimal(10,0) NOT NULL,
  `miscellaneous` decimal(11,0) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_id`, `classname`, `tuitionfee`, `monthly_payment`, `miscellaneous`, `status`) VALUES
(24, 18, 'Toddler/Baby', 20000, 2000, 7500, 'active'),
(25, 18, 'Nursery', 25000, 2500, 7500, 'active'),
(26, 18, 'Pre-Kindergarten', 25000, 2000, 7500, 'active'),
(27, 18, 'Senior Kindergarten (K2)', 25000, 2500, 8000, 'active'),
(28, 18, 'Junior Kindergarten (K1)', 25000, 2500, 8000, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `classroom`
--

CREATE TABLE `classroom` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_level` varchar(250) NOT NULL,
  `file` varchar(250) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` varchar(250) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `openingclosing_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customize_settings`
--

CREATE TABLE `customize_settings` (
  `id` int(11) NOT NULL,
  `sms_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `email_enabled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customize_settings`
--

INSERT INTO `customize_settings` (`id`, `sms_enabled`, `email_enabled`, `created_at`, `updated_at`) VALUES
(0, 1, 1, '2025-07-07', '2025-12-04');

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `openingclosing_id` int(11) NOT NULL,
  `date_enrolled` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(100) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`id`, `student_id`, `openingclosing_id`, `date_enrolled`, `status`) VALUES
(84, 91, 18, '2025-12-31', 'active'),
(85, 92, 18, '2025-12-31', 'active'),
(86, 93, 18, '2025-12-31', 'active'),
(87, 94, 18, '2025-12-31', 'active'),
(88, 95, 18, '2025-12-31', 'active'),
(89, 96, 18, '2025-12-31', 'active'),
(90, 97, 18, '2025-12-31', 'active'),
(91, 98, 18, '2025-12-31', 'active'),
(92, 99, 18, '2025-12-31', 'active'),
(93, 100, 18, '2025-12-31', 'active'),
(94, 101, 18, '2025-12-31', 'active'),
(95, 102, 18, '2026-01-01', 'active'),
(96, 103, 18, '2026-01-01', 'active'),
(97, 104, 18, '2026-01-01', 'active'),
(98, 105, 18, '2026-01-01', 'active'),
(99, 106, 18, '2026-01-01', 'active'),
(100, 107, 18, '2026-01-01', 'active'),
(101, 108, 18, '2026-01-01', 'active'),
(102, 109, 18, '2026-01-01', 'active'),
(103, 110, 18, '2026-01-01', 'active'),
(104, 111, 18, '2026-01-01', 'active'),
(105, 112, 18, '2026-01-01', 'active'),
(106, 113, 18, '2026-01-02', 'active'),
(107, 114, 18, '2026-01-02', 'active'),
(108, 115, 18, '2026-01-02', 'active'),
(109, 116, 18, '2026-01-02', 'active'),
(110, 117, 18, '2026-01-02', 'active'),
(111, 118, 18, '2026-01-02', 'active'),
(112, 119, 18, '2026-01-02', 'active'),
(113, 120, 18, '2026-01-02', 'active'),
(114, 121, 18, '2026-01-02', 'active'),
(115, 122, 18, '2026-01-02', 'active'),
(116, 123, 18, '2026-01-02', 'active'),
(117, 124, 18, '2026-01-02', 'active'),
(118, 125, 18, '2026-01-02', 'active'),
(119, 126, 18, '2026-01-02', 'active'),
(120, 127, 18, '2026-01-02', 'active'),
(121, 128, 18, '2026-01-02', 'active'),
(122, 129, 18, '2026-01-02', 'active'),
(123, 130, 18, '2026-01-02', 'active'),
(124, 131, 18, '2026-01-02', 'active'),
(125, 132, 18, '2026-01-02', 'active'),
(126, 133, 18, '2026-01-02', 'active'),
(127, 134, 18, '2026-01-02', 'active'),
(128, 135, 18, '2026-01-02', 'active'),
(129, 136, 18, '2026-01-02', 'active'),
(130, 137, 18, '2026-01-02', 'active'),
(131, 138, 18, '2026-01-02', 'active'),
(132, 139, 18, '2026-01-02', 'active'),
(133, 140, 18, '2026-01-02', 'active'),
(134, 141, 18, '2026-01-02', 'active'),
(135, 145, 18, '2026-01-02', 'active'),
(136, 142, 18, '2026-01-02', 'active'),
(137, 143, 18, '2026-01-02', 'active'),
(138, 144, 18, '2026-01-02', 'active'),
(139, 146, 18, '2026-01-02', 'active'),
(140, 147, 18, '2026-01-02', 'active'),
(141, 148, 18, '2026-01-02', 'active'),
(142, 149, 18, '2026-01-02', 'active'),
(143, 150, 18, '2026-01-02', 'active'),
(144, 151, 18, '2026-01-02', 'active'),
(145, 152, 18, '2026-01-02', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `guardian`
--

CREATE TABLE `guardian` (
  `guardian_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `relationship` varchar(100) NOT NULL,
  `photo` varchar(250) NOT NULL,
  `qr_code` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guardiansaccount`
--

CREATE TABLE `guardiansaccount` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `relationship` varchar(50) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `municipality` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `street` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guardiansaccount`
--

INSERT INTO `guardiansaccount` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `relationship`, `contact_number`, `email`, `municipality`, `barangay`, `street`, `profile_pic`, `created_at`) VALUES
(37, 122, 'Clair Jolly', '', 'Si', 'Mother', '09178449343', 'karencagayat@gmail.com', 'Santa Cruz', 'Calios', 'ROAD 2 ATDRAMM VILLAGE', 'default.webp', '2025-12-31 08:16:06'),
(38, 123, 'LILIANNE GRACE', '', 'TAGUNICAR', 'Mother', '09991655382', 'roldanoliveros1001@gmail.com', 'Santa Cruz', 'Bagumbayan', 'SITIO 5', 'default.webp', '2025-12-31 09:48:02'),
(39, 124, 'MARILOU', '', 'KAMATOY', 'Mother', '09278495736', 'loukamatoy@gmail.com', 'Santa Cruz', 'Duhat', '', 'default.webp', '2025-12-31 10:01:19'),
(40, 125, 'MA. MARIELLE', '', 'LITAN', 'Mother', '09556756124', 'litanmayeh@gmail.com', 'Santa Cruz', 'Bagumbayan', 'SITIO 3', 'default.webp', '2025-12-31 11:22:36'),
(41, 126, 'FRANCESCA ANNIES', '', 'UNTIVERO', 'Mother', '09474558360', 'francescauntivero@deped.gov.ph', 'Santa Cruz', 'Bagumbayan', 'BLK 9 LOT 25 LYNVILLE 8', 'default.webp', '2025-12-31 11:33:45'),
(42, 127, 'CRISTINE', '', 'LEDESMA', 'Mother', '09278027749', 'cristine_leonardo@yahoo.com', 'Santa Cruz', 'Patimbao', 'SITIO 6 AGLAHI SUBD', 'default.webp', '2025-12-31 11:42:24'),
(43, 128, 'JENNIFER KRISTEL', '', 'VILLANUEVA', 'Mother', '09178795041', 'jenniferkristelcayetano@gmail.com', 'Santa Cruz', 'Patimbao', '527', 'default.webp', '2025-12-31 12:00:08'),
(44, 129, 'ANALYN', '', 'CAI SHI', 'Mother', '09272333769', 'roldanoliveros1002@gmail.com', 'Pagsanjan', 'Biñan', '', 'default.webp', '2025-12-31 12:48:57'),
(45, 130, 'ZERRINA', '', 'BARTOLOME', 'Mother', '09456709396', 'zemarasigan@gmail.com', 'Santa Cruz', 'Calios', 'PUROK MARCELO', 'default.webp', '2025-12-31 12:59:32'),
(46, 131, 'JOSHUAN', '', 'PEREZ', 'Father', '09567382694', 'defiestaveronica4@gmail.com', 'Santa Cruz', 'Bagumbayan', '', 'default.webp', '2025-12-31 15:28:26'),
(47, 132, 'LIZA', '', 'PERANTE', 'Mother', '09681100977', 'liza.perante@deped.gov.ph', 'Santa Cruz', 'Patimbao', '005 SITIO 3', 'default.webp', '2025-12-31 15:38:33'),
(48, 133, 'JENNIFER', '', 'VILLANUEVA', 'Mother', '09173160908', 'eferorendain@gmail.com', 'Santa Cruz', 'San Jose', 'BLK 3 LOT 19 BRIA HOMES', 'default.webp', '2025-12-31 15:57:36'),
(49, 134, 'ZYRA MAE', '', 'SUEÑA', 'Mother', '09708178880', 'suezyramae@gmail.com', 'Santa Cruz', 'Calios', 'MARCELO COMPOUND', 'default.webp', '2025-12-31 16:27:38'),
(50, 135, 'ALYZA', '', 'VERIDIANO', 'Mother', '09674212253', 'roldanoliveros1003@gmail.com', 'Santa Cruz', 'San Jose', 'LYNVILLE PHASE 3 BLK 9 LOT 8', 'default.webp', '2025-12-31 16:42:00'),
(51, 136, 'EYERICA', '', 'MARTINEZ', 'Mother', '09158684772', 'eyericayoshida@yahoo.com', 'Santa Cruz', 'Bagumbayan', 'SITIO 3', 'default.webp', '2025-12-31 17:47:20'),
(52, 137, 'MELANIE', '', 'MERCURIO', 'Mother', '09957245122', 'parganibanmelanie@gmail.com', 'Santa Cruz', 'Bagumbayan', 'SITIO 3', 'default.webp', '2025-12-31 18:12:36'),
(53, 138, 'SHERYLL', '', 'BALIJON', 'Mother', '09157778162', 'roldanoliveros1004@gmail.com', 'Santa Cruz', 'Bagumbayan', '', 'default.webp', '2026-01-01 13:30:36'),
(54, 139, 'SHAMAEIN', 'PAMBUAN', 'MANTES', 'Mother', '09338248737', 'maeinpambuan@gmail.com', 'Santa Cruz', 'San Pablo Norte', 'BLK 3 LOT 3 GREEN VILLAGE SUBD', 'default.webp', '2026-01-01 13:39:15'),
(55, 140, 'JOYCE GERALDINE', 'LIMPENGCO', 'ZAPANTA', 'Mother', '09178507705', 'joycelimpengco@gmail.com', 'Santa Cruz', 'Patimbao', '', 'default.webp', '2026-01-01 13:52:17'),
(56, 141, 'JOAN', '', 'RIGUER', 'Mother', '09550661490', 'joanriguer19@gmail.com', 'Santa Cruz', 'Bagumbayan', '', 'default.webp', '2026-01-01 14:14:57'),
(57, 142, 'DAUN NERICA', '', 'REYES', 'Mother', '09760948755', 'daunnericamiranda@gmail.com', 'Pagsanjan', 'Biñan', '', 'default.webp', '2026-01-01 14:29:12'),
(58, 143, 'EUNICE MILLIEZETH', '', 'BORNALES', 'Mother', '09123456789', 'roldanoliveros1005@gmail.com', 'Santa Cruz', 'Bagumbayan', 'PHASE 1 BLK 6 OPAL ST. LOT 18 LYNVILLE', 'default.webp', '2026-01-01 15:26:51'),
(59, 144, 'CATALYN ROSE', '', 'ANGELES', 'Mother', '09457293446', 'catalynrose@gmail.com', 'Santa Cruz', 'Patimbao', 'BLK 1 LOT 6, MARGARETTE VILLAGE', 'default.webp', '2026-01-01 16:04:07'),
(60, 145, 'KARL MARVIN', '', 'Tan', 'Mother', '09163321083', 'karl07tan@yahoo.com', 'Santa Cruz', 'Calios', '1077', 'default.webp', '2026-01-01 16:28:49'),
(61, 146, 'DONNAFER', '', 'PANGANIBAN', 'Mother', '09565743920', 'roldanoliveros1006@gamil.com', 'Santa Cruz', 'Bagumbayan', 'LYNVILLE 8', 'default.webp', '2026-01-01 16:40:53'),
(62, 147, 'CORINNE', '', 'MALOLOS', 'Mother', '09271439748', 'corinnemalolos@gmail.com', 'Santa Cruz', 'Bagumbayan', '4872', 'default.webp', '2026-01-01 16:46:48'),
(63, 148, 'DIANA FATIMA', '', 'LLAMOSO', 'Mother', '09175008704', 'escobardianef@gmail.com', 'Santa Cruz', 'Patimbao', '650', 'default.webp', '2026-01-01 17:03:19'),
(64, 149, 'KIRSTEN ANN', '', 'SUMAYA', 'Mother', '09177290706', 'kirstensumaya@gmail.com', 'Pila', 'Bagong Pook', 'BLK 5 LOT 3 TIERRA VERDE', 'default.webp', '2026-01-01 18:05:08'),
(65, 150, 'JESAMIN', '', 'GAGALAC', 'Mother', '09176540087', 'jesamingagalac@gmail.com', 'Santa Cruz', 'Patimbao', '5565 SITIO 6', 'default.webp', '2026-01-01 18:15:21'),
(66, 151, 'SHERLEINE', '', 'BERNARDINO', 'Mother', '09086878774', 'roldanoliveros1007@gmail.com', 'Santa Cruz', 'San Juan', '', 'default.webp', '2026-01-01 18:24:04'),
(67, 152, 'JOYCE ANN', '', 'RAMIRO', 'Mother', '09778533558', 'roldanoliveros1008@gmail.com', 'Santa Cruz', 'Patimbao', '5565', 'default.webp', '2026-01-02 05:12:36'),
(68, 153, 'ARCHELLENE', '', 'BANCA', 'Mother', '09693175603', 'roldanoliveros1009@gmail.com', 'Santa Cruz', 'Gatid', '331 SITIO MANGGAHAN', 'default.webp', '2026-01-02 05:22:18'),
(69, 154, 'CLARISSSA', '', 'VILLANUEVA', 'Mother', '09171628271', 'clarissavillanueva76@gmail.com', 'Santa Cruz', 'Bagumbayan', '5018 SITIO UNO', 'default.webp', '2026-01-02 05:28:45'),
(70, 155, 'CHELSEA', '', 'BELEN', 'Mother', '09366647115', 'roldanoliveros1010@gmail.com', 'Santa Cruz', 'Patimbao', '', 'default.webp', '2026-01-02 05:36:23'),
(71, 156, 'DEBORAH', 'ANANAYO', 'LEGASPI', 'Mother', '09678478900', 'roldanoliveros1011@gmail.com', 'Santa Cruz', 'Bagumbayan', '', 'default.webp', '2026-01-02 05:42:09'),
(72, 157, 'RAQUEL', '', 'CARO', 'Mother', '09770919569', 'roldaoliveros1012@gmail.com', 'Santa Cruz', 'Bubukal', '', 'default.webp', '2026-01-02 05:48:01'),
(73, 158, 'DIOVY ANN', '', 'TABLATE', 'Mother', '09460868688', 'diovyannt@yahoo.com', 'Santa Cruz', 'Santo Angel Norte', '3661 TSISMOSA ST.', 'default.webp', '2026-01-02 05:56:10'),
(74, 159, 'MARIA RITA FAY', '', 'GALIT', 'Mother', '09155094982', 'fayreyes15@yahoo.com', 'Santa Cruz', 'Gatid', '016 SITIO BUKANA', 'default.webp', '2026-01-02 06:05:25'),
(76, 161, 'CANDELL', '', 'ALAGON', 'Mother', '09062446241', 'roldanoliveros1013@gmail.com', 'Santa Cruz', 'Patimbao', 'SITIO VI', 'default.webp', '2026-01-02 06:40:08'),
(77, 162, 'RACHELLE ANNE', '', 'JAVIER', 'Mother', '09392014288', 'rapbonza@gmail.com', 'Santa Cruz', 'Gatid', 'BAYSIDE 1', 'default.webp', '2026-01-02 07:37:20'),
(78, 163, 'MERCY', 'ORFANO', 'BARROGA', 'Mother', '09778436830', 'roldanoliveros1018@gmail.com', 'Santa Cruz', 'Gatid', 'BLK 4 LOT 30 LYNVILLE DIAMOND SUBD.', 'default.webp', '2026-01-02 07:43:02'),
(79, 164, 'LYKA CLARISSA', '', 'BASA', 'Mother', '09158301080', 'LYKACLARISSA@gmail.com', 'Cavinti', 'Kanluran Talaongan', '056', 'default.webp', '2026-01-02 08:59:01'),
(80, 165, 'PAMELA', '', 'CASTILLO', 'Mother', '09777343727', 'PAMELA@gmail.com', 'Santa Cruz', 'Bagumbayan', 'SITIO', 'default.webp', '2026-01-02 09:24:54'),
(81, 166, 'PATRICIA XYRILLE', '', 'DORADO', 'Mother', '09064042318', 'patricia-xyrille@yahoo.com', 'Santa Cruz', 'Gatid', 'BLK 14 LOT II LYNVILLE DIAMOND SUBD', 'default.webp', '2026-01-02 09:34:03'),
(82, 167, 'GLIZELLE', '', 'MALLANAO', 'Mother', '09566896997', 'glizelle@gmail.com', 'Santa Cruz', 'Gatid', 'BLK 5 LOT 27 LYNVILLE DIAMOND SUBD', 'default.webp', '2026-01-02 10:29:21'),
(83, 168, 'KAYE', '', 'RAMOS', 'Mother', '09081963814', 'kayecondovara-0s@gmail.com', 'Santa Cruz', 'Bagumbayan', 'ROGER APT. UNIT 1, SITIO 5', 'default.webp', '2026-01-02 10:35:28'),
(84, 169, 'DHANA MAE', 'PUNONGBAYAN', 'CALMA', 'Mother', '09088501123', 'DHANA@gmail.com', 'Santa Cruz', 'San Juan', 'SITIO 5', 'default.webp', '2026-01-02 10:40:25'),
(85, 170, 'YVONNE BEATRICE', '', 'LIM', 'Mother', '09052211275', 'LIMYVONNE@gmail.com', 'Santa Cruz', 'Gatid', 'CAPITOL VILLAGE SUBD', 'default.webp', '2026-01-02 10:44:42'),
(86, 171, 'JOVILYN', '', 'SORIANO', 'Mother', '09686045813', 'JOVILYN@gmail.com', 'Santa Cruz', 'Bagumbayan', 'SITIO 5', 'default.webp', '2026-01-02 10:49:05'),
(87, 172, 'KATRINA', '', 'MULI', 'Mother', '09209734883', 'KATRINA@gmai.com', 'Pagsanjan', 'Sabang', 'MARESCO ROAD CORNER SAN LUIS ROAD', 'default.webp', '2026-01-02 10:53:42'),
(88, 173, 'ANN KRISTINE', '', 'LIWAG', 'Mother', '09284338658', 'ANN@gmail.com', 'Santa Cruz', 'Bagumbayan', '', 'default.webp', '2026-01-02 10:57:19'),
(89, 174, 'RAYECHELLE', '', 'TABUZO', 'Mother', '09287688125', 'RAYECHELLE@gmail.com', 'Santa Cruz', 'Santisima Cruz', 'P. FLORES ST', 'default.webp', '2026-01-02 11:00:44'),
(90, 175, 'MARYDOL', 'Ocampo', 'ALARVA', 'Mother', '09178529442', 'MARYDO@gmail.com', 'Santa Cruz', 'Gatid', '', 'default.webp', '2026-01-02 11:06:35'),
(91, 176, 'JOYCE CAROL', '', 'VALENCIA', 'Mother', '09976420440', 'JOYCE@gmail.com', 'Santa Cruz', 'Gatid', '', 'default.webp', '2026-01-02 11:10:37'),
(92, 177, 'MAYCIE', '', 'BOMBAY', 'Mother', '09628773301', 'MAYCIE@gmail.com', 'Santa Cruz', 'San Pablo Sur', '198 SITIO ROSAS', 'default.webp', '2026-01-02 11:14:31'),
(93, 178, 'VIVIAN', '', 'CALCETAS', 'Mother', '09155206271', 'VIVIAN@gmail.com', 'Santa Cruz', 'Bubukal', 'Sitio Rosal', 'default.webp', '2026-01-02 11:45:37'),
(94, 179, 'ARLETT', '', 'TABIGAY', 'Mother', '09955689169', 'ARLETT@GMAIL.COM', 'Santa Cruz', 'Bubukal', 'SITIO ROSAL', 'default.webp', '2026-01-02 11:54:39'),
(95, 180, 'JO - CHRISTINE', '', 'MACALINAO', 'Mother', '09171208740', 'CHRISTINE@GMAIL.COM', 'Pagsanjan', 'Pinagsanjan', '328 SITIO CUBAO', 'default.webp', '2026-01-02 11:59:01'),
(96, 181, 'ERILA PAULINE', '', 'BEGUICO', 'Mother', '09669252143', 'PAULINE@GMAIL.COM', 'Santa Cruz', 'Bubukal', '093 SITIO ROSAL', 'default.webp', '2026-01-02 12:28:12'),
(97, 182, 'ALIZA MAE', '', 'ALAGON', 'Mother', '09066811930', 'ALIZA@GMAIL.COM', 'Santa Cruz', 'Patimbao', 'SITIO 6 ILAYA', 'default.webp', '2026-01-02 12:36:58'),
(98, 183, 'JENNY ROSE', '', 'VILLANUEVA', 'Mother', '09123455678', 'JENNYROS@GMAIL.COM', 'Santa Cruz', 'Gatid', '', 'default.webp', '2026-01-02 12:41:16'),
(99, 184, 'WARREN MANUEL', '', 'RONDILLA', 'Mother', '09058090081', 'WARRENMANUEL@gmail.com', 'Santa Cruz', 'Bubukal', '125 BLK 13 LOT 23 VILLA REMEDIOS HOMES', 'default.webp', '2026-01-02 12:46:20'),
(101, 186, 'JOAN', '', 'CASABUENA', 'Mother', '09778092270', 'joancasabuena@gmail.com', 'Santa Cruz', 'Gatid', '', 'default.webp', '2026-01-02 13:14:33'),
(102, 187, 'RAYECHELLE', '', 'TABUZO', 'Mother', '09287688125', 'RAYECHELLETABUZO@gmail.com', 'Santa Cruz', 'Santisima Cruz', 'P. FLORES ST. SANTISIMA', 'default.webp', '2026-01-02 13:36:37'),
(103, 188, 'MARJIE MARIE', '', 'BATITIS', 'Mother', '09755505767', 'MARJIEMARIE@gmail.com', 'Santa Cruz', 'Bagumbayan', 'SITIO 2', 'default.webp', '2026-01-02 13:41:19'),
(104, 189, 'ROSE MICHELLE', '', 'LOPEZ', 'Mother', '09124204339', 'ROSEMICHELLE@GMAIL.COM', 'Santa Cruz', 'Patimbao', '9574 SITIO 2', 'default.webp', '2026-01-02 13:46:39'),
(105, 190, 'CAMILLE', '', 'NARVADEZ', 'Mother', '09081451165', 'CAMILLE@GMAIL.COM', 'Santa Cruz', 'Calios', '2216 ROAD 2 ATDRAMM VILLAGE', 'default.webp', '2026-01-02 13:51:22'),
(106, 191, 'KIARA GLYZEE', 'IPAPO', 'LORENZO', 'Mother', '09171672617', 'KIARAGLYZEE@GMAIL.COM', 'Pila', 'Bagong Pook', 'BLK 11 LOT 7 TIERRA VERDE', 'default.webp', '2026-01-02 13:58:10'),
(107, 192, 'HAZEL', '', 'SANDOVAL', 'Mother', '09539931699', 'HAZELSANDOVAL@GMAIL.COM', 'Santa Cruz', 'Bagumbayan', 'SITIO 5', 'default.webp', '2026-01-02 14:01:39'),
(108, 193, 'JOYCE GERALDINE', 'LIMPENGCO', 'ZAPANTA', 'Mother', '09178507705', 'JOYCEGERALDINE@GMAIL.COM', 'Santa Cruz', 'Patimbao', 'EL BASILIO', 'default.webp', '2026-01-02 14:05:50'),
(109, 194, 'ROCHELLE ANN', '', 'CHUA', 'Mother', '09178909158', 'ROCHELLEANN@GMAIL.COM', 'Santa Cruz', 'Patimbao', '', 'default.webp', '2026-01-02 14:10:25'),
(110, 195, 'ROMALYN', '', 'TAN', 'Mother', '09817929889', 'ROMALYNTAN@GMAIL.COM', 'Santa Cruz', 'Santo Angel Sur', '2927 HIPON ST.', 'default.webp', '2026-01-02 14:14:21'),
(111, 196, 'CHELSEA CIEL', '', 'CORELLA', 'Mother', '09524831781', 'CHELSEACIEL@GMAIL.COM', 'Santa Cruz', 'Santo Angel Norte', 'HARMEL LA CHESKA COMPOUND, 9110 ROSA ST', 'default.webp', '2026-01-02 14:18:10'),
(112, 197, 'ANGELA CARLA', '', 'CALANDRIA', 'Mother', '09164830508', 'ANGELACARLA@GMAIL.COM', 'Santa Cruz', 'Gatid', 'BLK 6 LOT 5 LYNVILLE DIAMOND', 'default.webp', '2026-01-02 14:21:38');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` varchar(250) NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `type`, `is_read`, `created_at`, `updated_at`) VALUES
(343, 1, 'New Admission', 'A new admission has been submitted by Kalisha Blaire Parilla', 'admission', 1, '2025-12-31 08:21:13', '2025-12-31 09:34:26'),
(344, 122, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 09:34:36', '2025-12-31 09:34:36'),
(345, 122, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 09:36:03', '2025-12-31 09:36:08'),
(346, 1, 'New Admission', 'A new admission has been submitted by Hanniel Tagunicar', 'admission', 1, '2025-12-31 09:52:56', '2025-12-31 09:53:00'),
(347, 123, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 09:53:08', '2025-12-31 09:53:09'),
(348, 123, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 09:53:29', '2025-12-31 09:54:26'),
(349, 1, 'New Admission', 'A new admission has been submitted by Eloise Margrethe Kamatoy', 'admission', 1, '2025-12-31 11:16:38', '2025-12-31 11:16:43'),
(350, 124, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 11:16:55', '2025-12-31 11:16:55'),
(351, 124, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 11:17:26', '2025-12-31 11:17:44'),
(352, 1, 'New Admission', 'A new admission has been submitted by Gabriel Lorenz Litan', 'admission', 1, '2025-12-31 11:26:35', '2025-12-31 11:26:42'),
(353, 125, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 11:26:50', '2025-12-31 11:26:50'),
(354, 125, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 11:27:00', '2025-12-31 11:27:03'),
(355, 1, 'New Admission', 'A new admission has been submitted by Sia Cassandra Untivero', 'admission', 1, '2025-12-31 11:37:26', '2025-12-31 11:38:05'),
(356, 126, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 11:38:17', '2025-12-31 11:38:17'),
(357, 126, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 11:38:28', '2025-12-31 11:39:08'),
(358, 1, 'New Admission', 'A new admission has been submitted by Alonzo Isaac Ledesma', 'admission', 1, '2025-12-31 11:55:25', '2025-12-31 11:55:29'),
(359, 127, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 11:55:37', '2025-12-31 11:55:37'),
(360, 127, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 11:55:49', '2025-12-31 11:56:51'),
(361, 1, 'New Admission', 'A new admission has been submitted by Josethen Kenamarie Villanueva', 'admission', 1, '2025-12-31 12:03:37', '2025-12-31 12:03:45'),
(362, 128, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 12:03:58', '2025-12-31 12:03:58'),
(363, 128, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 12:04:09', '2025-12-31 12:44:32'),
(364, 1, 'New Admission', 'A new admission has been submitted by Amiyah Emerithz Lim', 'admission', 1, '2025-12-31 12:53:39', '2025-12-31 12:53:48'),
(365, 129, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 12:54:55', '2025-12-31 12:54:56'),
(366, 129, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 12:55:09', '2025-12-31 13:06:23'),
(367, 1, 'New Admission', 'A new admission has been submitted by Eonna Zerrilmarasigan Bartolome', 'admission', 1, '2025-12-31 13:11:27', '2025-12-31 13:11:31'),
(368, 130, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 13:11:42', '2025-12-31 13:11:42'),
(369, 130, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 13:11:53', '2025-12-31 15:26:30'),
(370, 1, 'New Admission', 'A new admission has been submitted by Troy Perez', 'admission', 1, '2025-12-31 15:31:31', '2025-12-31 15:33:37'),
(371, 131, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 15:33:48', '2025-12-31 15:33:48'),
(372, 131, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 15:33:59', '2025-12-31 15:34:15'),
(373, 1, 'New Admission', 'A new admission has been submitted by Seth Levin Perante', 'admission', 1, '2025-12-31 15:41:39', '2025-12-31 15:41:47'),
(374, 132, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 15:41:55', '2025-12-31 15:41:55'),
(375, 132, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 15:42:05', '2025-12-31 16:18:29'),
(376, 1, 'New Admission', 'A new admission has been submitted by Dwyane Marcio Villanueva', 'admission', 1, '2025-12-31 16:22:09', '2025-12-31 16:22:13'),
(377, 133, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 16:22:24', '2025-12-31 16:22:24'),
(378, 133, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 16:22:33', '2025-12-31 16:23:52'),
(379, 1, 'New Admission', 'A new admission has been submitted by Zachary Damian Suena', 'admission', 1, '2025-12-31 16:31:03', '2025-12-31 16:32:11'),
(380, 134, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 16:32:41', '2025-12-31 16:32:42'),
(381, 134, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 16:33:06', '2025-12-31 16:36:44'),
(382, 1, 'New Admission', 'A new admission has been submitted by Athalia Mae Veridiano De Guzman', 'admission', 1, '2025-12-31 17:42:38', '2025-12-31 17:43:05'),
(383, 135, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 17:43:13', '2025-12-31 17:43:13'),
(384, 135, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 17:43:24', '2025-12-31 17:51:04'),
(385, 1, 'New Admission', 'A new admission has been submitted by Heather Halley Martinez', 'admission', 1, '2025-12-31 17:50:58', '2025-12-31 17:51:04'),
(386, 136, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 17:51:12', '2025-12-31 17:51:12'),
(387, 136, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 17:51:23', '2025-12-31 17:55:46'),
(388, 1, 'New Admission', 'A new admission has been submitted by Skyler Mercurio', 'admission', 1, '2025-12-31 18:16:07', '2025-12-31 18:16:11'),
(389, 137, 'Admission', 'admission Updated status', 'admission', 1, '2025-12-31 18:16:19', '2025-12-31 18:16:20'),
(390, 137, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2025-12-31 18:16:30', '2026-01-01 13:35:00'),
(391, 1, 'New Admission', 'A new admission has been submitted by Marcus Freire Balijon', 'admission', 1, '2026-01-01 13:33:40', '2026-01-01 13:35:00'),
(392, 138, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 13:35:08', '2026-01-01 13:35:09'),
(393, 138, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 13:35:20', '2026-01-01 13:35:53'),
(394, 1, 'New Admission', 'A new admission has been submitted by Eusha Agape Mantes', 'admission', 1, '2026-01-01 13:42:03', '2026-01-01 13:42:35'),
(395, 139, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 13:42:43', '2026-01-01 13:42:43'),
(396, 139, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 13:42:56', '2026-01-01 13:59:31'),
(397, 1, 'New Admission', 'A new admission has been submitted by Ethaniel Drake Zapanta', 'admission', 1, '2026-01-01 13:59:27', '2026-01-01 13:59:31'),
(398, 140, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 13:59:38', '2026-01-01 13:59:39'),
(399, 140, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 13:59:48', '2026-01-01 14:19:32'),
(400, 1, 'New Admission', 'A new admission has been submitted by Allynx Riguer', 'admission', 1, '2026-01-01 14:19:08', '2026-01-01 14:19:32'),
(401, 141, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 14:19:42', '2026-01-01 14:19:42'),
(402, 141, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 14:19:53', '2026-01-01 14:20:42'),
(403, 1, 'New Admission', 'A new admission has been submitted by Rebecca Helaina Reyes', 'admission', 1, '2026-01-01 14:32:51', '2026-01-01 14:32:58'),
(404, 142, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 14:33:06', '2026-01-01 14:33:06'),
(405, 142, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 14:33:19', '2026-01-01 14:35:21'),
(406, 1, 'New Admission', 'A new admission has been submitted by Arkisha Alliezenth Escuadro', 'admission', 1, '2026-01-01 15:58:30', '2026-01-01 15:58:34'),
(407, 143, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 15:58:42', '2026-01-01 15:58:42'),
(408, 143, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 15:58:54', '2026-01-01 16:07:44'),
(409, 1, 'New Admission', 'A new admission has been submitted by Koleen Natalie Angeles', 'admission', 1, '2026-01-01 16:07:38', '2026-01-01 16:07:44'),
(410, 144, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 16:07:51', '2026-01-01 16:07:51'),
(411, 144, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 16:08:01', '2026-01-01 16:31:59'),
(412, 1, 'New Admission', 'A new admission has been submitted by Zarina Cassidy Tan', 'admission', 1, '2026-01-01 16:31:50', '2026-01-01 16:31:59'),
(413, 145, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 16:32:06', '2026-01-01 16:32:06'),
(414, 145, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 16:32:18', '2026-01-01 16:33:54'),
(415, 1, 'New Admission', 'A new admission has been submitted by Dean Castiel Panganiban', 'admission', 1, '2026-01-01 16:43:30', '2026-01-01 16:43:37'),
(416, 146, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 16:43:45', '2026-01-01 16:43:45'),
(417, 146, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 16:43:57', '2026-01-01 16:44:17'),
(418, 1, 'New Admission', 'A new admission has been submitted by Antoni Kalen Guzman', 'admission', 1, '2026-01-01 16:53:14', '2026-01-01 16:53:44'),
(419, 147, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 16:53:51', '2026-01-01 16:53:51'),
(420, 147, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 16:54:01', '2026-01-01 16:56:51'),
(421, 1, 'New Admission', 'A new admission has been submitted by Evee Antonelle Llamoso', 'admission', 1, '2026-01-01 17:07:51', '2026-01-01 17:08:11'),
(422, 148, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 17:08:19', '2026-01-01 17:08:19'),
(423, 148, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 17:09:16', '2026-01-01 18:00:52'),
(424, 1, 'New Admission', 'A new admission has been submitted by Julio Anton Choa', 'admission', 1, '2026-01-01 18:08:40', '2026-01-01 18:08:47'),
(425, 149, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 18:08:54', '2026-01-01 18:08:54'),
(426, 149, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 18:09:06', '2026-01-01 18:19:03'),
(427, 149, 'Profile edit', 'Profile Updated', 'Update', 0, '2026-01-01 18:09:39', '2026-01-01 18:09:39'),
(428, 1, 'New Admission', 'A new admission has been submitted by Avrilla Rain Gagalac', 'admission', 1, '2026-01-01 18:18:55', '2026-01-01 18:19:03'),
(429, 150, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 18:19:10', '2026-01-01 18:19:14'),
(430, 150, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 18:19:13', '2026-01-01 18:19:14'),
(431, 150, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 18:19:24', '2026-01-01 19:22:06'),
(432, 150, 'Profile edit', 'Profile Updated', 'Update', 0, '2026-01-01 18:19:50', '2026-01-01 18:19:50'),
(433, 1, 'New Admission', 'A new admission has been submitted by Sevan Sky Brandt Bernardino', 'admission', 1, '2026-01-01 18:27:13', '2026-01-01 19:22:06'),
(434, 151, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-01 19:22:13', '2026-01-01 19:22:13'),
(435, 151, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-01 19:22:49', '2026-01-02 05:17:50'),
(436, 1, 'New Admission', 'A new admission has been submitted by Hezekiah Jayce Ramiro', 'admission', 1, '2026-01-02 05:15:35', '2026-01-02 05:17:50'),
(437, 152, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 05:18:00', '2026-01-02 05:18:00'),
(438, 152, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 05:18:16', '2026-01-02 05:24:48'),
(439, 1, 'New Admission', 'A new admission has been submitted by Christen Brielle Sison', 'admission', 1, '2026-01-02 05:24:45', '2026-01-02 05:24:48'),
(440, 153, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 05:24:56', '2026-01-02 05:25:00'),
(441, 153, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 05:25:00', '2026-01-02 05:25:00'),
(442, 153, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 05:25:12', '2026-01-02 05:32:04'),
(443, 1, 'New Admission', 'A new admission has been submitted by Miquella Villanueva', 'admission', 1, '2026-01-02 05:32:01', '2026-01-02 05:32:04'),
(444, 154, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 05:32:13', '2026-01-02 05:32:13'),
(445, 154, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 05:32:23', '2026-01-02 05:38:35'),
(446, 154, 'Profile edit', 'Profile Updated', 'Update', 0, '2026-01-02 05:32:40', '2026-01-02 05:32:40'),
(447, 1, 'New Admission', 'A new admission has been submitted by Azaela Belen', 'admission', 1, '2026-01-02 05:38:22', '2026-01-02 05:38:35'),
(448, 155, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 05:38:42', '2026-01-02 05:38:42'),
(449, 155, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 05:38:53', '2026-01-02 05:44:57'),
(450, 1, 'New Admission', 'A new admission has been submitted by Airrah Gabrielle Legaspi', 'admission', 1, '2026-01-02 05:44:54', '2026-01-02 05:44:57'),
(451, 156, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 05:45:05', '2026-01-02 05:45:06'),
(452, 156, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 05:45:19', '2026-01-02 05:53:18'),
(453, 1, 'New Admission', 'A new admission has been submitted by Stephen Caden Caro', 'admission', 1, '2026-01-02 05:51:23', '2026-01-02 05:53:18'),
(454, 157, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 05:53:25', '2026-01-02 05:53:25'),
(455, 157, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 05:53:35', '2026-01-02 05:58:59'),
(456, 1, 'New Admission', 'A new admission has been submitted by Zhaym Andrew Tablate', 'admission', 1, '2026-01-02 05:58:55', '2026-01-02 05:58:59'),
(457, 158, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 05:59:09', '2026-01-02 05:59:09'),
(458, 158, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 05:59:24', '2026-01-02 06:10:51'),
(459, 158, 'Profile edit', 'Profile Updated', 'Update', 0, '2026-01-02 05:59:51', '2026-01-02 05:59:51'),
(460, 1, 'New Admission', 'A new admission has been submitted by Skye Tristan Galit', 'admission', 1, '2026-01-02 06:10:48', '2026-01-02 06:10:51'),
(461, 159, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 06:10:58', '2026-01-02 06:10:58'),
(462, 159, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 06:11:09', '2026-01-02 06:20:56'),
(463, 159, 'Profile edit', 'Profile Updated', 'Update', 0, '2026-01-02 06:11:40', '2026-01-02 06:11:40'),
(464, 1, 'New Admission', 'A new admission has been submitted by Joseth Kedvin Villanueva', 'admission', 1, '2026-01-02 06:20:49', '2026-01-02 06:20:56'),
(465, 160, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 06:21:02', '2026-01-02 06:21:03'),
(466, 160, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 06:21:13', '2026-01-02 06:25:16'),
(467, 1, 'New Admission', 'A new admission has been submitted by Jace Primo Alagon', 'admission', 1, '2026-01-02 06:43:27', '2026-01-02 06:43:38'),
(468, 161, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 06:43:45', '2026-01-02 06:43:45'),
(469, 161, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 06:43:56', '2026-01-02 07:39:53'),
(470, 1, 'New Admission', 'A new admission has been submitted by Calix Winter Jace Javier', 'admission', 1, '2026-01-02 07:39:50', '2026-01-02 07:39:53'),
(471, 162, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 07:40:01', '2026-01-02 07:40:01'),
(472, 162, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 07:40:12', '2026-01-02 07:46:32'),
(473, 1, 'New Admission', 'A new admission has been submitted by Jazzy Nestar Barroga', 'admission', 1, '2026-01-02 07:46:27', '2026-01-02 07:46:32'),
(474, 163, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 07:46:38', '2026-01-02 07:46:38'),
(475, 163, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 07:46:47', '2026-01-02 09:23:09'),
(476, 1, 'New Admission', 'A new admission has been submitted by Khael Mattias Basa', 'admission', 1, '2026-01-02 09:22:55', '2026-01-02 09:23:09'),
(477, 164, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 09:23:16', '2026-01-02 09:23:16'),
(478, 164, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 09:23:28', '2026-01-02 09:30:20'),
(479, 1, 'New Admission', 'A new admission has been submitted by Jadd Deon Castillo', 'admission', 1, '2026-01-02 09:27:03', '2026-01-02 09:30:20'),
(480, 165, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 09:30:39', '2026-01-02 09:30:39'),
(481, 165, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 09:31:11', '2026-01-02 09:31:33'),
(482, 1, 'New Admission', 'A new admission has been submitted by Philip Xavier Dorado', 'admission', 1, '2026-01-02 09:36:09', '2026-01-02 09:36:13'),
(483, 166, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 09:36:20', '2026-01-02 09:36:20'),
(484, 166, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 09:36:32', '2026-01-02 10:02:02'),
(485, 166, 'Profile edit', 'Profile Updated', 'Update', 0, '2026-01-02 09:37:12', '2026-01-02 09:37:12'),
(486, 1, 'New Admission', 'A new admission has been submitted by Lucas Gabriel Mallanao', 'admission', 1, '2026-01-02 10:31:45', '2026-01-02 10:32:16'),
(487, 167, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 10:32:22', '2026-01-02 10:32:22'),
(488, 167, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 10:32:33', '2026-01-02 10:37:46'),
(489, 1, 'New Admission', 'A new admission has been submitted by Samantha Ysabelle Ramos', 'admission', 1, '2026-01-02 10:37:45', '2026-01-02 10:37:46'),
(490, 168, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 10:37:54', '2026-01-02 10:37:54'),
(491, 168, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 10:38:04', '2026-01-02 10:42:46'),
(492, 168, 'Profile edit', 'Profile Updated', 'Update', 0, '2026-01-02 10:38:27', '2026-01-02 10:38:27'),
(493, 1, 'New Admission', 'A new admission has been submitted by Johana Haniah Calma', 'admission', 1, '2026-01-02 10:42:41', '2026-01-02 10:42:46'),
(494, 169, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 10:42:53', '2026-01-02 10:42:53'),
(495, 169, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 10:43:08', '2026-01-02 10:46:27'),
(496, 1, 'New Admission', 'A new admission has been submitted by Yvanne Noah Lim', 'admission', 1, '2026-01-02 10:46:24', '2026-01-02 10:46:27'),
(497, 170, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 10:46:32', '2026-01-02 10:46:33'),
(498, 170, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 10:46:44', '2026-01-02 10:51:16'),
(499, 1, 'New Admission', 'A new admission has been submitted by Naomi Soriano', 'admission', 1, '2026-01-02 10:51:14', '2026-01-02 10:51:16'),
(500, 171, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 10:51:22', '2026-01-02 10:51:22'),
(501, 171, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 10:51:48', '2026-01-02 10:55:33'),
(502, 1, 'New Admission', 'A new admission has been submitted by Tomas Primo Muli', 'admission', 1, '2026-01-02 10:55:29', '2026-01-02 10:55:33'),
(503, 172, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 10:55:41', '2026-01-02 10:55:41'),
(504, 172, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 10:55:53', '2026-01-02 12:55:44'),
(505, 1, 'New Admission', 'A new admission has been submitted by Khloe Ann Liwag', 'admission', 1, '2026-01-02 10:59:04', '2026-01-02 12:55:44'),
(506, 1, 'New Admission', 'A new admission has been submitted by Arya Eledelia Tabuzo', 'admission', 1, '2026-01-02 11:03:03', '2026-01-02 12:55:44'),
(507, 1, 'New Admission', 'A new admission has been submitted by Jeremiah Rolcy Alarva', 'admission', 1, '2026-01-02 11:08:58', '2026-01-02 12:55:44'),
(508, 1, 'New Admission', 'A new admission has been submitted by Maxene OrdoñEz', 'admission', 1, '2026-01-02 11:12:29', '2026-01-02 12:55:44'),
(509, 1, 'New Admission', 'A new admission has been submitted by Aziel Luke Gonzales', 'admission', 1, '2026-01-02 11:42:33', '2026-01-02 12:55:44'),
(510, 1, 'New Admission', 'A new admission has been submitted by Cassandra Christelle Calcetas', 'admission', 1, '2026-01-02 11:52:42', '2026-01-02 12:55:44'),
(511, 1, 'New Admission', 'A new admission has been submitted by Ruth Anne Pamatmat', 'admission', 1, '2026-01-02 11:56:46', '2026-01-02 12:55:44'),
(512, 1, 'New Admission', 'A new admission has been submitted by Atasha Zion Primo Matthaeus Macalinao', 'admission', 1, '2026-01-02 12:02:59', '2026-01-02 12:55:44'),
(513, 1, 'New Admission', 'A new admission has been submitted by Atasha Brielle Beguico', 'admission', 1, '2026-01-02 12:30:09', '2026-01-02 12:55:44'),
(514, 1, 'New Admission', 'A new admission has been submitted by Chase Ephraim Eduria Alagon', 'admission', 1, '2026-01-02 12:39:43', '2026-01-02 12:55:44'),
(515, 1, 'New Admission', 'A new admission has been submitted by Avianna Shea Villanueva', 'admission', 1, '2026-01-02 12:44:34', '2026-01-02 12:55:44'),
(516, 1, 'New Admission', 'A new admission has been submitted by Warren Manuel Rondilla', 'admission', 1, '2026-01-02 12:48:36', '2026-01-02 12:55:44'),
(517, 1, 'New Admission', 'A new admission has been submitted by Viela Elise Basa', 'admission', 1, '2026-01-02 12:55:38', '2026-01-02 12:55:44'),
(518, 173, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 12:57:24', '2026-01-02 12:57:25'),
(519, 174, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 12:57:32', '2026-01-02 12:57:32'),
(520, 175, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 12:57:40', '2026-01-02 12:57:40'),
(521, 176, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 12:57:49', '2026-01-02 12:57:49'),
(522, 177, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 12:57:56', '2026-01-02 12:57:57'),
(523, 178, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 12:58:04', '2026-01-02 12:58:04'),
(524, 179, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 12:58:12', '2026-01-02 12:58:12'),
(525, 180, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 12:58:20', '2026-01-02 12:58:20'),
(526, 176, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 12:58:47', '2026-01-02 12:58:52'),
(527, 173, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 12:58:57', '2026-01-02 12:59:01'),
(528, 174, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 12:59:06', '2026-01-02 12:59:09'),
(529, 175, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 12:59:15', '2026-01-02 12:59:18'),
(530, 181, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 12:59:28', '2026-01-02 12:59:29'),
(531, 177, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 12:59:40', '2026-01-02 12:59:44'),
(532, 178, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 12:59:57', '2026-01-02 13:00:00'),
(533, 179, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 13:00:22', '2026-01-02 13:00:25'),
(534, 180, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 13:00:31', '2026-01-02 13:00:36'),
(535, 181, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 13:00:43', '2026-01-02 13:00:45'),
(536, 182, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 13:00:55', '2026-01-02 13:00:55'),
(537, 183, 'Admission', 'admission Updated status', 'admission', 1, '2026-01-02 13:01:05', '2026-01-02 13:01:05'),
(538, 182, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 13:01:23', '2026-01-02 13:01:31'),
(539, 183, 'Admission', 'Your child is officialy enrolled', 'admission', 1, '2026-01-02 13:01:38', '2026-01-02 13:01:44'),
(540, 1, 'New Admission', 'A new admission has been submitted by Riley Brielle Litan', 'admission', 1, '2026-01-02 13:07:02', '2026-01-02 13:35:13'),
(541, 1, 'New Admission', 'A new admission has been submitted by Michaela Gray Casabuena', 'admission', 1, '2026-01-02 13:16:37', '2026-01-02 13:35:13'),
(542, 1, 'New Admission', 'A new admission has been submitted by Arlo Evaris Tabuzo', 'admission', 1, '2026-01-02 13:39:15', '2026-01-02 13:43:39'),
(543, 1, 'New Admission', 'A new admission has been submitted by Maria Stella Batitis', 'admission', 0, '2026-01-02 13:44:40', '2026-01-02 13:44:40'),
(544, 1, 'New Admission', 'A new admission has been submitted by Annedrew Lopez', 'admission', 0, '2026-01-02 13:49:47', '2026-01-02 13:49:47'),
(545, 1, 'New Admission', 'A new admission has been submitted by Rafaelle Luzio Narvadez', 'admission', 0, '2026-01-02 13:55:26', '2026-01-02 13:55:26'),
(546, 1, 'New Admission', 'A new admission has been submitted by Mason Bryce Lorenzo', 'admission', 0, '2026-01-02 14:00:30', '2026-01-02 14:00:30'),
(547, 1, 'New Admission', 'A new admission has been submitted by Pricess Luna Galicia', 'admission', 0, '2026-01-02 14:03:56', '2026-01-02 14:03:56'),
(548, 1, 'New Admission', 'A new admission has been submitted by Zoe Claire Zapanta', 'admission', 0, '2026-01-02 14:08:44', '2026-01-02 14:08:44'),
(549, 1, 'New Admission', 'A new admission has been submitted by Henry Emmanuel Chua', 'admission', 0, '2026-01-02 14:12:50', '2026-01-02 14:12:50'),
(550, 1, 'New Admission', 'A new admission has been submitted by Gabriel Louis Tan', 'admission', 0, '2026-01-02 14:16:19', '2026-01-02 14:16:19'),
(551, 1, 'New Admission', 'A new admission has been submitted by Emilia Ciel Chan Corella', 'admission', 0, '2026-01-02 14:20:29', '2026-01-02 14:20:29'),
(552, 1, 'New Admission', 'A new admission has been submitted by Julian Ansel Calandria', 'admission', 0, '2026-01-02 14:23:31', '2026-01-02 14:23:31');

-- --------------------------------------------------------

--
-- Table structure for table `openingclosing`
--

CREATE TABLE `openingclosing` (
  `id` int(11) NOT NULL,
  `opendate` date NOT NULL,
  `closedate` date NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'open',
  `school_year` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `openingclosing`
--

INSERT INTO `openingclosing` (`id`, `opendate`, `closedate`, `status`, `school_year`) VALUES
(18, '2025-12-11', '2026-12-30', 'open', '2025-2026');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL,
  `remaining_balance` decimal(10,2) NOT NULL,
  `payment_method` enum('Cash','Online') NOT NULL,
  `payment_date` date NOT NULL,
  `status` enum('Pending','Paid') NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `user_id`, `plan_id`, `amount_paid`, `remaining_balance`, `payment_method`, `payment_date`, `status`) VALUES
(282, 91, 2, 2000.00, 0.00, 'Cash', '2025-12-31', 'Paid'),
(283, 92, 2, 2000.00, 0.00, 'Cash', '2025-12-31', 'Paid'),
(284, 93, 2, 2000.00, 0.00, 'Cash', '2025-12-31', 'Paid'),
(285, 94, 2, 2000.00, 0.00, 'Cash', '2025-12-31', 'Paid'),
(286, 95, 2, 2000.00, 0.00, 'Cash', '2025-12-31', 'Paid'),
(287, 96, 2, 2000.00, 0.00, 'Cash', '2025-12-31', 'Paid'),
(288, 97, 2, 2000.00, 0.00, 'Cash', '2025-12-31', 'Paid'),
(289, 98, 2, 2000.00, 0.00, 'Cash', '2025-12-31', 'Paid'),
(290, 99, 2, 2000.00, 0.00, 'Cash', '2025-12-31', 'Paid'),
(291, 100, 2, 2000.00, 0.00, 'Cash', '2025-12-31', 'Paid'),
(292, 101, 2, 2000.00, 0.00, 'Cash', '2025-12-31', 'Paid'),
(293, 102, 2, 2000.00, 0.00, 'Cash', '2026-01-01', 'Paid'),
(294, 103, 2, 2000.00, 0.00, 'Cash', '2026-01-01', 'Paid'),
(295, 104, 2, 2000.00, 0.00, 'Cash', '2026-01-01', 'Paid'),
(296, 105, 2, 2000.00, 0.00, 'Cash', '2026-01-01', 'Paid'),
(297, 106, 2, 2000.00, 0.00, 'Cash', '2026-01-01', 'Paid'),
(298, 107, 2, 2000.00, 0.00, 'Cash', '2026-01-01', 'Paid'),
(299, 108, 2, 2000.00, 0.00, 'Cash', '2026-01-01', 'Paid'),
(300, 109, 2, 2000.00, 0.00, 'Cash', '2026-01-01', 'Paid'),
(301, 110, 2, 2000.00, 0.00, 'Cash', '2026-01-01', 'Paid'),
(302, 111, 2, 2000.00, 0.00, 'Cash', '2026-01-01', 'Paid'),
(303, 112, 2, 2000.00, 0.00, 'Cash', '2026-01-01', 'Paid'),
(304, 113, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(305, 114, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(306, 115, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(307, 116, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(308, 117, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(309, 118, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(310, 119, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(311, 120, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(312, 121, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(313, 122, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(314, 123, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(315, 124, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(316, 125, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(317, 126, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(318, 127, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(319, 128, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(320, 129, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(321, 130, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(322, 131, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(323, 132, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(324, 133, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(325, 134, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(326, 135, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(327, 136, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(328, 137, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(329, 138, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(330, 139, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(331, 140, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(332, 141, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(333, 145, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(334, 142, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(335, 143, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(336, 144, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(337, 146, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(338, 147, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(339, 148, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(340, 149, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(341, 150, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(342, 151, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid'),
(343, 152, 2, 2000.00, 0.00, 'Cash', '2026-01-02', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `paymentschedule`
--

CREATE TABLE `paymentschedule` (
  `schedule_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `amount_due` decimal(10,2) NOT NULL,
  `remaining_balance` decimal(10,2) NOT NULL,
  `status` enum('Pending','Paid','Overdue') DEFAULT 'Pending',
  `late_fee` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `paymentschedule`
--

INSERT INTO `paymentschedule` (`schedule_id`, `user_id`, `plan_id`, `due_date`, `amount_due`, `remaining_balance`, `status`, `late_fee`) VALUES
(562, 91, 4, '2025-12-31', 2500.00, 2500.00, 'Pending', 0.00),
(563, 91, 4, '2026-01-31', 2500.00, 2500.00, 'Pending', 0.00),
(564, 91, 4, '2026-03-03', 2500.00, 2500.00, 'Pending', 0.00),
(565, 91, 4, '2026-03-31', 2500.00, 2500.00, 'Pending', 0.00),
(566, 91, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(567, 91, 4, '2026-05-31', 2500.00, 2500.00, 'Pending', 0.00),
(568, 91, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(569, 91, 4, '2026-07-31', 2500.00, 2500.00, 'Pending', 0.00),
(570, 91, 4, '2026-08-31', 2500.00, 2500.00, 'Pending', 0.00),
(571, 91, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(572, 92, 4, '2025-12-31', 2500.00, 2500.00, 'Pending', 0.00),
(573, 92, 4, '2026-01-31', 2500.00, 2500.00, 'Pending', 0.00),
(574, 92, 4, '2026-03-03', 2500.00, 2500.00, 'Pending', 0.00),
(575, 92, 4, '2026-03-31', 2500.00, 2500.00, 'Pending', 0.00),
(576, 92, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(577, 92, 4, '2026-05-31', 2500.00, 2500.00, 'Pending', 0.00),
(578, 92, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(579, 92, 4, '2026-07-31', 2500.00, 2500.00, 'Pending', 0.00),
(580, 92, 4, '2026-08-31', 2500.00, 2500.00, 'Pending', 0.00),
(581, 92, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(582, 93, 4, '2025-12-31', 2500.00, 2500.00, 'Pending', 0.00),
(583, 93, 4, '2026-01-31', 2500.00, 2500.00, 'Pending', 0.00),
(584, 93, 4, '2026-03-03', 2500.00, 2500.00, 'Pending', 0.00),
(585, 93, 4, '2026-03-31', 2500.00, 2500.00, 'Pending', 0.00),
(586, 93, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(587, 93, 4, '2026-05-31', 2500.00, 2500.00, 'Pending', 0.00),
(588, 93, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(589, 93, 4, '2026-07-31', 2500.00, 2500.00, 'Pending', 0.00),
(590, 93, 4, '2026-08-31', 2500.00, 2500.00, 'Pending', 0.00),
(591, 93, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(592, 94, 4, '2025-12-31', 2500.00, 2500.00, 'Pending', 0.00),
(593, 94, 4, '2026-01-31', 2500.00, 2500.00, 'Pending', 0.00),
(594, 94, 4, '2026-03-03', 2500.00, 2500.00, 'Pending', 0.00),
(595, 94, 4, '2026-03-31', 2500.00, 2500.00, 'Pending', 0.00),
(596, 94, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(597, 94, 4, '2026-05-31', 2500.00, 2500.00, 'Pending', 0.00),
(598, 94, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(599, 94, 4, '2026-07-31', 2500.00, 2500.00, 'Pending', 0.00),
(600, 94, 4, '2026-08-31', 2500.00, 2500.00, 'Pending', 0.00),
(601, 94, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(602, 95, 4, '2025-12-31', 2500.00, 2500.00, 'Pending', 0.00),
(603, 95, 4, '2026-01-31', 2500.00, 2500.00, 'Pending', 0.00),
(604, 95, 4, '2026-03-03', 2500.00, 2500.00, 'Pending', 0.00),
(605, 95, 4, '2026-03-31', 2500.00, 2500.00, 'Pending', 0.00),
(606, 95, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(607, 95, 4, '2026-05-31', 2500.00, 2500.00, 'Pending', 0.00),
(608, 95, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(609, 95, 4, '2026-07-31', 2500.00, 2500.00, 'Pending', 0.00),
(610, 95, 4, '2026-08-31', 2500.00, 2500.00, 'Pending', 0.00),
(611, 95, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(612, 96, 4, '2025-12-31', 2500.00, 2500.00, 'Pending', 0.00),
(613, 96, 4, '2026-01-31', 2500.00, 2500.00, 'Pending', 0.00),
(614, 96, 4, '2026-03-03', 2500.00, 2500.00, 'Pending', 0.00),
(615, 96, 4, '2026-03-31', 2500.00, 2500.00, 'Pending', 0.00),
(616, 96, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(617, 96, 4, '2026-05-31', 2500.00, 2500.00, 'Pending', 0.00),
(618, 96, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(619, 96, 4, '2026-07-31', 2500.00, 2500.00, 'Pending', 0.00),
(620, 96, 4, '2026-08-31', 2500.00, 2500.00, 'Pending', 0.00),
(621, 96, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(622, 97, 4, '2025-12-31', 2500.00, 2500.00, 'Pending', 0.00),
(623, 97, 4, '2026-01-31', 2500.00, 2500.00, 'Pending', 0.00),
(624, 97, 4, '2026-03-03', 2500.00, 2500.00, 'Pending', 0.00),
(625, 97, 4, '2026-03-31', 2500.00, 2500.00, 'Pending', 0.00),
(626, 97, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(627, 97, 4, '2026-05-31', 2500.00, 2500.00, 'Pending', 0.00),
(628, 97, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(629, 97, 4, '2026-07-31', 2500.00, 2500.00, 'Pending', 0.00),
(630, 97, 4, '2026-08-31', 2500.00, 2500.00, 'Pending', 0.00),
(631, 97, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(632, 98, 4, '2025-12-31', 2500.00, 2500.00, 'Pending', 0.00),
(633, 98, 4, '2026-01-31', 2500.00, 2500.00, 'Pending', 0.00),
(634, 98, 4, '2026-03-03', 2500.00, 2500.00, 'Pending', 0.00),
(635, 98, 4, '2026-03-31', 2500.00, 2500.00, 'Pending', 0.00),
(636, 98, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(637, 98, 4, '2026-05-31', 2500.00, 2500.00, 'Pending', 0.00),
(638, 98, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(639, 98, 4, '2026-07-31', 2500.00, 2500.00, 'Pending', 0.00),
(640, 98, 4, '2026-08-31', 2500.00, 2500.00, 'Pending', 0.00),
(641, 98, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(642, 99, 4, '2025-12-31', 2500.00, 2500.00, 'Pending', 0.00),
(643, 99, 4, '2026-01-31', 2500.00, 2500.00, 'Pending', 0.00),
(644, 99, 4, '2026-03-03', 2500.00, 2500.00, 'Pending', 0.00),
(645, 99, 4, '2026-03-31', 2500.00, 2500.00, 'Pending', 0.00),
(646, 99, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(647, 99, 4, '2026-05-31', 2500.00, 2500.00, 'Pending', 0.00),
(648, 99, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(649, 99, 4, '2026-07-31', 2500.00, 2500.00, 'Pending', 0.00),
(650, 99, 4, '2026-08-31', 2500.00, 2500.00, 'Pending', 0.00),
(651, 99, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(652, 100, 4, '2025-12-31', 2500.00, 2500.00, 'Pending', 0.00),
(653, 100, 4, '2026-01-31', 2500.00, 2500.00, 'Pending', 0.00),
(654, 100, 4, '2026-03-03', 2500.00, 2500.00, 'Pending', 0.00),
(655, 100, 4, '2026-03-31', 2500.00, 2500.00, 'Pending', 0.00),
(656, 100, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(657, 100, 4, '2026-05-31', 2500.00, 2500.00, 'Pending', 0.00),
(658, 100, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(659, 100, 4, '2026-07-31', 2500.00, 2500.00, 'Pending', 0.00),
(660, 100, 4, '2026-08-31', 2500.00, 2500.00, 'Pending', 0.00),
(661, 100, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(662, 101, 4, '2025-12-31', 2500.00, 2500.00, 'Pending', 0.00),
(663, 101, 4, '2026-01-31', 2500.00, 2500.00, 'Pending', 0.00),
(664, 101, 4, '2026-03-03', 2500.00, 2500.00, 'Pending', 0.00),
(665, 101, 4, '2026-03-31', 2500.00, 2500.00, 'Pending', 0.00),
(666, 101, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(667, 101, 4, '2026-05-31', 2500.00, 2500.00, 'Pending', 0.00),
(668, 101, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(669, 101, 4, '2026-07-31', 2500.00, 2500.00, 'Pending', 0.00),
(670, 101, 4, '2026-08-31', 2500.00, 2500.00, 'Pending', 0.00),
(671, 101, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(672, 102, 4, '2026-01-01', 2500.00, 2500.00, 'Pending', 0.00),
(673, 102, 4, '2026-02-01', 2500.00, 2500.00, 'Pending', 0.00),
(674, 102, 4, '2026-03-01', 2500.00, 2500.00, 'Pending', 0.00),
(675, 102, 4, '2026-04-01', 2500.00, 2500.00, 'Pending', 0.00),
(676, 102, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(677, 102, 4, '2026-06-01', 2500.00, 2500.00, 'Pending', 0.00),
(678, 102, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(679, 102, 4, '2026-08-01', 2500.00, 2500.00, 'Pending', 0.00),
(680, 102, 4, '2026-09-01', 2500.00, 2500.00, 'Pending', 0.00),
(681, 102, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(682, 103, 4, '2026-01-01', 2500.00, 2500.00, 'Pending', 0.00),
(683, 103, 4, '2026-02-01', 2500.00, 2500.00, 'Pending', 0.00),
(684, 103, 4, '2026-03-01', 2500.00, 2500.00, 'Pending', 0.00),
(685, 103, 4, '2026-04-01', 2500.00, 2500.00, 'Pending', 0.00),
(686, 103, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(687, 103, 4, '2026-06-01', 2500.00, 2500.00, 'Pending', 0.00),
(688, 103, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(689, 103, 4, '2026-08-01', 2500.00, 2500.00, 'Pending', 0.00),
(690, 103, 4, '2026-09-01', 2500.00, 2500.00, 'Pending', 0.00),
(691, 103, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(692, 104, 4, '2026-01-01', 2500.00, 2500.00, 'Pending', 0.00),
(693, 104, 4, '2026-02-01', 2500.00, 2500.00, 'Pending', 0.00),
(694, 104, 4, '2026-03-01', 2500.00, 2500.00, 'Pending', 0.00),
(695, 104, 4, '2026-04-01', 2500.00, 2500.00, 'Pending', 0.00),
(696, 104, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(697, 104, 4, '2026-06-01', 2500.00, 2500.00, 'Pending', 0.00),
(698, 104, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(699, 104, 4, '2026-08-01', 2500.00, 2500.00, 'Pending', 0.00),
(700, 104, 4, '2026-09-01', 2500.00, 2500.00, 'Pending', 0.00),
(701, 104, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(702, 105, 4, '2026-01-01', 2500.00, 2500.00, 'Pending', 0.00),
(703, 105, 4, '2026-02-01', 2500.00, 2500.00, 'Pending', 0.00),
(704, 105, 4, '2026-03-01', 2500.00, 2500.00, 'Pending', 0.00),
(705, 105, 4, '2026-04-01', 2500.00, 2500.00, 'Pending', 0.00),
(706, 105, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(707, 105, 4, '2026-06-01', 2500.00, 2500.00, 'Pending', 0.00),
(708, 105, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(709, 105, 4, '2026-08-01', 2500.00, 2500.00, 'Pending', 0.00),
(710, 105, 4, '2026-09-01', 2500.00, 2500.00, 'Pending', 0.00),
(711, 105, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(712, 106, 4, '2026-01-01', 2500.00, 2500.00, 'Pending', 0.00),
(713, 106, 4, '2026-02-01', 2500.00, 2500.00, 'Pending', 0.00),
(714, 106, 4, '2026-03-01', 2500.00, 2500.00, 'Pending', 0.00),
(715, 106, 4, '2026-04-01', 2500.00, 2500.00, 'Pending', 0.00),
(716, 106, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(717, 106, 4, '2026-06-01', 2500.00, 2500.00, 'Pending', 0.00),
(718, 106, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(719, 106, 4, '2026-08-01', 2500.00, 2500.00, 'Pending', 0.00),
(720, 106, 4, '2026-09-01', 2500.00, 2500.00, 'Pending', 0.00),
(721, 106, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(722, 107, 4, '2026-01-01', 2500.00, 2500.00, 'Pending', 0.00),
(723, 107, 4, '2026-02-01', 2500.00, 2500.00, 'Pending', 0.00),
(724, 107, 4, '2026-03-01', 2500.00, 2500.00, 'Pending', 0.00),
(725, 107, 4, '2026-04-01', 2500.00, 2500.00, 'Pending', 0.00),
(726, 107, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(727, 107, 4, '2026-06-01', 2500.00, 2500.00, 'Pending', 0.00),
(728, 107, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(729, 107, 4, '2026-08-01', 2500.00, 2500.00, 'Pending', 0.00),
(730, 107, 4, '2026-09-01', 2500.00, 2500.00, 'Pending', 0.00),
(731, 107, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(732, 108, 4, '2026-01-01', 2500.00, 2500.00, 'Pending', 0.00),
(733, 108, 4, '2026-02-01', 2500.00, 2500.00, 'Pending', 0.00),
(734, 108, 4, '2026-03-01', 2500.00, 2500.00, 'Pending', 0.00),
(735, 108, 4, '2026-04-01', 2500.00, 2500.00, 'Pending', 0.00),
(736, 108, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(737, 108, 4, '2026-06-01', 2500.00, 2500.00, 'Pending', 0.00),
(738, 108, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(739, 108, 4, '2026-08-01', 2500.00, 2500.00, 'Pending', 0.00),
(740, 108, 4, '2026-09-01', 2500.00, 2500.00, 'Pending', 0.00),
(741, 108, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(742, 109, 4, '2026-01-01', 2000.00, 2000.00, 'Pending', 0.00),
(743, 109, 4, '2026-02-01', 2000.00, 2000.00, 'Pending', 0.00),
(744, 109, 4, '2026-03-01', 2000.00, 2000.00, 'Pending', 0.00),
(745, 109, 4, '2026-04-01', 2000.00, 2000.00, 'Pending', 0.00),
(746, 109, 4, '2026-05-01', 2000.00, 2000.00, 'Pending', 0.00),
(747, 109, 4, '2026-06-01', 2000.00, 2000.00, 'Pending', 0.00),
(748, 109, 4, '2026-07-01', 2000.00, 2000.00, 'Pending', 0.00),
(749, 109, 4, '2026-08-01', 2000.00, 2000.00, 'Pending', 0.00),
(750, 109, 4, '2026-09-01', 2000.00, 2000.00, 'Pending', 0.00),
(751, 109, 4, '2026-10-01', 2000.00, 2000.00, 'Pending', 0.00),
(752, 110, 4, '2026-01-01', 2500.00, 2500.00, 'Pending', 0.00),
(753, 110, 4, '2026-02-01', 2500.00, 2500.00, 'Pending', 0.00),
(754, 110, 4, '2026-03-01', 2500.00, 2500.00, 'Pending', 0.00),
(755, 110, 4, '2026-04-01', 2500.00, 2500.00, 'Pending', 0.00),
(756, 110, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(757, 110, 4, '2026-06-01', 2500.00, 2500.00, 'Pending', 0.00),
(758, 110, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(759, 110, 4, '2026-08-01', 2500.00, 2500.00, 'Pending', 0.00),
(760, 110, 4, '2026-09-01', 2500.00, 2500.00, 'Pending', 0.00),
(761, 110, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(762, 111, 4, '2026-01-01', 2500.00, 2500.00, 'Pending', 0.00),
(763, 111, 4, '2026-02-01', 2500.00, 2500.00, 'Pending', 0.00),
(764, 111, 4, '2026-03-01', 2500.00, 2500.00, 'Pending', 0.00),
(765, 111, 4, '2026-04-01', 2500.00, 2500.00, 'Pending', 0.00),
(766, 111, 4, '2026-05-01', 2500.00, 2500.00, 'Pending', 0.00),
(767, 111, 4, '2026-06-01', 2500.00, 2500.00, 'Pending', 0.00),
(768, 111, 4, '2026-07-01', 2500.00, 2500.00, 'Pending', 0.00),
(769, 111, 4, '2026-08-01', 2500.00, 2500.00, 'Pending', 0.00),
(770, 111, 4, '2026-09-01', 2500.00, 2500.00, 'Pending', 0.00),
(771, 111, 4, '2026-10-01', 2500.00, 2500.00, 'Pending', 0.00),
(772, 112, 4, '2026-01-01', 2000.00, 2000.00, 'Pending', 0.00),
(773, 112, 4, '2026-02-01', 2000.00, 2000.00, 'Pending', 0.00),
(774, 112, 4, '2026-03-01', 2000.00, 2000.00, 'Pending', 0.00),
(775, 112, 4, '2026-04-01', 2000.00, 2000.00, 'Pending', 0.00),
(776, 112, 4, '2026-05-01', 2000.00, 2000.00, 'Pending', 0.00),
(777, 112, 4, '2026-06-01', 2000.00, 2000.00, 'Pending', 0.00),
(778, 112, 4, '2026-07-01', 2000.00, 2000.00, 'Pending', 0.00),
(779, 112, 4, '2026-08-01', 2000.00, 2000.00, 'Pending', 0.00),
(780, 112, 4, '2026-09-01', 2000.00, 2000.00, 'Pending', 0.00),
(781, 112, 4, '2026-10-01', 2000.00, 2000.00, 'Pending', 0.00),
(782, 113, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(783, 113, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(784, 113, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(785, 113, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(786, 113, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(787, 113, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(788, 113, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(789, 113, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(790, 113, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(791, 113, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(792, 114, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(793, 114, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(794, 114, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(795, 114, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(796, 114, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(797, 114, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(798, 114, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(799, 114, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(800, 114, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(801, 114, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(802, 115, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(803, 115, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(804, 115, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(805, 115, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(806, 115, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(807, 115, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(808, 115, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(809, 115, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(810, 115, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(811, 115, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(812, 116, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(813, 116, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(814, 116, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(815, 116, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(816, 116, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(817, 116, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(818, 116, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(819, 116, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(820, 116, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(821, 116, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(822, 117, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(823, 117, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(824, 117, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(825, 117, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(826, 117, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(827, 117, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(828, 117, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(829, 117, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(830, 117, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(831, 117, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(832, 118, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(833, 118, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(834, 118, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(835, 118, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(836, 118, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(837, 118, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(838, 118, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(839, 118, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(840, 118, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(841, 118, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(842, 119, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(843, 119, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(844, 119, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(845, 119, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(846, 119, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(847, 119, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(848, 119, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(849, 119, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(850, 119, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(851, 119, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(852, 120, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(853, 120, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(854, 120, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(855, 120, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(856, 120, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(857, 120, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(858, 120, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(859, 120, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(860, 120, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(861, 120, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(862, 121, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(863, 121, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(864, 121, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(865, 121, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(866, 121, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(867, 121, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(868, 121, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(869, 121, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(870, 121, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(871, 121, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(872, 122, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(873, 122, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(874, 122, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(875, 122, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(876, 122, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(877, 122, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(878, 122, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(879, 122, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(880, 122, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(881, 122, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(882, 123, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(883, 123, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(884, 123, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(885, 123, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(886, 123, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(887, 123, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(888, 123, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(889, 123, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(890, 123, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(891, 123, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(892, 124, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(893, 124, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(894, 124, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(895, 124, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(896, 124, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(897, 124, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(898, 124, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(899, 124, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(900, 124, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(901, 124, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(902, 125, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(903, 125, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(904, 125, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(905, 125, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(906, 125, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(907, 125, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(908, 125, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(909, 125, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(910, 125, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(911, 125, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(912, 126, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(913, 126, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(914, 126, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(915, 126, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(916, 126, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(917, 126, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(918, 126, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(919, 126, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(920, 126, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(921, 126, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(922, 127, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(923, 127, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(924, 127, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(925, 127, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(926, 127, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(927, 127, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(928, 127, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(929, 127, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(930, 127, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(931, 127, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(932, 128, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(933, 128, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(934, 128, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(935, 128, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(936, 128, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(937, 128, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(938, 128, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(939, 128, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(940, 128, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(941, 128, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(942, 129, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(943, 129, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(944, 129, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(945, 129, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(946, 129, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(947, 129, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(948, 129, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(949, 129, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(950, 129, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(951, 129, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(952, 130, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(953, 130, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(954, 130, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(955, 130, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(956, 130, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(957, 130, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(958, 130, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(959, 130, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(960, 130, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(961, 130, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(962, 131, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(963, 131, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(964, 131, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(965, 131, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(966, 131, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(967, 131, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(968, 131, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(969, 131, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(970, 131, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(971, 131, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(972, 132, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(973, 132, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(974, 132, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(975, 132, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(976, 132, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(977, 132, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(978, 132, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(979, 132, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(980, 132, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(981, 132, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(982, 133, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(983, 133, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(984, 133, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(985, 133, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(986, 133, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(987, 133, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(988, 133, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(989, 133, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(990, 133, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(991, 133, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(992, 134, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(993, 134, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(994, 134, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(995, 134, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(996, 134, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(997, 134, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(998, 134, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(999, 134, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(1000, 134, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(1001, 134, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(1002, 135, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(1003, 135, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(1004, 135, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(1005, 135, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(1006, 135, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(1007, 135, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(1008, 135, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(1009, 135, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(1010, 135, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(1011, 135, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(1012, 136, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(1013, 136, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(1014, 136, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(1015, 136, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(1016, 136, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(1017, 136, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(1018, 136, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(1019, 136, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(1020, 136, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(1021, 136, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(1022, 137, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(1023, 137, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(1024, 137, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(1025, 137, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(1026, 137, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(1027, 137, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(1028, 137, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(1029, 137, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(1030, 137, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(1031, 137, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(1032, 138, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(1033, 138, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(1034, 138, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(1035, 138, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(1036, 138, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(1037, 138, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(1038, 138, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(1039, 138, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(1040, 138, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(1041, 138, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(1042, 139, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(1043, 139, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(1044, 139, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(1045, 139, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(1046, 139, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(1047, 139, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(1048, 139, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(1049, 139, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(1050, 139, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(1051, 139, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(1052, 140, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(1053, 140, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(1054, 140, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(1055, 140, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(1056, 140, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(1057, 140, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(1058, 140, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(1059, 140, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(1060, 140, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(1061, 140, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(1062, 141, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(1063, 141, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(1064, 141, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(1065, 141, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(1066, 141, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(1067, 141, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(1068, 141, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(1069, 141, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(1070, 141, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(1071, 141, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(1072, 145, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(1073, 145, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(1074, 145, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(1075, 145, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(1076, 145, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(1077, 145, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(1078, 145, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(1079, 145, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(1080, 145, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(1081, 145, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(1082, 142, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(1083, 142, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(1084, 142, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(1085, 142, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(1086, 142, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(1087, 142, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(1088, 142, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(1089, 142, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(1090, 142, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(1091, 142, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(1092, 143, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(1093, 143, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(1094, 143, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(1095, 143, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(1096, 143, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(1097, 143, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(1098, 143, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(1099, 143, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(1100, 143, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(1101, 143, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(1102, 144, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(1103, 144, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(1104, 144, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(1105, 144, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(1106, 144, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(1107, 144, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(1108, 144, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(1109, 144, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(1110, 144, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(1111, 144, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(1112, 146, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(1113, 146, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(1114, 146, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(1115, 146, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(1116, 146, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(1117, 146, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(1118, 146, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(1119, 146, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(1120, 146, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(1121, 146, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(1122, 147, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(1123, 147, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(1124, 147, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(1125, 147, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(1126, 147, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(1127, 147, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(1128, 147, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(1129, 147, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(1130, 147, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(1131, 147, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00),
(1132, 148, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(1133, 148, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(1134, 148, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(1135, 148, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(1136, 148, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(1137, 148, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(1138, 148, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(1139, 148, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(1140, 148, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(1141, 148, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(1142, 149, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(1143, 149, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(1144, 149, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(1145, 149, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(1146, 149, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(1147, 149, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(1148, 149, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(1149, 149, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(1150, 149, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(1151, 149, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(1152, 150, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(1153, 150, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(1154, 150, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(1155, 150, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(1156, 150, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(1157, 150, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(1158, 150, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(1159, 150, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(1160, 150, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(1161, 150, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(1162, 151, 4, '2026-01-02', 2500.00, 2500.00, 'Pending', 0.00),
(1163, 151, 4, '2026-02-02', 2500.00, 2500.00, 'Pending', 0.00),
(1164, 151, 4, '2026-03-02', 2500.00, 2500.00, 'Pending', 0.00),
(1165, 151, 4, '2026-04-02', 2500.00, 2500.00, 'Pending', 0.00),
(1166, 151, 4, '2026-05-02', 2500.00, 2500.00, 'Pending', 0.00),
(1167, 151, 4, '2026-06-02', 2500.00, 2500.00, 'Pending', 0.00),
(1168, 151, 4, '2026-07-02', 2500.00, 2500.00, 'Pending', 0.00),
(1169, 151, 4, '2026-08-02', 2500.00, 2500.00, 'Pending', 0.00),
(1170, 151, 4, '2026-09-02', 2500.00, 2500.00, 'Pending', 0.00),
(1171, 151, 4, '2026-10-02', 2500.00, 2500.00, 'Pending', 0.00),
(1172, 152, 4, '2026-01-02', 2000.00, 2000.00, 'Pending', 0.00),
(1173, 152, 4, '2026-02-02', 2000.00, 2000.00, 'Pending', 0.00),
(1174, 152, 4, '2026-03-02', 2000.00, 2000.00, 'Pending', 0.00),
(1175, 152, 4, '2026-04-02', 2000.00, 2000.00, 'Pending', 0.00),
(1176, 152, 4, '2026-05-02', 2000.00, 2000.00, 'Pending', 0.00),
(1177, 152, 4, '2026-06-02', 2000.00, 2000.00, 'Pending', 0.00),
(1178, 152, 4, '2026-07-02', 2000.00, 2000.00, 'Pending', 0.00),
(1179, 152, 4, '2026-08-02', 2000.00, 2000.00, 'Pending', 0.00),
(1180, 152, 4, '2026-09-02', 2000.00, 2000.00, 'Pending', 0.00),
(1181, 152, 4, '2026-10-02', 2000.00, 2000.00, 'Pending', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `progress_assessments`
--

CREATE TABLE `progress_assessments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `criteria_id` int(11) NOT NULL,
  `quarter` tinyint(4) NOT NULL,
  `school_year` varchar(20) NOT NULL,
  `assessment` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progress_categories`
--

CREATE TABLE `progress_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress_categories`
--

INSERT INTO `progress_categories` (`id`, `name`) VALUES
(1, 'Social - Emotional'),
(2, 'Practice Life (Ground Rules)'),
(3, 'Fine Motor Skills (Eye-Hand Coordination)'),
(4, 'Gross Motor Skills'),
(5, 'Sensory Skills'),
(6, 'Language Development');

-- --------------------------------------------------------

--
-- Table structure for table `progress_criteria`
--

CREATE TABLE `progress_criteria` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `criteria` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress_criteria`
--

INSERT INTO `progress_criteria` (`id`, `category_id`, `criteria`) VALUES
(1, 1, 'Getting along with others'),
(2, 1, 'Gets use of school daily routines'),
(3, 1, 'Builds Self-Confidence'),
(4, 1, 'Plays Cooperative'),
(5, 1, 'Practice patience in doing the activity'),
(6, 1, 'Builds good behavior with others'),
(7, 1, 'Express feelings with simple words'),
(8, 1, 'Smiles socially'),
(9, 1, 'Develops attachment and trust to others'),
(10, 2, 'Cross legs during circle time'),
(11, 2, 'Sits on the chair with care'),
(12, 2, 'Walks on the line'),
(13, 2, 'Lines up with patience'),
(14, 2, 'Recognizes own bag and belongings'),
(15, 2, 'Carry things with independence'),
(16, 3, 'Squeezing toys with firmness'),
(17, 3, 'Presses and rolls playdough with firmness'),
(18, 3, 'Stacking sticks in the designated holes'),
(19, 3, 'String large beads'),
(20, 3, 'Place shapes in the right slots'),
(21, 3, 'Bangs two toys together to create sounds'),
(22, 3, 'Bangs hands on the table with coordination'),
(23, 3, 'Assembles/Builds pink tower (sand, water)'),
(24, 3, 'Performs pouring exercises'),
(25, 3, 'Display grip in tongs exercise'),
(26, 3, 'Grasps pencil, crayon with interest'),
(27, 3, 'Performs pasting with eye-hand coordination'),
(28, 4, 'Walks with firm legs'),
(29, 4, 'Perform stepping exercise on steppers'),
(30, 4, 'Bend Body with balance'),
(31, 4, 'Sits and stands up with balance'),
(32, 4, 'Stands on foot at 2-3 counts'),
(33, 4, 'Bounce and rolls the ball'),
(34, 4, 'Kicking the ball with legs coordination'),
(35, 4, 'Sticking pictures on designated area'),
(36, 4, 'Catches, throws and kicks the ball with direction'),
(37, 4, 'Dances with sense of rhythm'),
(38, 5, 'Listen attentively'),
(39, 5, 'Develops sensory skills to identify hard and soft objects'),
(40, 5, 'Recognize light and heavy objects'),
(41, 5, 'Matches object to similar colors'),
(42, 5, 'Develops hearing response on loud and soft sounds'),
(43, 5, 'Responds to smelling exercises'),
(44, 6, 'Greets with simple words'),
(45, 6, 'Head turns or nods when name is called'),
(46, 6, 'Says own name'),
(47, 6, 'Names people around'),
(48, 6, 'Recognize family members'),
(49, 6, 'Points parts of the body'),
(50, 6, 'Recognize common fruits'),
(51, 6, 'Names some common animals'),
(52, 6, 'Names objects around'),
(53, 6, 'Follows simple directions such as sit, down, jump, clap hands'),
(54, 6, 'Recites finger plays and rhymes'),
(55, 6, 'Listen during story time'),
(56, 6, 'Shows interest in opening books');

-- --------------------------------------------------------

--
-- Table structure for table `progress_remarks`
--

CREATE TABLE `progress_remarks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quarter` tinyint(4) NOT NULL,
  `school_year` varchar(20) NOT NULL,
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `user_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `admission_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `class_level` varchar(250) NOT NULL,
  `profile_pic` varchar(250) NOT NULL DEFAULT '1752420767_9459efda9027940a87c4.webp',
  `qr_code` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`user_id`, `student_id`, `admission_id`, `first_name`, `middle_name`, `last_name`, `birthday`, `class_level`, `profile_pic`, `qr_code`) VALUES
(91, 91, 91, 'Kalisha Blaire', 'Si', 'Parilla', '2020-09-02', 'Senior Kindergarten (K2)', '1767169273_dc0e39e9c199439af704.jpg', '6954ee81b9861.png'),
(92, 92, 92, 'Hanniel', '', 'Tagunicar', '2020-10-17', 'Senior Kindergarten (K2)', '1767174776_d78683166265901b39c7.jpg', '6954f2994ea2e.png'),
(93, 93, 93, 'Eloise Margrethe', '', 'Kamatoy', '2020-08-11', 'Senior Kindergarten (K2)', '1767179798_6168deca1a7ef00e593f.jpg', '6955064603ee2.png'),
(94, 94, 94, 'Gabriel Lorenz', 'Navarro', 'Litan', '2020-11-25', 'Junior Kindergarten (K1)', '1767180395_e1d0989f71cefac5da1e.jpg', '69550884d1361.png'),
(95, 95, 95, 'Sia Cassandra', 'Lopez', 'Untivero', '2020-06-16', 'Senior Kindergarten (K2)', '1767181046_440c2dc482c78741cbaf.jpg', '69550b34ca954.png'),
(96, 96, 96, 'Alonzo Isaac', '', 'Ledesma', '2021-05-23', 'Junior Kindergarten (K1)', '1767182125_e0c1d4f113abb13051ce.jpg', '69550f450c561.png'),
(97, 97, 97, 'Josethen Kenamarie', '', 'Villanueva', '2021-09-08', 'Junior Kindergarten (K1)', '1767182617_dc67162bec7cefc23598.jpg', '69551138e7881.png'),
(98, 98, 98, 'Amiyah Emerithz', 'Shi', 'Lim', '2020-10-08', 'Senior Kindergarten (K2)', '1767185619_8e187498565e049c7396.jpg', '69551d2cf15a8.png'),
(99, 99, 99, 'Eonna Zerrilmarasigan', '', 'Bartolome', '2020-11-30', 'Junior Kindergarten (K1)', '1767186687_3ac2e06481119341b47b.jpg', '69552119370fa.png'),
(100, 100, 100, 'Troy', '', 'Perez', '2020-07-04', 'Senior Kindergarten (K2)', '1767195091_06566f913f7f8d6735cc.jpg', '69554267b51eb.png'),
(101, 101, 101, 'Seth Levin', '', 'Perante', '2020-11-28', 'Junior Kindergarten (K1)', '1767195699_9783a797bc6c328cecee.jpg', '6955444cee35f.png'),
(102, 102, 102, 'Dwyane Marcio', '', 'Villanueva', '2020-10-17', 'Senior Kindergarten (K2)', '1767198129_af6adb3b6fc507ebc6fd.jpg', '69554dc991387.png'),
(103, 103, 103, 'Zachary Damian', '', 'Suena', '2020-03-21', 'Senior Kindergarten (K2)', '1767198663_8dcf0e16a850bdd55a42.jpg', '695550422b12f.png'),
(104, 104, 104, 'Athalia Mae Veridiano', '', 'De Guzman', '2022-09-01', 'Nursery', '1767202957_d59a9776071adbc59e10.jpg', '695560bc5bae6.png'),
(105, 105, 105, 'Heather Halley', '', 'Martinez', '2020-09-01', 'Junior Kindergarten (K1)', '1767203458_e0b6b20e393304253d4f.jpg', '6955629b73052.png'),
(106, 106, 106, 'Skyler', '', 'Mercurio', '2021-05-21', 'Junior Kindergarten (K1)', '1767204967_6534112d4a052bbe4920.jpg', '6955687ea13a5.png'),
(107, 107, 107, 'Marcus Freire', '', 'Balijon', '2021-07-23', 'Junior Kindergarten (K1)', '1767274420_76732e6429381c30fd06.jpg', '695678178b1f8.png'),
(108, 108, 108, 'Eusha Agape', 'Pambuan', 'Mantes', '0001-06-14', 'Junior Kindergarten (K1)', '1767274923_cad72bceb130c0f79563.jpg', '695679e000d99.png'),
(109, 109, 109, 'Ethaniel Drake', 'Limpengco', 'Zapanta', '2022-08-29', 'Pre-Kindergarten', '1767275967_33cf249f48ac4932ce5b.jpg', '69567dd4c6716.png'),
(110, 110, 110, 'Allynx', '', 'Riguer', '2021-07-17', 'Junior Kindergarten (K1)', '1767277148_27da5b2160b5c125dc25.jpg', '69568288d79b5.png'),
(111, 111, 111, 'Rebecca Helaina', 'Miranda', 'Reyes', '2021-10-11', 'Junior Kindergarten (K1)', '1767277971_d98af27e286c0febcfe5.jpg', '695685afbc984.png'),
(112, 112, 112, 'Arkisha Alliezenth', 'Bornales', 'Escuadro', '2022-03-21', 'Toddler/Baby', '1767283110_f5d582ce833fe6f873c6.jpg', '695699be9d09b.png'),
(113, 113, 113, 'Koleen Natalie', '', 'Angeles', '2022-03-16', 'Pre-Kindergarten', '1767283658_309310725da41c22fdb2.jpg', '69569be0e44a3.png'),
(114, 114, 114, 'Zarina Cassidy', '', 'Tan', '2021-09-06', 'Pre-Kindergarten', '1767285110_2563fe32d5920df16ccf.jpg', '6956a191cfb5c.png'),
(115, 115, 115, 'Dean Castiel', 'Diaz', 'Panganiban', '2021-07-13', 'Junior Kindergarten (K1)', '1767285810_c4bc518a0cc048ab5bb5.jpg', '6956a44d77f04.png'),
(116, 116, 116, 'Antoni Kalen', 'Malolos', 'Guzman', '2019-09-21', 'Senior Kindergarten (K2)', '1767286394_b71f3d5c5fc1f0fa15c2.jpg', '6956a6a919e5b.png'),
(117, 117, 117, 'Evee Antonelle', '', 'Llamoso', '2022-02-20', 'Pre-Kindergarten', '1767287271_ca3c038f7bfeac03d34b.jpg', '6956aa3c38c0c.png'),
(118, 118, 118, 'Julio Anton', 'Sumaya', 'Choa', '2021-07-12', 'Junior Kindergarten (K1)', '1767290919_efd1b9227d9cd4bfad45.jpg', '6956b8420321a.png'),
(119, 119, 119, 'Avrilla Rain', '', 'Gagalac', '2021-04-15', 'Junior Kindergarten (K1)', '1767291535_8248dd21f2bbf0ff1a56.jpg', '6956baabdfa17.png'),
(120, 120, 120, 'Sevan Sky Brandt', 'Del Mundo', 'Bernardino', '2019-11-30', 'Senior Kindergarten (K2)', '1767292033_ae67c5eb1380602d9005.jpg', '6956c989689ae.png'),
(121, 121, 121, 'Hezekiah Jayce', '', 'Ramiro', '2021-10-08', 'Nursery', '1767330935_ee8905c56add6c85e49b.jpg', '69575516cf24a.png'),
(122, 122, 122, 'Christen Brielle', '', 'Sison', '2021-02-01', 'Pre-Kindergarten', '1767331485_7a3c2e509ef16f731d4c.jpg', '695756b8408d3.png'),
(123, 123, 123, 'Miquella', 'Alfonso', 'Villanueva', '2019-11-08', 'Junior Kindergarten (K1)', '1767331921_6190237930894124ea59.jpg', '695758671f7ff.png'),
(124, 124, 124, 'Azaela', '', 'Belen', '2020-02-12', 'Pre-Kindergarten', '1767332302_f06e613ac67d3f7b21e9.jpg', '695759ed983a9.png'),
(125, 125, 125, 'Airrah Gabrielle', 'Ananayo', 'Legaspi', '2019-12-19', 'Pre-Kindergarten', '1767332694_501f36af4971008b61c2.jpg', '69575b6ece37e.png'),
(126, 126, 126, 'Stephen Caden', '', 'Caro', '2020-03-10', 'Pre-Kindergarten', '1767333083_6851008375e7d2771a77.jpg', '69575d5f6884f.png'),
(127, 127, 127, 'Zhaym Andrew', '', 'Tablate', '2019-03-18', 'Senior Kindergarten (K2)', '1767333535_0a9e7dcaf333fe06ebc9.jpg', '69575ebcac6ec.png'),
(128, 128, 128, 'Skye Tristan', '', 'Galit', '2020-05-29', 'Pre-Kindergarten', '1767334248_0312d5f71622efa1079a.jpg', '6957617d907f1.png'),
(129, 129, 129, 'Joseth Kedvin', '', 'Villanueva', '2020-03-08', 'Pre-Kindergarten', '1767334849_700a8a4756e7e7ee5240.jpg', '695763d9a6ae4.png'),
(130, 130, 130, 'Jace Primo', 'Cotez', 'Alagon', '2019-09-26', 'Senior Kindergarten (K2)', '1767336207_288c82e47388aba2e8e1.jpg', '6957692b8c390.png'),
(131, 131, 131, 'Calix Winter Jace', '', 'Javier', '2019-12-27', 'Senior Kindergarten (K2)', '1767339590_618567cb13372fd629f9.jpg', '6957765c90666.png'),
(132, 132, 132, 'Jazzy Nestar', 'Orfano', 'Barroga', '2019-10-17', 'Senior Kindergarten (K2)', '1767339987_cf4471d25ae4d8d93987.jpg', '695777e7bbfd7.png'),
(133, 133, 133, 'Khael Mattias', '', 'Basa', '2020-10-19', 'Pre-Kindergarten', '1752420767_9459efda9027940a87c4.webp', '69578e90144c9.png'),
(134, 134, 134, 'Jadd Deon', '', 'Castillo', '2020-01-19', 'Pre-Kindergarten', '1752420767_9459efda9027940a87c4.webp', '6957905f6e2e3.png'),
(135, 135, 135, 'Philip Xavier', '', 'Dorado', '2020-05-13', 'Pre-Kindergarten', '1752420767_9459efda9027940a87c4.webp', '695791a0520fd.png'),
(136, 136, 136, 'Lucas Gabriel', 'Bolagao', 'Mallanao', '2020-09-15', 'Nursery', '1752420767_9459efda9027940a87c4.webp', '69579ec159d4e.png'),
(137, 137, 137, 'Samantha Ysabelle', '', 'Ramos', '2020-10-01', 'Pre-Kindergarten', '1752420767_9459efda9027940a87c4.webp', '6957a00be7352.png'),
(138, 138, 138, 'Johana Haniah', 'Punongbayan', 'Calma', '2020-09-27', 'Pre-Kindergarten', '1752420767_9459efda9027940a87c4.webp', '6957a13c03a98.png'),
(139, 139, 139, 'Yvanne Noah', '', 'Lim', '2021-10-08', 'Nursery', '1752420767_9459efda9027940a87c4.webp', '6957a21400443.png'),
(140, 140, 140, 'Naomi', 'De Lima', 'Soriano', '2021-04-16', 'Toddler/Baby', '1752420767_9459efda9027940a87c4.webp', '6957a34480c4e.png'),
(141, 141, 141, 'Tomas Primo', '', 'Muli', '2020-10-26', 'Nursery', '1752420767_9459efda9027940a87c4.webp', '6957a43903f39.png'),
(142, 142, 142, 'Khloe Ann', '', 'Liwag', '2020-10-02', 'Toddler/Baby', '1752420767_9459efda9027940a87c4.webp', '6957c1117cc89.png'),
(143, 143, 143, 'Arya Eledelia', '', 'Tabuzo', '2021-03-06', 'Toddler/Baby', '1752420767_9459efda9027940a87c4.webp', '6957c11a6de88.png'),
(144, 144, 144, 'Jeremiah Rolcy', 'Ocampo', 'Alarva', '2022-05-28', 'Toddler/Baby', '1752420767_9459efda9027940a87c4.webp', '6957c1234fb67.png'),
(145, 145, 145, 'Maxene', '', 'OrdoñEz', '2021-11-06', 'Nursery', '1752420767_9459efda9027940a87c4.webp', '6957c10796e0f.png'),
(146, 146, 146, 'Aziel Luke', '', 'Gonzales', '2021-10-18', 'Nursery', '1752420767_9459efda9027940a87c4.webp', '6957c13c924f0.png'),
(147, 147, 147, 'Cassandra Christelle', 'Devera', 'Calcetas', '2021-11-12', 'Toddler/Baby', '1752420767_9459efda9027940a87c4.webp', '6957c14d46b4b.png'),
(148, 148, 148, 'Ruth Anne', '', 'Pamatmat', '2021-11-02', 'Nursery', '1752420767_9459efda9027940a87c4.webp', '6957c1662201d.png'),
(149, 149, 149, 'Atasha Zion Primo Matthaeus', '', 'Macalinao', '2021-05-30', 'Nursery', '1752420767_9459efda9027940a87c4.webp', '6957c16f292ce.png'),
(150, 150, 150, 'Atasha Brielle', '', 'Beguico', '2021-02-11', 'Nursery', '1752420767_9459efda9027940a87c4.webp', '6957c17b55048.png'),
(151, 151, 151, 'Chase Ephraim Eduria', '', 'Alagon', '2021-07-08', 'Nursery', '1752420767_9459efda9027940a87c4.webp', '6957c1a3500a4.png'),
(152, 152, 152, 'Avianna Shea', '', 'Villanueva', '2022-12-15', 'Toddler/Baby', '1752420767_9459efda9027940a87c4.webp', '6957c1b23696b.png');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(250) NOT NULL,
  `middle_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  `birthday` date DEFAULT NULL,
  `gender` varchar(100) NOT NULL,
  `civil_status` varchar(100) NOT NULL,
  `municipality` varchar(100) NOT NULL,
  `barangay` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(250) NOT NULL,
  `specialization` varchar(250) NOT NULL,
  `teacher_department` varchar(250) NOT NULL,
  `profile_pic` varchar(250) NOT NULL DEFAULT '1752420767_9459efda9027940a87c4.webp',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `first_name`, `middle_name`, `last_name`, `birthday`, `gender`, `civil_status`, `municipality`, `barangay`, `street`, `contact_number`, `email`, `specialization`, `teacher_department`, `profile_pic`, `created_at`, `updated_at`) VALUES
(42, 117, 'Arla', '', 'Garcia', NULL, '', '', '', '', '', '09205804090', 'roldanoliveros1@Gmail.com', 'Math', 'Toddler/Baby', '1752420767_9459efda9027940a87c4.webp', '2025-12-31 08:00:33', '2025-12-31 08:01:53'),
(43, 118, 'Jesimiel', '', 'Bilgera', NULL, '', '', '', '', '', '09205804090', 'Roldanoliveros2@Gmail.com', 'math', 'Nursery', '1752420767_9459efda9027940a87c4.webp', '2025-12-31 08:03:37', '2025-12-31 08:04:16'),
(44, 119, 'Maria Thalia Andrea', '', 'Romeo', '0000-00-00', '', '', '', '', '', '09205804090', 'roldanoliveros3@gmail.com', 'English', 'Pre-Kindergarten', '1752420767_9459efda9027940a87c4.webp', '2025-12-31 08:06:08', '2025-12-31 08:06:46'),
(45, 120, 'Elaine', '', 'Manaman', '0000-00-00', '', '', '', '', '', '09205804090', 'Roldanoliveros4@gmail.com', 'Physical education', 'Senior Kindergarten (K2)', '1752420767_9459efda9027940a87c4.webp', '2025-12-31 08:08:27', '2025-12-31 08:08:48'),
(46, 121, 'Ea Mae', '', 'Callado', '0000-00-00', '', '', '', '', '', '09205804090', 'roldanoliveros5@gmail.com', 'Tagalog', 'Junior Kindergarten (K1)', '1752420767_9459efda9027940a87c4.webp', '2025-12-31 08:10:24', '2025-12-31 08:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_photos_upload`
--

CREATE TABLE `teacher_photos_upload` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `photo` varchar(255) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tuitionplans`
--

CREATE TABLE `tuitionplans` (
  `plan_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `plan_name` varchar(50) NOT NULL,
  `payment_type` enum('Full','Monthly','Miscellaneous','Enrollment') DEFAULT 'Full',
  `total_amount` decimal(10,2) NOT NULL,
  `discount` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tuitionplans`
--

INSERT INTO `tuitionplans` (`plan_id`, `class_id`, `plan_name`, `payment_type`, `total_amount`, `discount`) VALUES
(2, 0, 'Enrollment Fee', 'Enrollment', 2000.00, 0.00),
(3, 0, 'Miscellaneous Fee', 'Miscellaneous', 0.00, 0.00),
(4, 0, 'Full Payment', 'Full', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('student','teacher','admin','attendance_monitor','parent') NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` date NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(250) NOT NULL,
  `token_expiry` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `email`, `role`, `created_at`, `updated_at`, `reset_token`, `token_expiry`, `status`) VALUES
(1, 'admin', '123', 'ecohaven28@gmail.com', 'admin', '2025-05-24 00:05:01', '2025-10-08', '', '2025-10-10 18:40:08', 'active'),
(2, 'attendance', '123', 'roldanoliveros0921@gmail.com', 'attendance_monitor', '2025-05-15 01:17:19', '2025-12-03', '8e3f372e7929d73d1c5dc1b55f3b6a558b3e01f84a3b34f619b0b1bbcb8bdd0990ce683b71c62f29d5f41aa49f8c3f393b7b', '2025-12-03 04:27:54', 'active'),
(117, 'arla', '123456', 'roldanoliveros1@Gmail.com', 'teacher', '2025-12-31 16:00:33', '2025-12-31', '', '2025-12-31 08:01:43', 'active'),
(118, 'jesimiel', '123456', 'Roldanoliveros2@Gmail.com', 'teacher', '2025-12-31 16:03:37', '2025-12-31', '', '2025-12-31 08:04:01', 'active'),
(119, 'mariathaliaandrea', '123456', 'roldanoliveros3@gmail.com', 'teacher', '2025-12-31 16:06:08', '2025-12-31', '', '2025-12-31 08:06:46', 'active'),
(120, 'elaine', '123456', 'Roldanoliveros4@gmail.com', 'teacher', '2025-12-31 16:08:27', '2025-12-31', '', '2025-12-31 08:08:48', 'active'),
(121, 'eamae', '123456', 'roldanoliveros5@gmail.com', 'teacher', '2025-12-31 16:10:24', '2025-12-31', '', '2025-12-31 08:10:59', 'active'),
(122, 'clair', '123456', 'karencagayat@gmail.com', 'parent', '2025-12-31 16:16:06', '2025-12-31', '', '2025-12-31 09:47:04', 'pending'),
(123, 'lilianne', '123123', 'roldanoliveros1001@gmail.com', 'parent', '2025-12-31 17:48:02', '2025-12-31', '', '2025-12-31 10:00:04', 'pending'),
(124, 'marilou', '123123', 'loukamatoy@gmail.com', 'parent', '2025-12-31 18:01:18', '2025-12-31', '', '2025-12-31 11:18:09', 'pending'),
(125, 'marielle', '123456', 'litanmayeh@gmail.com', 'parent', '2025-12-31 19:22:36', '2025-12-31', '', '2025-12-31 11:31:32', 'pending'),
(126, 'francesca', '123456', 'francescauntivero@deped.gov.ph', 'parent', '2025-12-31 19:33:45', '2025-12-31', '', '2025-12-31 11:39:05', 'pending'),
(127, 'cristine', '123456', 'cristine_leonardo@yahoo.com', 'parent', '2025-12-31 19:42:24', '2025-12-31', '', '2025-12-31 11:56:27', 'pending'),
(128, 'kristel', '123123', 'jenniferkristelcayetano@gmail.com', 'parent', '2025-12-31 20:00:08', '2025-12-31', '', '2025-12-31 12:47:30', 'pending'),
(129, 'analyn', '123456', 'roldanoliveros1002@gmail.com', 'parent', '2025-12-31 20:48:57', '2025-12-31', '', '2025-12-31 12:57:47', 'pending'),
(130, 'zerrina', '123456', 'zemarasigan@gmail.com', 'parent', '2025-12-31 20:59:32', '2025-12-31', '', '2025-12-31 13:15:44', 'pending'),
(131, 'joshuan', '123456', 'defiestaveronica4@gmail.com', 'parent', '2025-12-31 23:28:26', '2025-12-31', '', '2025-12-31 15:34:48', 'pending'),
(132, 'liza', '123456', 'liza.perante@deped.gov.ph', 'parent', '2025-12-31 23:38:33', '2025-12-31', '', '2025-12-31 15:42:56', 'pending'),
(133, '09173160908', '123456', 'eferorendain@gmail.com', 'parent', '2025-12-31 23:57:36', '2025-12-31', '', '2025-12-31 16:23:27', 'pending'),
(134, 'zyra', '123456', 'suezyramae@gmail.com', 'parent', '2026-01-01 00:27:38', '2026-01-01', '', '2025-12-31 16:39:05', 'pending'),
(135, 'alyza', '123456', 'roldanoliveros1003@gmail.com', 'parent', '2026-01-01 00:42:00', '2026-01-01', '', '2025-12-31 17:44:18', 'pending'),
(136, 'eyerica', '123456', 'eyericayoshida@yahoo.com', 'parent', '2026-01-01 01:47:20', '2026-01-01', '', '2025-12-31 18:11:01', 'pending'),
(137, 'melanie', '123456', 'parganibanmelanie@gmail.com', 'parent', '2026-01-01 02:12:36', '2026-01-01', '', '2025-12-31 18:18:00', 'pending'),
(138, 'sheryll', '123456', 'roldanoliveros1004@gmail.com', 'parent', '2026-01-01 21:30:36', '2026-01-01', '', '2026-01-01 13:35:49', 'pending'),
(139, 'shamaein', '123456', 'maeinpambuan@gmail.com', 'parent', '2026-01-01 21:39:15', '2026-01-01', '', '2026-01-01 13:44:00', 'pending'),
(140, 'joyce', '123456', 'joycelimpengco@gmail.com', 'parent', '2026-01-01 21:52:17', '2026-01-01', '', '2026-01-01 14:00:43', 'pending'),
(141, 'joan', '123123', 'joanriguer19@gmail.com', 'parent', '2026-01-01 22:14:57', '2026-01-01', '', '2026-01-01 14:24:31', 'pending'),
(142, 'nerica', '123456', 'daunnericamiranda@gmail.com', 'parent', '2026-01-01 22:29:12', '2026-01-01', '', '2026-01-01 14:34:25', 'pending'),
(143, 'eunice', '123456', 'roldanoliveros1005@gmail.com', 'parent', '2026-01-01 23:26:51', '2026-01-01', '', '2026-01-01 15:59:21', 'pending'),
(144, 'rose', '123456', 'catalynrose@gmail.com', 'parent', '2026-01-02 00:04:07', '2026-01-02', '', '2026-01-01 16:08:52', 'pending'),
(145, 'sherin', '123456', 'karl07tan@yahoo.com', 'parent', '2026-01-02 00:28:49', '2026-01-02', '', '2026-01-01 16:36:36', 'pending'),
(146, 'donnafer', '123456', 'roldanoliveros1006@gamil.com', 'parent', '2026-01-02 00:40:53', '2026-01-02', '', '2026-01-01 16:40:53', 'pending'),
(147, 'corinne', '123456', 'corinnemalolos@gmail.com', 'parent', '2026-01-02 00:46:48', '2026-01-02', '', '2026-01-01 16:56:46', 'pending'),
(148, 'diana', '123456', 'escobardianef@gmail.com', 'parent', '2026-01-02 01:03:19', '2026-01-02', '', '2026-01-01 17:10:26', 'pending'),
(149, 'kirsten', '123456', 'kirstensumaya@gmail.com', 'parent', '2026-01-02 02:05:08', '2026-01-02', '', '2026-01-01 18:09:39', 'pending'),
(150, 'jesamin', '123456', 'jesamingagalac@gmail.com', 'parent', '2026-01-02 02:15:21', '2026-01-02', '', '2026-01-01 18:19:50', 'pending'),
(151, 'sherleine', '123456', 'roldanoliveros1007@gmail.com', 'parent', '2026-01-02 02:24:04', '2026-01-02', '', '2026-01-01 18:24:04', 'pending'),
(152, 'joyce1', '123456', 'roldanoliveros1008@gmail.com', 'parent', '2026-01-02 13:12:36', '2026-01-02', '', '2026-01-02 05:12:36', 'pending'),
(153, 'archellene', '123456', 'roldanoliveros1009@gmail.com', 'parent', '2026-01-02 13:22:18', '2026-01-02', '', '2026-01-02 05:22:18', 'pending'),
(154, 'clarisssa', '123456', 'clarissavillanueva76@gmail.com', 'parent', '2026-01-02 13:28:45', '2026-01-02', '', '2026-01-02 05:32:39', 'pending'),
(155, 'chelsea', '123456', 'roldanoliveros1010@gmail.com', 'parent', '2026-01-02 13:36:23', '2026-01-02', '', '2026-01-02 05:36:23', 'pending'),
(156, 'deborah', '123456', 'roldanoliveros1011@gmail.com', 'parent', '2026-01-02 13:42:09', '2026-01-02', '', '2026-01-02 05:42:09', 'pending'),
(157, 'raquel', '123456', 'roldaoliveros1012@gmail.com', 'parent', '2026-01-02 13:48:01', '2026-01-02', '', '2026-01-02 05:48:01', 'pending'),
(158, 'diovy', '123123', 'diovyannt@yahoo.com', 'parent', '2026-01-02 13:56:10', '2026-01-02', '', '2026-01-02 05:59:51', 'pending'),
(159, 'rita', '123456', 'fayreyes15@yahoo.com', 'parent', '2026-01-02 14:05:25', '2026-01-02', '', '2026-01-02 06:11:40', 'pending'),
(161, 'candell', '123456', 'roldanoliveros1013@gmail.com', 'parent', '2026-01-02 14:40:08', '2026-01-02', '', '2026-01-02 06:40:08', 'pending'),
(162, 'rachelle', '123456', 'rapbonza@gmail.com', 'parent', '2026-01-02 15:37:20', '2026-01-02', '', '2026-01-02 10:34:05', 'pending'),
(163, 'mercy', '123456', 'roldanoliveros1018@gmail.com', 'parent', '2026-01-02 15:43:02', '2026-01-02', '', '2026-01-02 07:43:02', 'pending'),
(164, 'lyka', '123456', 'LYKACLARISSA@gmail.com', 'parent', '2026-01-02 16:59:01', '2026-01-02', '', '2026-01-02 08:59:01', 'pending'),
(165, 'pamela', '123456', 'PAMELA@gmail.com', 'parent', '2026-01-02 17:24:54', '2026-01-02', '', '2026-01-02 09:24:54', 'pending'),
(166, 'patricia', '123456', 'patricia-xyrille@yahoo.com', 'parent', '2026-01-02 17:34:03', '2026-01-02', '', '2026-01-02 09:37:12', 'pending'),
(167, 'glizelle', '123456', 'glizelle@gmail.com', 'parent', '2026-01-02 18:29:21', '2026-01-02', '', '2026-01-02 10:29:21', 'pending'),
(168, 'kaye', '123456', 'kayecondovara-0s@gmail.com', 'parent', '2026-01-02 18:35:28', '2026-01-02', '', '2026-01-02 10:38:27', 'pending'),
(169, 'dhana', '123456', 'DHANA@gmail.com', 'parent', '2026-01-02 18:40:25', '2026-01-02', '', '2026-01-02 10:40:25', 'pending'),
(170, 'yvonne', '123456', 'LIMYVONNE@gmail.com', 'parent', '2026-01-02 18:44:42', '2026-01-02', '', '2026-01-02 10:48:35', 'pending'),
(171, 'jovilyn', '123456', 'JOVILYN@gmail.com', 'parent', '2026-01-02 18:49:05', '2026-01-02', '', '2026-01-02 10:49:05', 'pending'),
(172, 'katrina', '123456', 'KATRINA@gmai.com', 'parent', '2026-01-02 18:53:42', '2026-01-02', '', '2026-01-02 10:53:42', 'pending'),
(173, 'ann', '123456', 'ANN@gmail.com', 'parent', '2026-01-02 18:57:19', '2026-01-02', '', '2026-01-02 10:57:19', 'pending'),
(174, 'rayechelle', '123456', 'RAYECHELLE@gmail.com', 'parent', '2026-01-02 19:00:44', '2026-01-02', '', '2026-01-02 11:00:44', 'pending'),
(175, 'marydol', '123456', 'MARYDO@gmail.com', 'parent', '2026-01-02 19:06:35', '2026-01-02', '', '2026-01-02 11:06:35', 'pending'),
(176, 'joyce2', '123456', 'JOYCE@gmail.com', 'parent', '2026-01-02 19:10:37', '2026-01-02', '', '2026-01-02 11:10:37', 'pending'),
(177, 'maycie', '123456', 'MAYCIE@gmail.com', 'parent', '2026-01-02 19:14:31', '2026-01-02', '', '2026-01-02 11:14:31', 'pending'),
(178, 'vivian', '123456', 'VIVIAN@gmail.com', 'parent', '2026-01-02 19:45:37', '2026-01-02', '', '2026-01-02 11:45:37', 'pending'),
(179, 'arlett', '123456', 'ARLETT@GMAIL.COM', 'parent', '2026-01-02 19:54:39', '2026-01-02', '', '2026-01-02 11:54:39', 'pending'),
(180, 'christine', '123456', 'CHRISTINE@GMAIL.COM', 'parent', '2026-01-02 19:59:01', '2026-01-02', '', '2026-01-02 11:59:01', 'pending'),
(181, 'pauline', '123456', 'PAULINE@GMAIL.COM', 'parent', '2026-01-02 20:28:12', '2026-01-02', '', '2026-01-02 12:28:12', 'pending'),
(182, 'aliza', '123456', 'ALIZA@GMAIL.COM', 'parent', '2026-01-02 20:36:58', '2026-01-02', '', '2026-01-02 12:36:58', 'pending'),
(183, 'jenny', '123456', 'JENNYROS@GMAIL.COM', 'parent', '2026-01-02 20:41:16', '2026-01-02', '', '2026-01-02 12:41:16', 'pending'),
(184, 'warn', '123456', 'WARRENMANUEL@gmail.com', 'parent', '2026-01-02 20:46:20', '2026-01-02', '', '2026-01-02 12:46:20', 'pending'),
(186, 'joan1', '123456', 'joancasabuena@gmail.com', 'parent', '2026-01-02 21:14:33', '2026-01-02', '', '2026-01-02 13:14:33', 'pending'),
(187, 'rayechelle1', '123456', 'RAYECHELLETABUZO@gmail.com', 'parent', '2026-01-02 21:36:37', '2026-01-02', '', '2026-01-02 13:36:37', 'pending'),
(188, 'marjie', '123456', 'MARJIEMARIE@gmail.com', 'parent', '2026-01-02 21:41:19', '2026-01-02', '', '2026-01-02 13:41:19', 'pending'),
(189, 'rose1', '123456', 'ROSEMICHELLE@GMAIL.COM', 'parent', '2026-01-02 21:46:39', '2026-01-02', '', '2026-01-02 13:46:39', 'pending'),
(190, 'camille', '123456', 'CAMILLE@GMAIL.COM', 'parent', '2026-01-02 21:51:22', '2026-01-02', '', '2026-01-02 13:51:22', 'pending'),
(191, 'kiara', '123456', 'KIARAGLYZEE@GMAIL.COM', 'parent', '2026-01-02 21:58:10', '2026-01-02', '', '2026-01-02 13:58:10', 'pending'),
(192, 'hazel', '123456', 'HAZELSANDOVAL@GMAIL.COM', 'parent', '2026-01-02 22:01:39', '2026-01-02', '', '2026-01-02 14:01:39', 'pending'),
(193, 'joyce3', '123456', 'JOYCEGERALDINE@GMAIL.COM', 'parent', '2026-01-02 22:05:50', '2026-01-02', '', '2026-01-02 14:05:50', 'pending'),
(194, 'rochelle', '123456', 'ROCHELLEANN@GMAIL.COM', 'parent', '2026-01-02 22:10:25', '2026-01-02', '', '2026-01-02 14:10:25', 'pending'),
(195, 'romalyn', '123456', 'ROMALYNTAN@GMAIL.COM', 'parent', '2026-01-02 22:14:21', '2026-01-02', '', '2026-01-02 14:14:21', 'pending'),
(196, 'chelsea1', '123456', 'CHELSEACIEL@GMAIL.COM', 'parent', '2026-01-02 22:18:10', '2026-01-02', '', '2026-01-02 14:18:10', 'pending'),
(197, 'carla', '123456', 'ANGELACARLA@GMAIL.COM', 'parent', '2026-01-02 22:21:38', '2026-01-02', '', '2026-01-02 14:21:38', 'pending');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminandstaff`
--
ALTER TABLE `adminandstaff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`admission_id`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_attendance` (`user_id`,`date`);

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admission_id` (`class_id`);

--
-- Indexes for table `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guardian`
--
ALTER TABLE `guardian`
  ADD PRIMARY KEY (`guardian_id`);

--
-- Indexes for table `guardiansaccount`
--
ALTER TABLE `guardiansaccount`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `openingclosing`
--
ALTER TABLE `openingclosing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `paymentschedule`
--
ALTER TABLE `paymentschedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `paymentschedule_ibfk_2` (`plan_id`);

--
-- Indexes for table `progress_assessments`
--
ALTER TABLE `progress_assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `criteria_id` (`criteria_id`);

--
-- Indexes for table `progress_categories`
--
ALTER TABLE `progress_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `progress_criteria`
--
ALTER TABLE `progress_criteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `progress_remarks`
--
ALTER TABLE `progress_remarks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_photos_upload`
--
ALTER TABLE `teacher_photos_upload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tuitionplans`
--
ALTER TABLE `tuitionplans`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `fk_tuitionplans_classes` (`class_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminandstaff`
--
ALTER TABLE `adminandstaff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `admission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `classroom`
--
ALTER TABLE `classroom`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;

--
-- AUTO_INCREMENT for table `guardian`
--
ALTER TABLE `guardian`
  MODIFY `guardian_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `guardiansaccount`
--
ALTER TABLE `guardiansaccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=553;

--
-- AUTO_INCREMENT for table `openingclosing`
--
ALTER TABLE `openingclosing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=344;

--
-- AUTO_INCREMENT for table `paymentschedule`
--
ALTER TABLE `paymentschedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1182;

--
-- AUTO_INCREMENT for table `progress_assessments`
--
ALTER TABLE `progress_assessments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=417;

--
-- AUTO_INCREMENT for table `progress_categories`
--
ALTER TABLE `progress_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `progress_criteria`
--
ALTER TABLE `progress_criteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `progress_remarks`
--
ALTER TABLE `progress_remarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `teacher_photos_upload`
--
ALTER TABLE `teacher_photos_upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tuitionplans`
--
ALTER TABLE `tuitionplans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `fk_attendance_student` FOREIGN KEY (`user_id`) REFERENCES `students` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `openingclosing` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `progress_assessments`
--
ALTER TABLE `progress_assessments`
  ADD CONSTRAINT `progress_assessments_ibfk_1` FOREIGN KEY (`criteria_id`) REFERENCES `progress_criteria` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `progress_criteria`
--
ALTER TABLE `progress_criteria`
  ADD CONSTRAINT `progress_criteria_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `progress_categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
