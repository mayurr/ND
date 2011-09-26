<?php
/* db.php
 *     The database class for all the database needs. Database access wrapper.
 * 
 * Bogdan Lupandin ~ (elitezenithweb@gmail.com)
 *      Please leave this notice intact. Thank you.
 * 
 * Last Updated: Sat May 22, 2011 (12:29 AM)
 */

class db {

    // Variables used throughout the class for connection purposes
    private $var_file = 'includes/vars.xml';    // The location of database variables (Relative to the main PHP file using).
    private $persistant = false;                // If we need to use a persistant connection, set this to true
    private $free_result = true;                // Clears the resource result after every call
    private $admin_debug = true;                // If the debugging should be created for the admin... ONLY if for admin
    private $cache_results = true;              // If you want to use the caching capabilities, set this to true
    private $cache_dir = 'cache/sql/';          // The directory where the cache files would be written to
    private $silent = false;                    // Silence all errors (graceful error) if set to true
    private $log_errors = true;                 // Wether we should log the errors or not
    private $log_file = 'logs/sql.txt';         // The location of the log file
    private $cache_time_limit = 60;          // The amount of seconds you want the cache to exist (1 Day [86400] by default)
    // 60 = 1 Minute; 3600 = 1 Hour; 43200 = 12 Hours; 2629743.83 = 1 Month; 15778463 = 6 Months; 31556926 = 1 Year
    
    // Configuration and feature variables used to trigger events / give access to features
    private $mysql_link;                        // MySQL Connection link resource
    private $last_result;                       // Last result produced/ran through the class
    public $last_sql;                           // Last SQL used in the class
    public $data_css;                           // The CSS for the generated SQL Data Result Set (last_sql_data())
    protected $user;                            // User used to connect to the MySQL Database
    protected $host;                            // Host used to connect to the MySQL Database
    protected $pass;                            // Password used to connect to the MySQL Database
    protected $dbname;                          // The database name that would be selected after connection to the MySQL is made
    public $prefix;                             // Prefix on all the tables in the database previously defined
    
    // Various other variables used throughout the class
    public $returned;                           // The return value of the previously used function
    
    // Allowed SQL query functions to be performed. For added security wall.
    private $sql_queries = array('SELECT', 'FROM', 'LEFT JOIN', 'JOIN', 'RIGHT JOIN', 'INNER JOIN', 'OUTER JOIN', 'OUTER RIGHT JOIN',
                                 'OUTER LEFT JOIN', 'INNER RIGHT JOIN', 'INNER LEFT JOIN', 'WHERE', 'ORDER BY', 'ASC', 'DESC', 'GROUP BY',
                                 'HAVING', 'ON', 'AVG', 'COUNT', 'SUM', 'FIRST', 'LAST', 'MAX', 'MIN', 'UCASE', 'LCASE', 'MID', 'LEN',
                                 'ROUND', 'NOW', 'FORMAT', 'ABS', 'SIGN', 'MOD', 'ROUND', 'POW', 'SQRT', 'LEAST', 'GREATEST', 'LOWER',
                                 'UPPER', 'CONCAT', 'LENGTH', 'LTRIM', 'TRIM', 'RTRIM', 'SUBSTRING', 'DATEOB', 'USER', 'PRIVGROUPS',
                                 'IF', 'COALESCE', 'UNIQUEKEY', 'TONUMBER', 'RAND', 'SELECT DISTINCT', 'UPDATE', 'DELETE', 'INSERT',
                                 'UNION', 'DELETE FROM');
    
    // Allowed SQL functions (0 = Not Allowed; 1 = Allowed)
    private $all_funcs = array('CREATE'         => 0,
                               'DROP'           => 0,
                               'ALTER'          => 0,
                               'CREATE INDEX'   => 1,
                               'UPDATE'         => 1,
                               'INSERT'         => 1,
                               'SELECT'         => 1
                           );
                           
    /*
     * function db( void )
     *
     * The constructor function for this class
     */
    
    function db($database = null)
    {
        /*
         * Overwriting silent to false if admin debug is set to true. This way, if the admin
         *  debug is set to true, the admin would be able to see all the errors thrown by the
         *  class and give a better idea of whats going on if something doesn't work.
         */
        if($this->admin_debug === true)
        {
            $this->silent = false;
        }
        
        // Retrieving the type of database variable page we are using (XML versus PHP)
        if($ret = @simplexml_load_file($this->var_file))
        {
            // Setting the database information to the database variables
            $this->user = $ret->user;
            $this->host = $ret->host;
            $this->pass = $ret->pass;
            $this->dbname = ($database) ? $database : $ret->dbname;
            $this->prefix = $ret->table_prefix;
        }
        else
        {
            // Checking if the file exists
            if(file_exists($this->var_file))
            {
                // Including the database variable page
                include_once $this->var_file;
            }
            else
            {
                // Checking if this is the error message should be for the admin
                $adm_debug = null;
                if($this->admin_debug === true)
                {
                    $adm_debug = "Location of file: {$this->var_file}";
                }
                
                // Checking if we are to log the error
                if($this->log_errors === true)
                {
                    $this->log_error("Error loading MySQL Variable File: 404 File Not Found Encountered. Assumed location of file: {$this->var_file}");
                }
                
                // Checking if we are too kill the script
                if($this->silent === false)
                {
                    die("<p>Could not load the MySQL variable file.<br><br>{$adm_debug}");
                }
                
                // Here we are returning false, since we didn't find the var file
                return false;
            }
            
            // Setting the database information to the database variables
            $this->user = $user;
            $this->host = $host;
            $this->pass = $pass;
            $this->dbname = ($database) ? $database : $dbname;
            $this->prefix = $tbl_pre;
        }
        
        // Connecting to the database
        $this->connect($database);
    }
    
