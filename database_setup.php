<?php
function setup_database()
{
    $db_path = __DIR__ . '/bank.sqlite';
    // Assuming the database is in the same directory as the script
    $db = new SQLite3($db_path);



    $SQL_create_users = 'CREATE TABLE IF NOT EXISTS users (
        user_id INTEGER PRIMARY KEY AUTOINCREMENT,
        email VARCHAR(255) UNIQUE,
        password_hash VARCHAR(255),
        is_approved INTEGER DEFAULT 0, 
        is_admin INTEGER DEFAULT 0 
    )';

    $db->exec($SQL_create_users);

    $countUsers = $db->querySingle("SELECT COUNT(*) FROM users");

    if ($countUsers == 0) {
        $stmt = $db->prepare("INSERT INTO users (email, password_hash, is_approved, is_admin) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            die($db->lastErrorMsg());
        }
        $stmt->bindValue(1, 'aa@aa.aa', SQLITE3_TEXT);
        $stmt->bindValue(2, password_hash('P@$$w0rd', PASSWORD_DEFAULT), SQLITE3_TEXT);
        $stmt->bindValue(3, 1, SQLITE3_INTEGER); 
        $stmt->bindValue(4, 1, SQLITE3_INTEGER); 
        $result = $stmt->execute();
        if ($result === false) {
            die($db->lastErrorMsg());
        }
    }

    $SQL_create_table = 'CREATE TABLE IF NOT EXISTS transactions (
        transaction_id INTEGER PRIMARY KEY AUTOINCREMENT,
        transaction_date DATE,
        name VARCHAR(255),
        expense DECIMAL(10,2),
        income DECIMAL(10,2),
        overall_balance DECIMAL(10,2)
    )';
    $db->exec($SQL_create_table);

    $SQL_create_bucket = 'CREATE TABLE IF NOT EXISTS buckets (
        bucket_id INTEGER PRIMARY KEY AUTOINCREMENT,
        transaction_name TEXT,
        category TEXT
    )';

    $db->exec($SQL_create_bucket);

    $categories = [
        'Entertainment' => ['St James res', 'Pur & Simple res', 'Subway', 'Mcdonalds', 'White spot', '7-eleven', 'Tim hortons'],
        'Communication' => ['ROGERS', 'Shaw'],
        'Groceries' => ['REAL CDN SUPERS', 'SAFEWAY', 'Walmart', 'Costco', 'CANADIAN TIRE'],
        'Donations' => ['RED CROSS', 'World Vision'],
        'Car Insurance' => ['ICBC'],
        'Gas Heating' => ['FORTISBC'],
        'Misc' => ['O.D.P'],
    ];

    $countResult = $db->querySingle("SELECT COUNT(*) FROM buckets");
    if ($countResult == 0) {
        foreach ($categories as $category => $names) {
            foreach ($names as $name) {
                // Prepare the insert statement for each name under its category
                $stmt = $db->prepare("INSERT INTO buckets (transaction_name, category) VALUES (?, ?)");
                $stmt->bindValue(1, $name, SQLITE3_TEXT); 
                $category = empty($category) ? 'Other' : $category; 
                $stmt->bindValue(2, $category, SQLITE3_TEXT); 
                $stmt->execute();
            }
        }
        return $db;
    }
}
function connect_database()
{
    $db_path = __DIR__ . '/bank.sqlite';

    $db = new SQLite3($db_path);

    return $db;
}

function importCSVToSQLite($filePath, $db)
{
    if (($handle = fopen($filePath, "r")) !== FALSE) {
        $db->exec('BEGIN;');
        $stmt = $db->prepare("INSERT INTO transactions (transaction_date, name, expense, income, overall_balance) VALUES (?, ?, ?, ?, ?)");

  
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $date_string = trim($data[0], "\xEF\xBB\xBF");
            $date = DateTime::createFromFormat('m/d/Y', $date_string);
            if ($date) {
                $formattedDate = $date->format('Y-m-d');
            } else {
                
                echo "Error parsing date: {$date_string}";
                continue; 
            }

            $stmt->bindValue(1, $formattedDate, SQLITE3_TEXT); 
            
            $cleanName = trim(preg_replace('/\s+/', ' ', $data[1]));
            $stmt->bindValue(2, $cleanName, SQLITE3_TEXT); 
            $stmt->bindValue(3, $data[2], SQLITE3_FLOAT); 
            $stmt->bindValue(4, $data[3], SQLITE3_FLOAT); 
            $stmt->bindValue(5, $data[4], SQLITE3_FLOAT); 
            $stmt->execute();
        }

        $db->exec('COMMIT;');
        fclose($handle);

        // Rename the file after importing
        rename($filePath, $filePath . '.imported');
    }
}
