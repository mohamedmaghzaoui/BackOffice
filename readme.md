# 🌟 Symfony Back-Office Project

> **A secure back-office platform for managing portfolio projects and skills.**  
> Built with Symfony, this application allows authenticated users to create, update, delete, and search projects and skills efficiently.

## 🚀 Features
- **User Authentication**: Secure access for authenticated users.
- **Project Management**: Add, edit, delete, and search projects with image upload support.
- **Skill Management**: Add, edit, delete, and sort skills based on custom criteria.
- **Image Handling**: Manage project images with upload and deletion functionalities.

## 🛠️ Tech Stack
- **PHP** - Core backend language.
- **Symfony** - PHP framework.
- **Doctrine ORM** - Database management.
- **Twig** - Templating engine for the frontend.



## 📦 Installation
1. **Clone the repository**:
    ```bash
    git clone https://github.com/mohamedmaghzaoui/BackOffice.git
    cd BackOffice
    ```
2. **Install dependencies with Composer**:
    ```bash
    composer install
    ```
3. **Set up environment variables**:
    ```bash
    DATABASE_URL="mysql://username:password@127.0.0.1:3306/db_name"
    UPLOAD_DIRECTORY="path/to/upload_directory"
    ```
4. **Create the database:**
    ```bash
    php bin/console doctrine:database:create
    ```
5. **Run migrations:**
    ```bash
    php bin/console doctrine:migrations:migrate
    ```

6. **Start the Symfony local server:**
    ```bash
    symfony server:start
    ```

7. **Access the application:**
    
    Visit http://localhost:8000 to access the application in your browser.
    
    ## 📂 Environment Variables

| Variable             | Description                         |
|----------------------|-------------------------------------|
| `DATABASE_URL`       | Database connection string         |
| `UPLOAD_DIRECTORY`   | Path to store uploaded images      |
## 📝 Usage

- **Add a Project**  
Route: `/addproject`  
Use this form to add new projects with image upload functionality.

- **Edit a Project**  
Route: `/edit/project/{id}`  
Edit existing projects and update associated images.

- **Delete a Project**  
Route: `/delete/project/{id}`  
Delete projects and remove their associated images from storage.

- **Add a Skill**  
Route: `/addskill`  
Manage your skills with mastery level (0-100).

- **Delete and Edit Skills**  
Routes: `/delete/skill/{id}` and `/edit/skill/{id}`  
Use these endpoints to delete or modify skills.
## 🛡️ Security & Authentication
This project ensures user authentication for all CRUD operations on projects and skills. Unauthorized access redirects users to the home page.

## 📍 About Me
Hi, I'm Mohamed Maghzaoui, a passionate software engineer with a wide range of expertise spanning from web development to IoT, cloud, and networking technologies. I am currently exploring new opportunities to grow my skills and contribute to innovative projects.

My goal is to continuously improve my development skills and build impactful applications.

## 🌐 Website
- Check out my portfolio at: [https://mohamedmaghzaoui.online](https://mohamedmaghzaoui.online)
## 📱 LinkedIn
- Connect with me on LinkedIn: [Mohamed Maghzaoui](https://www.linkedin.com/in/mohamed-maghzaoui-577044256/)