    /*
     * private function connect([ string $dbname])
     *      @string $dbname - over-rides the $this->dbname if both are set...
     *                 otherwise used $this->dbname if set
     * 
     * Connects to MySQL and selects the database
     */

    private function connect($dbname = null)
    {
        // Checking if we are already connected to MySQL
        if(is_resource($this->mysql_link) || @mysql_ping($this->mysql_link))
        {
            return true;
        }
        
        // Connecting to MySQL
        if($this->persistant)
        {
            // Persistent connect
            $this->mysql_link = @mysql_pconnect($this->host, $this->user, $this->pass);
        }
        else
        {
            // Normal Connect
            $this->mysql_link = @mysql_connect($this->host, $this->user, $this->pass);
        }
        
        // If we are still not connected, then die with some debugging script
        if(!is_resource($this->mysql_link))
        {
            // Logging the error if need be
            if($this->log_errors === true)
            {
                // Checking if we are using a password
                $passed = (empty($this->pass) || !isset($this->pass)) ? 'NO' : 'YES';
                
                // Writing the error
                $this->log_error("Error connecting to MySQL. Using {$this->user}@{$this->host} | Using password: {$passed}");
            }
            
            // Generating the admin part of the debug if needed
            $admin_debug = null;
            if($this->admin_debug === true)
            {
                $admin_debug = <<<EOT
<p>The following MySQL Connection Credentials were passed:<br />
<br />
<strong>Username:</strong> {$this->user}<br />
<strong>Host:</strong> {$this->host}<br />
<strong>Password:</strong> {$this->pass}</p>
EOT;
            }
            
            if($this->silent === false)
            {
                // Killing the script and showing the error
                die("<html>
   <head>
        <title>MySQL Connection Error</title>
   </head>
<body>
<p>There was an error connecting to the database. The following things could go wrong:</p>
<ol>
    <li>If you are connecting to the local server:
        <ol>
            <li>Make sure the database name, host and username are correct
                <ol>
                    <li>The host would usually be <strong>localhost</strong> or <strong>127.0.0.1:3306</strong>, but instead of 3306, the server may sometimes use <strong>3307</strong> or <strong>3308</strong>.</li>
                    <li>Try the mysql_connect function raw. Sometimes the correct name, host and username is filled in the PHP.ini, and the function defaults to those values if no arguments are passed to the function.</li>
                </ol>
            </li>
            <li>Make sure that the user is created with the correct password associated to it.</li>
            <li>Check for any possible spelling errors.</li>
        </ol>
    </li>
    <li>If you are connecting to a remote server
        <ol>
            <li>You may need to get in touch with the remote server's tech support... 
                <ol>
                    <li>...to ensure that you can get through its firewall. It is not necessarily enough to have your server number listed in the recipient site's cpanel remote access host list. It depends on how the server company has things set up.</li>
                    <li>...to find out what port number they are using for database connections, which may not be the default used by mysql_connect</li>
                    <li>...If you are using ODBC, the host to which you are trying to connect may or may not have any ODBC drivers installed</li>
                    <li>...If you are working from a dynamic IP, they may be set up to accommodate it, or you may have to use a proxy. See <a href=\"http://forge.mysql.com/wiki/MySQL_Proxy\">http://forge.mysql.com/wiki/MySQL_Proxy</a>
                </ol>
            </li>
            <li>If you are working from a shared server yourself, the server number you were sent in the sign-up letter is probably NOT the server number you should be using to connect to a remote database. You need the server number of the machine on which your site is sitting, not your virtual account server number on that machine. You can get this from your own tech support.</li>
        </ol>
    </li>
</ol>
<p>The following MySQL Error was returned:<br />
<br />
" . mysql_error() . "</p>
$admin_debug
</body>
</html>");
            }
            
            // Returning false since we aren't connected to any MySQL database
            return false;
        }
        
        // Selecting the Database
        $this->dbselect($dbname);
    }
    
    /*
     * private function dbselect([ string $dbname])
     *      @string $dbname - over-rides the $this->dbname if both are set...
     *                 otherwise uses $this->dbname if set
     * 
     * Selects the database
     */
    
    private function dbselect($dbname = null)
    {
        // Checking if we are still connected to MySQL
        if(!is_resource($this->mysql_link))
        {
            // Connecting to the database
            $this->restart($dbname);
        }
        
        // Setting the database 
        $dbname = ((!$dbname) ? $this->dbname : $dbname);
        
        // Setting the returned placeholder to the database name used
        $this->returned = $dbname;
        
        // Selecting a database
        if(mysql_select_db($dbname))
        {
            return true;
        }
        else
        {
            // Logging the error if need be
            if($this->log_errors === true)
            {
                $this->log_error('Error selecting MySQL Database. Attempting to select database named "' . $dbname . '"');
            }
            
            // Checking if we need to kill the script
            if($this->silent == false)
            {
                die(mysql_error());
            }
            
            // There was a problem with connecting to the mysql database
            return false;
        }
    }
    
    /*
     * public function close( void )
     *      Closes a MySQL Connection
     */
    
    public function close()
    {
        // Resetting the variables
        $this->last_sql = null;
        $this->last_result = null;
        
        // Closing the MySQL connection
        if(is_resource($this->mysql_link))
        {
            $this->returned = mysql_close($this->mysql_link);
        }
        
        // Setting the MySQL Link variable to null
        $this->mysql_link = null;
    }
     
     /*
      * public function restart( string $dbname)
      *     @string $dbname - Database to select once connected to MySQL
      * 
      * Restarts a connection to MySQL and selects a named database
      */
    
    public function restart($dbname = null)
    {
        // Closing MySQL connection
        $this->close();
        
        // Connecting to MySQL and selecting a database
        $this->connect($dbname);
    }
    
     /*
      * public function set_opts( array $options)
      *     @array $options - The array that we use to set the options to
      *         The key is the option name while the value is the value
      *             array('cache_results' => true);
      * 
      * Function to set some options outside of the class
      */
    
    public function set_opts($options)
    {
        // Checking if we have a cache_results option
        if(isset($options['cache_results']))
        {
            $this->cache_results = ($options['cache_results'] == true) ? true : false;
        }
    }
    
    /*
     * public function fetch_row( string $sql [, bool $type])
     *      @string $sql - the sql that would be querying the database
     *      @boolean $type - the type of return you would like to get
     *          array - mysql_fetch_array
     *          assoc - mysql_fetch_assoc (Default)
     *          object - mysql_fetch_object
     *          row - mysql_fetch_row
     * 
     *  Function that fetches the current row
     */
    
    public function fetch_row($sql, $type = 'assoc')
    {
        // Checking if the SQL query was cached
        if($this->cache_results === true)
        {
            // Checking if the cached file was retrieved properly
            if($content = $this->retrieve_cache($sql))
            {
                return $content;
            }
        }
        
        // Creating a result resource
        $results = $this->resource($sql, true);
        
        // Setting the result array
        $result = array();
        
        // Checking what type of result we want
        if($type == 'assoc')
        {
            $result = mysql_fetch_assoc($results);
        }
        elseif($type == 'array')
        {
            $result = mysql_fetch_array($results);
        }
        elseif($type == 'object')
        {
            $result = mysql_fetch_object($results);
        }
        elseif($type == 'row')
        {
            $result = mysql_fetch_row($results);
        }
        else
        {
            $result = mysql_fetch_assoc($results);
        }
        
        // Checking if we need to free the result resource
        if($this->free_result == true)
        {
            $this->free_result();
        }
        
        // Checking if we need to cache the result
        if($this->cache_results === true)
        {
            $this->cache_result($sql, $result);
        }
        
        // Returning the result (if not cached)
        return ($type == 'object') ? (object) $result : $result ;
    }
    
    /*
     * public function fetch_rowset( string $sql [, bool $type])
     *      @string $sql - the sql that would be querying the database
     *      @boolean $type - the type of return you would like to get
     *          array - mysql_fetch_array
     *          assoc - mysql_fetch_assoc (Default)
     *          object - mysql_fetch_object
     *          row - mysql_fetch_row
     * 
     *  Function that fetches all of the rows
     */
    
    public function fetch_rowset($sql, $type = 'assoc')
    {
        // Checking if the SQL query was cached
        if($this->cache_results === true)
        {
            // Checking if the cached file was retrieved properly
            if($content = $this->retrieve_cache($sql))
            {
                return $content;
            }
        }
        
        // Creating a result resource
        $results = $this->resource($sql, true);
        
        // Checking what type of result we want
        if($type == 'assoc')
        {
            while($row = mysql_fetch_assoc($results))
            {
                $result[] = $row;
            }
        }
        elseif($type == 'array')
        {
            while($row = mysql_fetch_array($results))
            {
                $result[] = $row;
            }
        }
        elseif($type == 'object')
        {
            while($row = mysql_fetch_object($results))
            {
                $result[] = $row;
            }
        }
        elseif($type == 'row')
        {
            while($row = mysql_fetch_row($results))
            {
                $result[] = $row;
            }
        }
        else
        {
            while($row = mysql_fetch_assoc($results))
            {
                $result[] = $row;
            }
        }
        
        // Checking if we need to free the result resource
        if($this->free_result == true)
        {
            $this->free_result();
        }
        
        // Checking if we need to cache the result
        if($this->cache_results === true)
        {
            $this->cache_result($sql, $result);
        }
        
        // Returning the result (if not cached)
        return ($type == 'object') ? (object) $result : $result;
    }
    
    /*
     * public function num_rows( string $sql [, bool $type])
     *      @string $sql - the sql that would be querying the database
     *      @boolean $type - the type of return you would like to get
     *          rows - mysql_num_rows (Default)
     *          [Anything else] - mysql_num_fields
     * 
     * Function that counts the number of rows there are from
     *  a query
     */
    
    public function num_rows($sql, $type = 'rows')
    {
        // Checking if the SQL query was cached
        if($this->cache_results === true)
        {
            // Checking if the cached file was retrieved properly
            if($content = $this->retrieve_cache($sql . '_num'))
            {
                return $content;
            }
        }
        
        // Setting the result resource
        $results = $this->resource($sql, true);
        
        // Getting the requested result
        $result = (($type == 'rows') ? mysql_num_rows($results) : mysql_num_fields($results));
        
        // Checking if we need to free the result resource
        if($this->free_result == true)
        {
            $this->free_result();
        }
        
        // Checking if we need to cache the result
        if($this->cache_results === true)
        {
            $this->cache_result($sql . '_num', $result);
        }
        
        // Returning the result (if not cached)
        return $result;
    }
    
    /*
     * public function _get_( string $what, string $from, string|array $where [, string $amount])
     *      @string $what - The column name you want to retrieve
     *      @string $from - The table from where you want the data to be
     *          retrieved from.
     *      @string @array $where - The where clause of a SELECT statement. Could
     *          be set to null if you don't want any. Could be an array for multiple
     *          'where' clauses.
     *      @string $amount - Amount of results expected. If one, only one
     *          result would be returned, if it be greater than one, an array
     *          of all found results would be returned that is the [$what].
     * 
     * A simple function that creates the SQL... carries it out and returns the
     *  result(s).
     */
    
    public function _get_($what, $from, $where = null)
    {
        // Generating the SQL for the query
        $sql = array('SELECT' => $what,
                     'FROM' => $from);
        
        // Generating the WHERE clause
        if(!is_null($where))
        {
            if(is_array($where))
            {
                $where = $this->build_where($where, false);
                
                // Merging the WHERE clause with the rest of the SQL array
                $sql = array_merge($sql, array('WHERE' => $where));
            }
            else
            {
                $sql['WHERE'] = $this->san_query($where);
            }
        }
        
        // Setting the generated SQL to $sql
        $sql = $this->build_key_query($sql);
        
        // Setting the last sql to the correct variable
        $this->last_sql = $sql;
        
        // Retrieving the number of results there are to the query
        $num = $this->num_rows($sql);
        
        // Checking if the $num is greater than 1
        if($num > 1)
        {
            $return = $this->fetch_rowset($sql);
        }
        else
        {
            $return = $this->fetch_row($sql);
        }
        
        // Returning the appropriate result (set).
        return ($num > 1) ? $return : $return[$what];
    }
    
    /*
     * public function resource( [string $sql [, bool $return]])
     *      @string $sql - The SQL used for the result resource
     *      @boolean $return - Wether the resource would be returned or a true/false boolean
     * 
     * Function that sets the result resource
     */
    
    public function resource($sql = null, $return = false)
    {
        // Checking if we are connected to MySQL
        if(!is_resource($this->mysql_link))
        {
            $this->connect();
        }
        
        // Checking if the SQL is empty
        if(is_null($sql))
        {
            $sql = $this->get_last_sql();
        }
        
        // Getting the resource into a variable
        $resource = mysql_query($sql);
        
        // Setting the last result variable
        $this->last_result = $resource;
        
        // Checking if the resource was created properly
        if(is_resource($resource) || $resource == true)
        {
            // Checking if we are returning the result
            if($return == true)
            {
                return $resource;
            }
            
            // Otherwise we are returning true
            return true;
        }
        else
        {
            // Logging the error if need be
            if($this->log_errors === true)
            {
                $this->log_error("Error setting MySQL Resource. SQL used: '{$sql}' MySQL Error: " . mysql_error());
            }
            
            // Checking if we need to kill the script
            if($this->silent == false)
            {
                echo $sql . "<br /><br />";
                die(mysql_error());
            }
            
            // It was a failure... return false
            return false;
        }
    }
    
    /*
     * public function free_result([ resource $result])
     *      @resource $result - The result resource to free
     * 
     * Function that frees a MySQL result set
     */
    
    public function free_result($result = null)
    {
        // Checking if the resource result is checked. If not, using the last one set
        $result = ((is_null($result)) ? $this->last_result : $result);
        
        // Freeing the result set
        return mysql_free_result($result);
    }
    
    /*
     * public function san_query( string|array $query)
     *      @string /or\ @array $query - Query to be sanitized
     * 
     * Sanitizes a string or an array from possible injections.
     * Prepares a string to be an SQL
     */
    
    public function san_query($query)
    {
        // Checking if the query is an array
        if(is_array($query))
        {
            // Initiating the sanitized query array
            $san_query = array();
            
            // Sanitizing the values in the array
            foreach($query as $value)
            {
                // Checking if the value is an array
                if(!is_array($value))
                {
                    $san_query[] = mysql_real_escape_string($value);
                }
                else
                {
                    $san_query[] =  $this->san_query($value);
                }
            }
        }
        else
        {
            // Sanitizing the value
            $san_query = mysql_real_escape_string($query);
        }
        
        // Returning the sanitized values
        return $san_query;
    }
    
    /*
     * public function unsan_sql( string $query)
     *      @string $query - Query to prepare to be a string
     * 
     * Prepares a sanitized SQL query to be a string
     */
    
    public function unsan_sql($query)
    {
        return stripslashes($query);
    }
    
    /*
     * private function gen_allowed( void )
     * 
     * Function to generate allowed SQL functions. Returns them in an array.
     */
    
    private function gen_allowed()
    {
        // Checking which SQL functions are allowed
        foreach($this->all_funcs as $key => $value)
        {
            // Checking if the SQL Function is allowed
            if($value == 1)
            {
                // Setting the return value
                $return[] = $key;
            }
        }
        
        // Returning the created array
        return ((count($return) > 0) ? $return : false);
    }
    
    /*
     * public function build_key_query( array $sql)
     *      @array $sql - the SQL array
     * 
     * Function that builds queries using an array
     * Usage example...
     * 
     * $sql = array(
     *              'SELECT'    => '*',
     *              'FROM'      => '`database`.`table`',
     *              'JOIN'      => '`table2',
     *              'ON'        => '`table1`.`field1` = `table2`.`field2`',
     *              'WHERE'     => array(
     *                                  '`field1`' => 'value1',
     *                                  '`field2`' => 'value2'),
     *              'ORDER BY'  => '`field2`',
     *              'ASC'       => null
     * );
     */
     
    public function build_key_query($sql)
    {
        // Checking if $sql is an array
        if(!is_array($sql))
        {
            if($this->silent === false)
            {
                trigger_error('The variable <strong>$sql</strong> is not an array ', E_USER_ERROR);
            }
            return false;
        }
        
        // Checking if $sql is a valid array
        if(!$this->rkey_exists($sql, $this->sql_queries))
        {
            if($this->silent === false)
            {
                trigger_error('The variable <strong>$sql</strong> is not a valid array ', E_USER_ERROR);
            }
            return false;
        }
        
        // Retrieving the first key in the array
        $key = $this->retaval($sql, 0);
        
        // Checking if the SQL function used is allowed
        if($this->all_funcs[$key] == 0)
        {
            if($this->silent === false)
            {
                trigger_error($key . ' is not allowed to be used in SQL', E_USER_ERROR);
            }
            return false;
        }
        
        // Initiating the result variable
        $bquery = null;
        
        // Looping through the SQL array and creating the query
        foreach($sql as $type => $query)
        {
            // Making sure we get the WHERE and build it appropriately
            if(is_array($query) && ($type == 'WHERE' || $type == 'where'))
            {
                $bquery .= $this->build_where($query);
            }
            elseif($type == 'WHERE' || $type == 'where')
            {
                $bquery .= ' ' . strtoupper($type) . ' ' . $query;
            }
            else
            {
                $bquery .= ' ' . strtoupper($type) . ' ' . $this->san_query($query);
            }
        }
        
        // Trimming the query from any white-spaces
        $bquery = trim($bquery);
        
        // Returning the built query
        return $bquery;
    }
    
    /*
     * private function rkey_exists( @array $needle, @array $haystack)
     *      @array $needle - The array that is the search query
     *      @array $haystack - The array that would be searched
     * 
     * Function that searches the keys of the $needle array
     *  for the values in the $haystack array.
     */
    
    private function rkey_exists($needle, $haystack)
    {
        // Checking if $needle or $haystack are arrays
        if(!is_array($needle) || !is_array($haystack))
        {
            if($this->silent === false)
            {
                trigger_error('The variable <strong>$needle</strong> or <strong>$haystack</strong> is not an array ', E_USER_ERROR);
            }
            return false;
        }
        
        // Setting the counter to be 0
        $i = 0;
        
        // Looping through the needle and setting the $stack to be the key
        foreach($needle as $stack => $dull)
        {
            // Checking if $stack exists in $haystack
            if(!in_array($stack, $haystack))
            {
                // $stack does not exist in $haystack... return false, then break.
                return false;
                break;
            }
            
            ++$i;
        }
        
        // All of the $stacks were in $haystack... return true
        return true;
    }
    
    /*
     * private function retaval( @array $var, @int $akey [, @boolean $array [, @boolean $value [, @boolean $numeric]]])
     *      @array $var - The array to retrieve the value/key from
     *      @integer $akey - The key to retrieve in numeric terms (1, 2...)
     *      @boolean $array - Determines if the result should come as an array with the key and the
                                value.
     *      @boolean $value - Set true if you want the value, set false if you want the key...
     *                          set to null if you want an array returned with the key and value
     *      @boolean $numeric - Set to true if you want the key to be numeric... otherwise set
     *                              to false if you want the key to be what it previously was
     * 
     * A function to retrieve a value/key from an array. Returns a string by default, or an
     *  array if you need the key to be numeric
     *  
     */
    
    private function retaval($var, $akey, $array = false,  $value = false, $numeric = false)
    {
        // Setting some variables
        $i = 0;
        $num = count($var);
        
        // Looping though the array and choosing the key/value that was asked for
        foreach($var as $key => $val)
        {
            // Setting the return value to the current key/value
            if($array == false)
            {
                $return = (($value == false) ? $key : $val);
            }
            
            // Checking if we need the result as an array or a string
            if($array != false)
            {
                // Setting the key to be whatever it needs to be
                $key = (($numeric == false) ? $key : 0);
                
                // Setting the return array to be whatever it was meant to be
                $return[$key] = (($value == false) ? ((is_null($value)) ? $value : $key) : $val);
            }
            
            // Making sure we stop when we have the correct key/value
            if($i == $akey)
            {
                break;
            }
            
            // Incrementing the counter
            ++$i;
        }
        
        //  Returning the return value if there is any
        return (($i > $num) ? false : $return);
    }
    
    /*
     * public function build_insert( @string $tbl_name, @array $values)
     *      @string $tbl_name = The table name into which we are going to insert the values
     *      @array $values = The values to insert into the tbl_name... has to be an associative
     *          array with column names as keys and their values set to their corresponding
     *          column names.
     * 
     * Creates an insert SQL statement
     */
    
    public function build_insert($tbl_name, $values)
    {
        // Starting the INSERT statement generation
        $sql = "INSERT INTO `$tbl_name` (";
        
        // Counting the number of values we've got here
        $num_vals = count($values);
        
        // Initiating the counter to keep track at which value we're at
        $counter = 1;
        
        // Looping through each value and getting it's column name
        foreach($values as $column_name => $null)
        {
            // Generating the column names part of the INSERT statement
            $sql .= "`{$column_name}`";
            
            // Making sure we put commas where appropriate
            if($counter !== $num_vals)
            {
                $sql .= ', ';


            }
            
            // Increasing the counter
            ++$counter;
        }
        
        // Continuing the INSERT statement with VALUES
        $sql .= ") VALUES (";
        
        // Resetting the counter
        $counter = 1;
        
        // Looping through the values to retrieve the column values
        foreach($values as $column_value)
        {
            // Making sure we keep the datatype of the values
            if(is_string($column_value))
            {
                $sql .= (string) "'{$this->san_query($column_value)}'";
            }
            else
            {
                $sql .= (($column_value === null) ? 'null' : (($column_value === false) ? 'false' : "'{$this->san_query($column_value)}'"));
            }
            
            // Making sure we put commas where appropriate
            if($counter !== $num_vals)
            {
                $sql .= ', ';
            }
            
            // Increasing the counter
            ++$counter;
        }
        
        // Finishing the INSERT statement generation
        $sql .= ")";
        
        // Returning the trimmed result
        return trim($sql);
    }
    
    /*
     * public function build_update( @string $tbl_name, @array $values [, @array $where])
     *      @string $tbl_name = The table name in which we are going to update the columns
     *      @array $values = The values to update in the tbl_name... has to be an associative
     *          array with column names as keys and their values set to their corresponding
     *          column names.
     *      @array $where = The location of the row you want to update
     * 
     * Creates an update SQL statement
     */

    public function build_update($tbl_name, $values, $where = null)
    {
        // Starting the UPDATE statement generation
        $sql = "UPDATE `{$tbl_name}` SET ";
        
        // Counting number of values we've got
        $num_vals = count($values);
        
        // Initiating the counter
        $counter = 1;
        
        // Looping through the values to create the UPDATE sequence
        foreach($values as $column_name => $column_value)
        {
            // The column name
            $sql .= "`{$column_name}` = ";
            
            // Keeping the column value's datatype
            if(is_string($column_value))
            {
                $sql .= "'{$column_value}'";
            }
            else
            {
                $sql .= (($column_value === null) ? 'null' : (($column_value === false) ? 'false' : $column_value));
            }
            
            // Making sure we put commas where appropriate
            if($counter !== $num_vals)
            {
                $sql .= ', ';
            }
            
            // Increasing the counter
            ++$counter;
        }
        
        // Checking if we need a WHERE statement
        if(!is_null($where))
        {
            // Generating the WHERE statement
            $sql .= ' ' . $this->build_where($where);
        }
        
        // Returning the trimmed result
        return trim($sql);
    }
    
    /*
     * public function build_where( array $w_fields [, boolean $beg_clause])
     *      @array $w_fields - Short for 'where fields' it would be an associative
     *          array holding the field names as keys and the field values as values
     *          associated to their respective array key (Or the field name in this case).
     *      @boolean $beg_clause - Wether to start the WHERE with 'WHERE '
     * 
     * A function to build a 'where' clause for SQL
     */
    
    public function build_where($w_fields, $beg_clause = true)
    {
        // Counting the number of WHERE fields we've got to work with
        $num_fields = count($w_fields);
        
        // Setting the count variable to 1
        $count = 1;
        
        // Starting the WHERE generation
        $where = (($beg_clause == true) ? ' WHERE ' : null);
        
        if(is_array($w_fields))
        {
            // Generating the WHERE clause
            foreach($w_fields as $column_name => $column_value)
            {
                // Setting the field names with their associated field values
                $where .= "{$column_name} = '{$this->san_query($column_value)}'";
                
                // Making sure we are putting the AND where it belongs
                if($count !== $num_fields)
                {
                    $where .= ' AND ';
                }
                
                // Increasing the count variable by 1 every loop
                ++$count;
            }
        }
        else
        {
            $where .= $this->san_query($w_fields);
        }
        
        // Returning a right trimmed WHERE clause
        return rtrim($where);
    }
    
    /*
     * public function build_remove( @string @table, @array|string $where )
     *      @string $table - The table where the row you want to delete resides in
     *      @array $where - The row you want to delete
     * 
     * Building the SQL to remove a row from the database table
     */
    
    public function build_remove($table, $where)
    {
        // Checking if we are authorized to delete rows
        if(!in_array('DELETE FROM', $this->sql_queries))
        {
            if($this->silent === false)
            {
                trigger_error("'DELETE FROM' is forbidden.", E_USER_ERROR);
            }
            return false;        
        }
        
        // Starting the DELETE FROM SQL
        $sql = "DELETE FROM `{$this->dbname}`.`$table`";
        
        // Checking if the $where is an array
        if(is_array($where))
        {
            $sql .= $this->build_where($where);
        }
        else
        {
            $sql .= $where;
        }
        
        // Returning the SQL
        return trim($sql);
    }
    
    /*
     * public function build_query( array $sql)
     *     @array $sql - the SQL array
     * 
     * A simple way to build a query using an array
     * Usage example...
     * 
     * $sql = array(
     *              '1' => '*',                     // SELECT
     *              '2' => '`database`.`table`',    // FROM
     *              '3' => "field = 'value'",       // WHERE
     *              '4' => 'value ASC'              // ORDER BY
     *              );
     *          - OR -
     * $sql = array('*','`database`.`table`', "field = 'value'", 'value ASC');
     * 
     * The SQL has to be in that order associated with
     * those keys for those SQL functions
     */
     
    public function build_query($sql)
    {
        // Checking if $sql was an array
        if(!is_array($sql))
        {
            if($this->silent === false)
            {
                trigger_error('The variable <strong>$sql</strong> is not an array ', E_USER_ERROR);
            }
            return false;
        }
        
        // Checking if $sql was a valid array
        if(!$this->num_keys($sql))
        {
            if($this->silent === false)
            {
                trigger_error('The array <strong>$sql</strong> is not a valid array ', E_USER_ERROR);
            }
            return false;
        }
        
        // Checking the WHERE property
        $where = ((isset($sql[2])) ? ' WHERE ' . trim($sql[2]) : null);
        
        // Checking the ORDER BY property
        $orderby = ((isset($sql[3])) ? ' ORDER BY ' . trim($sql[3]) : null);
        
        // The generated SQL ready to be prepared and returned
        $sql = "SELECT {$sql[0]} FROM {$sql[1]} {$where} {$orderby}";
        
        // Checking if the built query is of correct format
        if($this->valid_query($sql))
        {
            // Returning the built and prepared SQL query
            return trim($sql);
        }
        else
        {
            // There was an error in the SQL Generation, return false
            return false;
        }
    }
    
    /*
     * private function num_keys( array $key)
     *      @array $key - The array that would be checked upon
     * 
     * Checks if the array has numbered keys
     */
     
    private function num_keys($key)
    {
        // Checking if $keys was an array
        if(!is_array($key))
        {
            if($this->silent === false)
            {
                trigger_error('The variable <strong>$key</strong> is not an array ', E_USER_ERROR);
            }
            return false;
        }
       
        // Looping through $sql with $keys being the key value
        foreach($key as $keys => $trash)
        {
            // Checking if $key (the $sql's key) is numeric
            if(!is_numeric($keys))
            {
                // The $key was not numeric... return false then break
                return false;
                break;
            }
        }
        
        // The key was numeric... return true
        return true;
     }
     
     /*
      * public function get_last_sql( void )
      * 
      * Retrieves the last SQL
      */
      
    public function get_last_sql()
    {
        return $this->last_sql;
    }

    
    /*
     * public function get_last_result( void )
     * 
     * Retrieves the last RESULT resource
     */
    
    public function get_last_result()
    {
        return $this->last_result;
    }
    
    /*
     * public function transaction( string $trans )
     *        @string $trans = Determines whether you BEGIN, ROLLBACK or COMMIT a transaction
     * 
     * An all in one function to handle transactions
     */
    
    public function transaction($trans)
    {
        // Going through the possibilities of a transaction
        switch($trans)
        {
            case 'BEGIN' || 'begin':
                // Starting a transaction
                if(!@mysql_query("BEGIN", $this->mysql_link))
                {
                    return false;
                }
                break;
            case 'ROLLBACK' || 'rollback':
                // Undo-ing a transaction
                if(!@mysql_query("ROLLBACK", $this->mysql_link))
                {
                    return false;
                }
                break;
            case 'COMMIT' || 'commit':
                // Ending transaction
                if(!@mysql_query("COMMIT", $this->mysql_link))
                {
                    return false;
                }
                break;
            default:
        }
        
        // Returning true since the query succeeded
        return true;
    }
    
    /*
     * public function last_sql_data([ boolean $linked [, string  $title [, boolean $return]]])
     *      @boolean $linked - Determines if the generated HTML should be a whole page
     *      @string $title - The title of the SQL Result set
     *      @boolean $return - Determines if the page should be returned or echoed
     * 
     * Creates a TABLE like result using CSS div's using
     * the last SQL used in the class
     */
    
    public function last_sql_data($linked = true, $return = true, $title = 'SQL Results Data')
    {
        // Setting the starting time
        $time1 = microtime(true);
        
        // Retrieving the last sql
        $sql = (($this->valid_query($this->get_last_sql())) ? $this->get_last_sql() : null);
        
        // Checking if $sql is null
        if(is_null($sql))
        {
            if($this->silent === false)
            {
                trigger_error('The SQL for function last_sql_data() is invalid. Should be a valid SELECT query ', E_USER_ERROR);
            }
            return false;
        }
        
        // Creating a result resource
        $this->resource($sql);

        // Storing the CSS used for the class
        $this->data_css = "            h1
            {
                width: 100%;
                clear: both;
                margin: 0px;
                color: #ffffff;
                text-align: center;
                background-color: #333333;
            }
            
            h2
            {
                width: 100%;
                clear: both;
                color: #ffffff;
                text-align: center;
                background-color: #666666;
            }
            
            p {
                margin-top: 0px;
                margin-left: 10px;
            }
            
            .container
            {
                width: 100%;
                padding: 0px;
                margin-top: 30px;
                background-color: #eeeeee;
                border: 1px solid #000000;
            }
            
            .column_name
            {
                width: 20%;
                float: left;
                margin-right: -1px;
                border-top: 1px solid #000000;
            }
            
            .column_value
            {
                width: 80%;
                float: left;
                border-top: 1px solid #000000;
                border-left: 1px solid #000000;
            }";
        
        // Generating the first half of the page
        if($linked)
        {
            $page = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" 
   \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\" xml:lang=\"en\">
    <head>
        <title>{$title}</title>
        <style type=\"text/css\">
        <!--
{$this->data_css}
        //-->
        </style>
    </head>
    <body>
";
        }
        else
        {
            $page = null;
        }
        
        // Setting the result resource variable
        $result = ((isset($this->last_result)) ? $this->last_result : $this->resource($sql, true));
        
        if($this->num_rows($sql) > 0)
        {
            // Pointing the MySQL seek pointer to the first result
            mysql_data_seek($result, 0);
        }
        
        // The result number
        $p = 1;
        
        // Getting the result form the last SQL
        while($row = mysql_fetch_assoc($result))
        {
            // The result number page HTML
            $page .= "        <div class=\"container\">
            <h1>Result #{$p}</h1>\n";
            
            // Creating the resulting page
            foreach($row as $column_name => $column_value)
            {
                // Formatting the column value to what we need
                $column_value = nl2br($this->spchars($column_value));
                
                // Making sure that empty results are still generated
                if($column_value == false)
                {
                    $column_value = '&nbsp;';
                }
                
                // Generating the main portion of the data table
                $page .= "            <div class=\"column_name\">
                <p><strong>{$column_name}</strong></p>
            </div>
            <div class=\"column_value\">
                <p>{$column_value}</p>
            </div>\n
            <p style=\"clear: left; height: 0px; margin-bottom: 0px;\" />\n";
            }
            
            $page .= "            <p style=\"clear: both; height: 0px; margin-bottom: 0px;\" />
        </div>\n";
            
            // Incrementing the result number
            ++$p;
        }
        
        // Checking if we need to free the result resource
        if($this->free_result == true)
            $this->free_result();
        
        // Finishing off the generation of the page
        if($linked)
        {
            $page .= "
        <h2>Page generated in {TIME} seconds.</h2>
    </body>
</html>";
        }
        else
        {
            $page .= "        <h2>Page generated in {TIME} seconds.</h2>\n";
        }
        
        // Setting the ending time
        $time2 = microtime(true);
        
        // Determining how long it took to generate the page
        $time = $time2 - $time1;
        
        // Replacing the {TIME} to be the time it took the page to generate
        $page = str_replace('{TIME}', substr($time, 0, -10), $page);
        
        // Checking if the page should be returned or echoed
        if($return)
        {
            // Returning the generated page
            return $page;
        }
        else
        {
            // Printing the generated page on the screen
            echo $page;
        }
    }
    
    /*
     * public function valid_query( string $query)
     *      @string $query - The query to check if it's a valid SQL query
     * 
     * Checks if the given query is a valid SQL query (SELECT, UPDATE, INSERT, or DELETE)
     */
    
    public function valid_query($query)
    {
        // Checking if the query is a valid SELECT query
        if(preg_match("#(SELECT\s[\w\*\`\')\(\,\s]+\sFROM\s[\w`\']+)| (UPDATE\s[\w`\']+\sSET\s[\w\,\'\=\`\']++\sWHERE\s[\w`\']+)| (INSERT\sINTO\s[\d\w\'\`]+[\s\w\d\`\')\(\,]*\sVALUES\s\([\d\w\'\,\)\'\`]+)| (DELETE\sFROM\s[\d\w\'\=\'\`]+)#i", $query))
        {
            return true;
        }
        return false;
    }
    
    /*
     * public function spchars( string $text)
     *      @string $text - The text to convert some special characters
     * 
     * Function that converts certain HTML Characters.
     */
    
    public function spchars($text)
    {
        // Conversion map
        $conversion_map = array(
            '<' => '&lt;',
            '>' => '&gt;'
        );
        
        // Returning the converted string
        return trim(strtr($text, $conversion_map));
    }
    
    /*
     * public function key_as_value( string|array $array [, boolean $value_as_key)
     *      @string|array $array - The array whose keys should be put as values
     *      @boolean $value_as_key - Wether you want to keep the values as keys
     * 
     * Puts the keys as value in an array
     */
    
    public function key_as_value($array, $value_as_key = false)
    {
        // Initiating the return array
        $return = array();
        
        // Checking if the 'key' is an array
        if(is_array($array))
        {
            if($value_as_key === true)
            {
                // Going through the array and making the keys be the values and values to be keys
                foreach($array as $key => $value)
                {
                    $return[$value] = $key;
                }
            }
            else
            {
                // Going through the array and making the keys be the values
                foreach($array as $key => $value)
                {
                    $return[] = $key;
                }
            }
        }
        else
        {
            $return[] = $array;
        }
        
        // Returning the made array
        return $return;
    }
    
    /*
     * public function get_xml( string $what )
     *      @string $what - The variable to take from an XML File
     * 
     * Retrieves a variable from the global file
     */
    
    public function get_xml($what)
    {
        // Loading the global XML file
        $ret = (array) simplexml_load_file($this->var_file);
        
        // Returning the requested variable to the user
        return (string) $ret[$what];
    }
    
    /*
     * private function cache_result( string $sql, array $results )
     *      @string $sql - The actual SQL query
     *      @array $results - The results already retrieved from the SQL query
     * 
     * Caches the SQL query result
     */

    private function cache_result($sql, $results)
    {
        // Generating the file name for the cache
        $sql_file = $this->cache_dir . md5($sql) . '.cache';
        
        // Setting the results array
        $results = array('CONTENT' => $results, 'TIME_CACHE_SET' => $this->timer());
        
        // Creating the cache file
        if(touch($sql_file))
        {
            file_put_contents($sql_file, serialize($results));
            return true;
        }
        return false;
    }
    
    /*
     * private function retrieve_cache( string $sql)
     *      @string $sql - The actual SQL query
     * 
     *    Retrieves the content of a cached query
     */
    
    private function retrieve_cache($sql)
    {
        // First, we check if the cache file exists
        if(file_exists($this->cache_dir . md5($sql) . '.cache'))
        {
            // The name of the cached file
            $sql_file = $this->cache_dir . md5($sql) . '.cache';
            
            // The contents of the page
            $content = unserialize(file_get_contents($sql_file));
            
            // Returning the cached file if it hasn't expired yet
            if((time() - $content['TIME_CACHE_SET']) <= $this->cache_time_limit)
            {
                // Checking if the SQL file exists
                if(file_exists($sql_file))
                {
                    return $content['CONTENT'];
                }
            }
            else
            {
                // Cache has expired... delete it
                $this->remove_file($sql_file);
            }
        }
        
        // File doesn't exist or is expired, return false
        return false;
    }
    
    /*
     * private function remove_file( string $file_loc )
     *      @string $file_loc = The address to the file you want to remove
     * 
     * Tries to remove the desired file from it's location
     */
    
    private function remove_file($file_loc)
    {
        // First off, we check if the file exists
        if(file_exists($file_loc))
        {
            if(@unlink($file_loc))
            {
                return true;
            }
        }
        
        // There was a failure... return false
        return false;
    }
    
    /*
     * private function log_error( string $msg )
     *      @string $msg - The message to write into the log file
     * 
     * Writes errors in a log file.
     */
    
    private function log_error($msg)
    {
        // Getting the time of the error
        $time = date('[D M, d g:i:s A] ');
        
        // Accessing the log file
        if(is_writable($this->log_file))
        {
            // Getting the contents of the log file
            $contents = file_get_contents($this->log_file);
            
            // Adding our message at the end of the list
            $contents .= "
{$time}{$msg}";
            
            // Putting the contents back into the log file
            file_put_contents($this->log_file, $contents);
        }
    }
    
    /*
     * private function timer([int $time])
     *         @int $time - the time in seconds (Fill this in to stop it).
     * 
     * Time how long it takes your page to load
     */

    public function timer($time = null)
    {
        // Checking if we get any time here
        if($time !== null)
        {
            return time() - $time;
        }
        
        // Returning the starting time
        return time();
    }
    
    /*
     * function __destruct( void )
     * 
     * Magic function which closes the connection to MySQL as soon as the class is uninitiated
     */
    
    function __destruct()
    {
        $this->close();
    }
}
?>