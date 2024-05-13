<?php

/*=====================================================================
 *
 * Waimea College Standard PHP Library
 * Steve Copley
 * Digital Technologies Dept.
 *
 * Version: 3.0 (March 2024)
 * Rewrite / update of
 * https://gist.github.com/waimea-cpy/7ae035ca308f5c18d4ff5a138e683c8b
 *
 * Functions to:
 *
 *   - Connect to MySQL server database via PDO:
 *        connectToDB()
 *
 *   - Display debug info in the JS console:
 *        showDebugInfo()
 *
 *---------------------------------------------------------------------
 * History:
 *
 *  3.0 (2024-03-04) - Initial release
 *=====================================================================*/




// Constants to define how errors are logged to the JS console
define('INFO', false);
define('ERROR', true);


/*-------------------------------------------------------------
 * Connect to MySQL database via PDO (PHP Data Objects)
 *
 * Requires: A config file called _db.ini with these fields...
 *             name="_______"  (the database to connect to)
 *             user="_______"  (the MySQL username)
 *             pass="_______"  (the MySQL password)
 *
 * Returns: the PDO database connection object
 *-------------------------------------------------------------*/
function connectToDB() {
    // Do we have a config file?
    if (!file_exists('_db.ini')) {
        consoleLog('_db.ini file missing', 'DB Config', ERROR);
        die('Missing database configuration');
    }

    // Parse the  config file
    $db = parse_ini_file( '_db.ini', true );
    // Generate a Databse Source Name string
    $dsn = 'mysql:host=localhost;charset=utf8mb4;dbname=' . $db['name'];
    // Set some useful options (errors as exception, associative arrays)
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    // Attempt to connect
    try {
        // Return the newly connected PDO object
        return new PDO($dsn, $db['user'], $db['pass'], $options);
    }
    catch (PDOException $e) {
        // Something went wrong, so log it
        consoleLog($e->getMessage(), 'DB Connect', ERROR);
        die('There was an error when connecting to the database');
    }
}


/*-------------------------------------------------------------
 * Add debug info to the JS Console in the browser
 *
 * Note, if a constant DEBUG is defined and set to false, this
 *       will suppress the output, otherwise it is shown
 *
 * Arguments: $var - a variable to display
 *            $heading - an optional heading to show beforhand
 *            $level - either INFO (default) or ERROR level
 *-------------------------------------------------------------*/
function consoleLog($var, $heading='', $level=INFO) {
    // Only log if DEBUG not set to false
    if (defined('DEBUG') ? DEBUG : true) {
        // Is this an error or just info?
        $logCmd   = $level == ERROR ? 'console.error' : 'console.log';
        $logLabel = $level == ERROR ? 'ERROR' : 'INFO';
        // Log the message
        echo '<script>';
        // Heading
        echo   $logCmd . '(`PHP ' . $logLabel . ': ' . $heading . '`);';
        // Message content as a pre-formatted, multi-line string
        echo   $logCmd . '(`';
        print_r($var);
        echo   '`);';
        echo '</script>';
    }
}