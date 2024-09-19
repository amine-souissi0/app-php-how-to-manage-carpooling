README.md file for your project. This will explain the structure, the scenario, how to navigate between pages, the joins used in the project, and instructions for setting up and running the project.

markdown
Copier le code
# Carpooling Platform Project

## Overview

This project is a PHP-based carpooling platform where users can register as an Administrator, Driver (Conducteur), or Passenger (Passager). Depending on their role, they can perform specific actions, such as managing trips, reserving trips, and viewing trip history.

## Project Structure

Here is the structure of the project:

/config - database.php # Database connection file

/controllers - ReservationController.php # Controller to handle reservations - TrajetController.php # Controller to manage trips - UtilisateurController.php # Controller for managing users (Admin, Driver, Passenger)

/models - Reservation.php # Model for reservations - Trajet.php # Model for trips - Utilisateur.php # Model for users

/public - login.php # Login page for all users - register.php # Registration page for users

/views /back # Admin views (back-office) - admin_dashboard.php # Admin dashboard for user and trip management - users.php # User management (add, edit, delete users)

bash
Copier le code
/front                    # Driver and Passenger views (front-office)
    - passager_dashboard.php  # Dashboard for passengers
    - conducteur_dashboard.php # Dashboard for drivers
    - gerer_trajets.php       # Driver: Manage trips
    - recherche_trajets.php   # Passenger: Search and reserve trips
    - historique_reservations.php  # Passenger: View reservation history
/css - styles.css # Stylesheet for basic styling

base_back.php # Base layout for back-office pages README.md # Project documentation

markdown
Copier le code

## Features by Role

### 1. **Administrator**
   - Can manage users (add, modify, delete, view users).
   - Can search and filter users.
   - Can view statistics on trips and users.

### 2. **Driver (Conducteur)**
   - Can manage their trips (add, modify, delete, view trips).
   - Can view passenger reservations for their trips.
   - Can perform multi-criteria searches and sort trips.

### 3. **Passenger (Passager)**
   - Can search, filter, and reserve trips.
   - Can view the history of reservations and trips they have taken.

## Database Relations and Joins

### 1. **Users and Trips (One-to-Many)**
   - A `Driver` can create multiple `Trips`.
   - In the `Trajet` model, there is a `conducteur_id` column that connects a trip to the `Users` table.

### 2. **Trips and Reservations (One-to-Many)**
   - A `Trip` can have multiple `Reservations`.
   - In the `Reservation` model, there is a `trajet_id` column that links a reservation to the `Trips` table.
   - The `passager_id` in the `Reservation` model connects each reservation to a `Passenger` in the `Users` table.

### Sample Join Query for Reservations:
```sql
SELECT t.depart, t.destination, r.date_reservation 
FROM reservations r 
JOIN trips t ON r.trajet_id = t.id 
WHERE r.passager_id = :passager_id;
Navigation
Login Page: http://localhost:8000/public/login.php

Use this page to log in as an Administrator, Driver, or Passenger.
Register Page: http://localhost:8000/public/register.php

Register a new user.
Administrator Dashboard: http://localhost:8000/views/back/admin_dashboard.php

Manage users and view trip statistics.
Driver Dashboard: http://localhost:8000/views/front/conducteur_dashboard.php

Manage trips and view passenger reservations.
Passenger Dashboard: http://localhost:8000/views/front/passager_dashboard.php

Search for trips, reserve trips, and view your reservation history.
Setting Up the Project
Step 1: Install XAMPP or any other PHP Server
Make sure you have XAMPP or another local PHP server installed and running.

Step 2: Configure the Database
Create a MySQL database named covoiturage.
Import the SQL schema into the database to create the necessary tables (users, trips, reservations).
Step 3: Configure Database Connection
Edit the /config/database.php file to match your MySQL credentials:

php
Copier le code
class Database {
    private $host = "localhost";
    private $db_name = "covoiturage";
    private $username = "root";  // Use your MySQL username
    private $password = "";      // Use your MySQL password
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
Step 4: Start the Server
Move the project files into the htdocs folder of your XAMPP installation (or equivalent for other PHP servers).
Open the XAMPP control panel and start Apache and MySQL.
In your browser, navigate to http://localhost:8000/public/login.php.
Step 5: Access the Application
Login as an Administrator, Driver, or Passenger using the credentials stored in the users table.
Perform the actions outlined in the scenario for each role.
Step 6: Git Version Control
Make sure to track your progress with Git. You can initialize a Git repository by running:

bash
Copier le code
git init
git add .
git commit -m "Initial commit"
Scenario Walkthrough
Administrator

Navigate to the Admin Dashboard.
Add, modify, and delete users. View users in a sortable table.
View trip and user statistics.
Driver

Manage trips (create, update, delete).
View reservations made by passengers for the driver's trips.
Passenger

Search and filter trips.
Make reservations.
View the history of reservations and trips completed.
Future Improvements
Implement more advanced search filters for trips.
Add role-based access control to further secure routes.
Improve the UI design using CSS frameworks like Bootstrap or Materialize.
Contact
For any issues or improvements, feel free to reach out.

csharp
Copier le code

### Conclusion

You can copy this README into your project directory and modify it further if needed. It explains
