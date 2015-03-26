<?php

class CHtmlTable {

    private $db = null;
  /**
   * Constructor creating a PDO object connecting to a choosen database.
   */
    public function __construct($db) {
        $this->db = $db;
    }
    
    
    /**
    * Use the current querystring as base, modify it according to $options and return the modified query string.
    *
    * @param array $options to set/change.
    * @param string $prepend this to the resulting query string
    * @return string with an updated query string.
    */
    public function getQueryString($options, $prepend='?') {
        // parse query string into array
        $query = array();
        parse_str($_SERVER['QUERY_STRING'], $query);
        
        // Modify the existing query string with new options
        $query = array_merge($query, $options);
        
        // Return the modified querystring
        return $prepend . http_build_query($query);
    }       
    
    
    /**
    * Create links for hits per page.
    *
    * @param array $hits a list of hits-options to display.
    * @return string as a link to this page.
    */
    public function getHitsPerPage($hits) {
        $nav = "Träffar per sida: ";
        foreach($hits AS $val) {
            $nav .= "<a href='" . $this->getQueryString(array('hits' => $val)) . "'>$val</a> ";
        }
        return $nav;
    }
    
    
    /**
    * Calculates the number of pages to dislpay given the table and number of rows per page
    */
    private function getNrOfPages($table, $results_per_page) {
        //Caluclate the number of pages with the currently selected number of results per page.
        $sql = "SELECT COUNT(id) AS rows FROM {$table}";
        $res = $this->db->ExecuteSelectQueryAndFetchAll($sql);
        $nr_pages = ceil($res[0]->rows / $results_per_page);
        return $nr_pages;
    }
    
    
    /**
    * Create navigation among pages.
    */
    public function getPageNavigation($hits, $page, $nr_hits, $min=1) {
        $max = ceil($nr_hits / $hits);
        $nav  = "<a href='" . $this->getQueryString(array('page' => $min)) . "'>&lt;&lt;</a> ";
        $nav .= "<a href='" . $this->getQueryString(array('page' => ($page > $min ? $page - 1 : $min) )) . "'>&lt;</a> ";
        
        for($i=$min; $i<=$max; $i++) {
            $nav .= "<a href='" . $this->getQueryString(array('page' => $i)) . "'>$i</a> ";
        }
        
        $nav .= "<a href='" . $this->getQueryString(array('page' => ($page < $max ? $page + 1 : $max) )) . "'>&gt;</a> ";
        $nav .= "<a href='" . $this->getQueryString(array('page' => $max)) . "'>&gt;&gt;</a> ";
        return $nav;
    }
    
    
    /**
    * Function to create links for sorting
    *
    * @param string $column the name of the database column to sort by
    * @return string with links to order by column.
    */
    public function orderby($column) {
        $nav  = "<a class='arrow' href='" . $this->getQueryString(array('orderby'=>$column, 'order'=>'asc')) . "'>&darr;</a>";
        $nav .= "<a class='arrow' href='" . $this->getQueryString(array('orderby'=>$column, 'order'=>'desc')) . "'>&uarr;</a>";
        return "<span class='orderby'>" . $nav . "</span>";
    }
    
    
    /**
    * Function to generate a html table from a database object
    * @param string $res A database object
    * @param string $columns an array with information about the columns to use from the database objeckt 'dbcolumnname1'=>array('Display Name', true), 'dbcolumnname2'=>array("Display Name", false) ..
    * true makes the column sortable, false not sortable
    */
    public function buildTable($res, $columns) {
        $tr = "<tr>";
        // Build the table head
        foreach($columns as $col => $value) {
            $tr .= "<th>{$value[0]}";
            if ($value[1]) {
                $tr .=  $this->orderby($col);
            }
            $tr .=  "</th>";
        }
        //Add the rows of data
        foreach($res AS $key => $val) {
            $row = get_object_vars ( $val );
            $tr .= "<tr>";
            foreach($columns as $col => $value) {
                if (strpos($row[$col],'jpg') !== false ) {
                    $substring=substr($row[$col], 11);
                    $tr .= "<td></td>";
                } 
                elseif(strpos($col,'title') !== false ){
                    $tr .= "<td></td>";
                }
                elseif(strpos($col, 'genre') !== false ){
                    $explode=explode(',', $row[$col]);
                    $tr .="<td>";
                    foreach ($explode as $explodes){
                    $tr .= "";}
                    $tr .= "";
                    //if (array_key_exists($genres[1], $genres)){
                    //$tr .="<a href='#'>, {$genres[1]}</a>";}
                    }    
                else {
                    $tr .= "<td></td>";
                }
            }
            $tr .= "</tr>\n";
        }
        return $tr;
    }
}