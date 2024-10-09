# Kilometer Journal

## Description
This project is a PHP-based application that interacts with a database to manage and track kilometer entries, fuel consumption, and other related data. It includes functionalities for adding, retrieving, and deleting entries, as well as calculating fuel usage and summarizing data.

## Features
- Add new kilometer entries
- Retrieve the last kilometer entry
- Get a list of entries with pagination
- Delete specific entries
- Calculate fuel useed based on kilometers driven
- Calculate the difference in fuel remaining between entries
- Summarize total kilometers per month in given year

## Technologies Used
- PHP
- JavaScript
- SQL (SQLite)

## Installation
1. Clone the repository:
    ```sh
    git clone https://github.com/OleMortensen8/Kiliometerjournal.git
    ```
2. Navigate to the project directory:
    ```sh
    cd Kiliometerjournal
    ```
3. Set up your database and ensure the `DB.php` file has the correct database connection details.

## Usage
1. Open the project in your preferred IDE.
2. Ensure your web server is running and configured to serve the project.
3. Access the application through your web browser.

## Code Overview
### `classes/DB.php`
This file contains the main database interaction class with methods for:
- Connecting to the database
- Adding new entries
- Retrieving the last kilometer entry
- Getting a list of entries with pagination
- Deleting entries
- Calculating fuel used
- Summarizing total kilometers per month

### Example Methods
- `getlastStopKm()`: Retrieves the last stop kilometer value.
- `getDataToSql($limit, $offset)`: Retrieves a list of entries with pagination.
- `deleteEntry($id)`: Deletes an entry by ID.
- `calculateFuelUsed($kmDriven)`: Calculates fuel used based on kilometers driven.

## Contributing
1. Fork the repository.
2. Create a new branch:
    ```sh
    git checkout -b feature-branch
    ```
3. Make your changes and commit them:
    ```sh
    git commit -m "Description of changes"
    ```
4. Push to the branch:
    ```sh
    git push origin feature-branch
    ```
5. Create a pull request.

## License
This project is licensed under the GPL-3.0 License. See the `LICENSE` file for more details.

## Contact
For any questions or issues, please open an issue in the repository and add a PR to the corresponding issue. reference the issue.
