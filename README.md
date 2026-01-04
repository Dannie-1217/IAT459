# FurEver Friends 🐾

Internet Computing Technologies Project (IAT 459) | SFU


## **Overview**

FurEver Friends is a web-based pet adoption platform focused on the Greater Vancouver area. The system connects pet seekers with providers through a dynamic, database-driven experience.

## **User Roles**

Visitors: Browse and filter pet listings by type and location.

Members (Adopters): Mark favorites, receive personalized recommendations based on interest tags, and submit adoption applications.


Providers: Post new pet listings with multiple images and manage/process adoption requests.

## **Tech Stack**

Frontend: HTML, CSS, JavaScript, AJAX.

Backend: PHP.

Database: MySQL (relational schema with 9 tables including users, pets, tags, and adoption_records).

## **Key Features & Implementation**

Dynamic Filtering: AJAX-powered search results for pet types and locations without page reloads.

Personalization Engine: Recommends pets by matching user preference tags with pet attributes.

Adoption Workflow: Tracks application status from "Processing" to "Approved/Declined," automatically updating pet availability on the site.

Media Management: Supports multi-image uploads per pet stored via dedicated relational tables.

## **Installation**

Clone the repository: git clone https://github.com/Dannie-1217/IAT459.git

Import the provided SQL schema into your phpMyAdmin or MySQL server.

Configure your database connection in the PHP configuration file.

Deploy to a local PHP server.
