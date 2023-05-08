# Anagram API

This is a RESTful API built with the Laravel PHP framework and the React JavaScript library. The purpose of this application is to load a wordbase from the EKI website into the application's database and use that wordbase to find anagrams for user-entered words.

## Installation

**Note:** In this installation guide, we are using a project folder named "anagram" for these examples. You can choose your own folder name.

To download and run the application on your local machine, follow these steps:

1. Open a terminal in your local development environment folder (usually named `htdocs` if using XAMPP or MAMP, etc.).
2. Clone the repository by running the following command in the terminal: 
`git clone [projects_repository] anagram`
Replace `[projects_repository]` with the HTTPS URL or SSH key of this repository. The "anagram" after the repository URL creates a folder named "anagram" and clones the repository into that folder.
3. After the clone is complete, navigate to the "anagram" folder and run the following command to install dependencies from the lock file:
`composer install`
4. Run the following command to install the Node modules:
`npm install`
5. Create a MySQL database for the application.
6. Open the `.env.example` file in the application's root folder and change its name to `.env`.
7. In the `.env` file, add the name, username, and password of the created database, and change the `APP_URL` to `http://localhost/anagram/public/`.
8. To use Swagger-generated API documentation, go to the `/public/api.yaml` file and under `servers:`, change the URL to the one you declared in the `.env` file.
9. Run the following command in the terminal to generate the application's encryption key:
`php artisan key:generate`
10. Run the following command in the terminal to create tables and seed user data for login:
`php artisan migrate --seed`

The application is now ready to use. Go to your localhost URL `http://localhost/anagram/public/` to access the application.

## Usage

### Login

To start using the application, go to the application's URL: `http://localhost/anagram/public/`. You will be prompted to login using email and password. By default, the credentials are as follows:
- Email: `user@test.com`
- Password: `Passw0rd`

Upon successful login, you will be redirected to the index page. If the login cookie expires (after 30 minutes), you will need to login again.

### Loading the wordbase

Before you can start finding anagrams, you need to load the wordbase into the application. To do so, click on the "Load" button on the homepage. This will load the wordbase from the EKI website into the application's database.

### Finding anagrams

Once the wordbase is loaded, you can start finding anagrams by entering a word into the "Enter a word..." field and clicking on the "Send" button. The application will display a list of all the possible anagrams of the entered word. As the wordbase is in estonian, it is recommended to use estonian words.

### Testing

To ensure that the application is functioning correctly, you can run the automated tests by executing the following command in your terminal:
`php artisan test`
The test file is located in `tests/unit` and is named `AlgorithmTest.php`.

### API Documentation

You can access the API documentation for the application by navigating to the `http://localhost/anagram/public/docs` endpoint in your web browser. This will open up the Swagger UI interface, where you can explore the different API endpoints and their respective parameters and responses.

### Live application

Live application is located at `https://kexdev.ee/anagram/public/`. User credentials for the login are the same as in the usage guide. The API documentation is also available at the URL `https://kexdev.ee/anagram/public/docs`.
