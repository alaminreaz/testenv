<?php
    // Show all PHP error messages
    error_reporting(E_ALL);

    function dbQuery($query, $show_errors=true, $all_results=true, $show_output=true) {
        // Connect to the IBM DB2 database management system
        $link = db2_pconnect("testdb", "root", "testpass");
        if (!$link) {
            die(db2_conn_errormsg());
        }

        // Print results in HTML
        print "<html><body>\n";

        // Print SQL query to test sqlmap '--string' command line option
        //print "<b>SQL query:</b> " . $query . "<br>\n";

        // Perform SQL injection affected query
        $stmt = db2_prepare($link, $query);
        $result = db2_execute($stmt);

        if (!$result) {
            if ($show_errors)
                print "<b>SQL error:</b> ". db2_stmt_errormsg($stmt) . "<br>\n";
            exit(1);
        }

        if (!$show_output)
            exit(1);

        print "<b>SQL results:</b>\n";
        print "<table border=\"1\">\n";

        while ($line = db2_fetch_assoc($result)) {
            print "<tr>";
            foreach ($line as $col_value) {
                print "<td>" . $col_value . "</td>";
            }
            print "</tr>\n";
            if (!$all_results)
                break;
        }

        print "</table>\n";
        print "</body></html>";
    }
?>