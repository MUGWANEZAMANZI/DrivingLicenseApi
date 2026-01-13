# DAY 3: Databases (The Source of Truth)

AI models need data. If you can't query a database efficiently, you can't train a model.

## Schedule

### 08:00 - 09:00: Technical Reading

**Read:** "SQL vs NoSQL: When to use which?"

**Key Topics to Understand:**
- SQL databases (MySQL, PostgreSQL, SQLite)
  - Structured data with predefined schemas
  - ACID compliance (Atomicity, Consistency, Isolation, Durability)
  - Relational data with foreign keys
  - Best for complex queries and transactions
  
- NoSQL databases (MongoDB, Redis, Cassandra)
  - Flexible schemas
  - Horizontal scaling
  - Document, key-value, column-family, or graph structures
  - Best for unstructured data and high-volume writes

**When to use SQL:**
- Complex queries with multiple JOIN operations
- Transactions requiring ACID compliance
- Structured data with clear relationships
- Financial applications, inventory systems

**When to use NoSQL:**
- Rapid development with changing requirements
- Massive amounts of data requiring horizontal scaling
- Unstructured or semi-structured data
- Real-time web applications, caching, session storage

---

### 09:00 - 11:00: Task - The Migration

#### Step 1: Create SQL Schema

A SQL script (`schema.sql`) has been created in the `database/` directory with the users table definition.

**File:** `database/schema.sql`

The schema includes:
- `id`: Auto-incrementing primary key
- `name`: User's full name (VARCHAR 255)
- `email`: Unique email address (VARCHAR 255)
- `email_verified_at`: Timestamp for email verification
- `password`: Hashed password (VARCHAR 255)
- `remember_token`: For "remember me" functionality
- `created_at`: Record creation timestamp
- `updated_at`: Record update timestamp

**To run the schema manually:**
```bash
# For MySQL
mysql -u your_username -p your_database < database/schema.sql

# For SQLite
sqlite3 database/database.sqlite < database/schema.sql
```

#### Step 2: CSV to Database Import

A PHP script (`import_csv_to_db.php`) has been created to read the CSV file from Day 2 and insert data into the database.

**File:** `database/import_csv_to_db.php`

**Features:**
- Reads CSV file with headers (name, email, password)
- Validates data before insertion
- Checks for duplicate emails
- Hashes passwords securely using Laravel's Hash facade
- Provides detailed progress output
- Error handling for invalid data

**Usage:**
```bash
# Make sure your .env file is configured with database credentials
php database/import_csv_to_db.php
```

**Sample CSV Format** (`database/users.csv`):
```csv
name,email,password
John Doe,john.doe@example.com,password123
Jane Smith,jane.smith@example.com,securepass456
```

**Note:** The users table already exists in this Laravel application via migrations. The schema.sql file is provided as a standalone SQL reference and learning tool.

---

### 11:00 - 12:00: LeetCode Challenge

**Problem:** [Roman to Integer](https://leetcode.com/problems/roman-to-integer/)

**Description:**
Convert a Roman numeral string to an integer. Roman numerals are represented by seven different symbols:

| Symbol | Value |
|--------|-------|
| I      | 1     |
| V      | 5     |
| X      | 10    |
| L      | 50    |
| C      | 100   |
| D      | 500   |
| M      | 1000  |

**Rules:**
- Roman numerals are usually written largest to smallest from left to right
- Subtraction is used when a smaller numeral appears before a larger one:
  - I before V or X (4, 9)
  - X before L or C (40, 90)
  - C before D or M (400, 900)

**Example:**
- Input: "III" → Output: 3
- Input: "IV" → Output: 4
- Input: "IX" → Output: 9
- Input: "LVIII" → Output: 58
- Input: "MCMXCIV" → Output: 1994

**Approach:**
1. Create a hash map of Roman symbols to values
2. Iterate through the string
3. If current value < next value, subtract current
4. Otherwise, add current value
5. Return the total

**Complexity:**
- Time: O(n) where n is length of string
- Space: O(1) constant space for the hash map

---

### 12:00 - 13:00: Documentation

#### Daily Summary Template

**Date:** [Today's Date]

**Tasks Completed:**
1. ✅ Read about SQL vs NoSQL databases
2. ✅ Created schema.sql for users table
3. ✅ Implemented CSV to database import script
4. ✅ Solved Roman to Integer LeetCode problem

**Technical Challenges:**

1. **SQL Errors Encountered:**
   - Issue: [Describe any SQL syntax errors]
   - Solution: [How you resolved them]
   
   Example:
   - Issue: "Unknown column 'email_verified_at' in 'field list'"
   - Solution: Ensured the migration was run to create the column

2. **Database Connection Issues:**
   - Issue: [Database connection errors]
   - Solution: [Configuration fixes]
   
   Example:
   - Issue: "Access denied for user"
   - Solution: Updated .env file with correct database credentials

3. **CSV Import Challenges:**
   - Issue: [CSV parsing or data validation errors]
   - Solution: [How you handled them]
   
   Example:
   - Issue: Duplicate email addresses in CSV
   - Solution: Added check to skip existing users

**Key Learnings:**
- Understanding when to use SQL vs NoSQL
- How to create database schemas
- Working with PDO/MySQLi in PHP
- Data validation and error handling
- The importance of indexes for query performance

**Code Snippets:**
```php
// Hash passwords securely
$hashedPassword = Hash::make($password);

// Check for existing records
$existingUser = DB::table('users')->where('email', $email)->first();
```

**Tomorrow's Goals:**
- [Plan for Day 4]

---

## Additional Resources

**SQL Learning:**
- [MySQL Official Documentation](https://dev.mysql.com/doc/)
- [SQLite Documentation](https://www.sqlite.org/docs.html)
- [W3Schools SQL Tutorial](https://www.w3schools.com/sql/)

**PHP Database Connections:**
- [Laravel Database Documentation](https://laravel.com/docs/database)
- [PDO Documentation](https://www.php.net/manual/en/book.pdo.php)

**Best Practices:**
- Always hash passwords (never store plain text)
- Use prepared statements to prevent SQL injection
- Validate and sanitize user input
- Use transactions for multiple related operations
- Create appropriate indexes for frequently queried columns

---

## Troubleshooting Common Errors

### Error: "Table 'users' already exists"
**Solution:** The table was already created. You can either:
- Drop the table: `DROP TABLE users;`
- Or modify the script to use `CREATE TABLE IF NOT EXISTS`

### Error: "Access denied for user"
**Solution:** Check your database credentials in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Error: "CSV file not found"
**Solution:** Ensure the CSV file is in the correct location:
- Expected path: `database/users.csv`
- Check file permissions: `chmod 644 database/users.csv`

### Error: "Duplicate entry for key 'email'"
**Solution:** The email already exists in the database. The script will automatically skip duplicates.

---

## Next Steps

After completing Day 3, you should be comfortable with:
- ✅ Understanding SQL database fundamentals
- ✅ Creating database schemas
- ✅ Reading and parsing CSV files
- ✅ Inserting data into databases programmatically
- ✅ Handling database errors gracefully
- ✅ Solving algorithmic problems (Roman to Integer)

**Ready for Day 4!** 🚀
