<?php

abstract class DataBase {

    private $db_host = "localhost";
    private $db_user = "root";
    private $db_pass = "";
    private $db_name = "foodmart";
    private $con = false;
    public $rowNumber = 0;

    /**
     *
     * Connect() is used for database connection with MySql DataBase 
     * Date : 04- 11-2012 
     * Author : Md. Mizanur Rahman 
     * @return boolean 
     */
    protected function connect() {
        if (!$this->con) {
            $myconn = @mysql_connect($this->db_host, $this->db_user, $this->db_pass);
            if ($myconn) {
                $seldb = @mysql_select_db($this->db_name, $myconn);
                if ($seldb) {
                    $this->con = true;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     *
     * disconnect() is used to Disconnect database  with MySql DataBase 
     * Date : 04- 11-2012 
     * Author : Md. Mizanur Rahman 
     * @return boolean 
     */
    protected function disconnect() {
        if ($this->con) {
            if (@mysql_close()) {
                $this->con = false;
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     *
     * select() is used to select database  from table 
     * This function Universal for All Tab
     * Date : 04- 11-2012 
     * Author : Md. Mizanur Rahman 
     * @return boolean 
     */

    /**
     * select() is used to select Data from table in  database 
     * 
     * Date : 04- 11-2012 
     * Author : Md. Mizanur Rahman
     * 
     * 
     * @param type $table
     * @param type $rows
     * @param type $where
     * @param type $order
     * @return boolean 
     */
    protected function select($table, $rows = '*', $where = null, $order = null) {
        $this->result = "";
        $q = 'SELECT ' . $rows . ' FROM ' . $table;
        if ($where != null)
            $q .= ' WHERE ' . $where;
        if ($order != null)
            $q .= ' ORDER BY ' . $order;
        if ($this->tableExists($table)) {
            $query = @mysql_query($q);
			
            if ($query) {
                $this->numResults = mysql_num_rows($query);
                if ($this->numResults != 0) {
                    for ($i = 0; $i < $this->numResults; $i++) {
                        $r = mysql_fetch_array($query);
                        $key = array_keys($r);
                        for ($x = 0; $x < count($key); $x++) {
                            // Sanitizes keys so only alphavalues are allowed  
                            if (!is_int($key[$x])) {
                                $this->rowNumber = mysql_num_rows($query);
                                if (mysql_num_rows($query) > 1)
                                    $this->result[$i][$key[$x]] = $r[$key[$x]];
                                else if (mysql_num_rows($query) < 1)
                                    $this->result = null;
                                else
                                    $this->result[$key[$x]] = $r[$key[$x]];
                            }
                        }
                    }
                
				    return $this->result;
                }else {
                 return null;   
                }
            }
            else {
                return null;
            }
        }
        else
            return null;
    }

    /**
     * select() is used to Insert Data in table in  database 
     * 
     * Date : 01- 28-2012 
     * Author : Md. Mizanur Rahman
     * 
     * 
     * @param type $table
     * @param type $values
     * @param type $rows
     * @return boolean 
     */
    protected function insert($table, $values, $rows = null) {
        if ($this->tableExists($table)) {
            $insert = 'INSERT INTO ' . $table;
            if ($rows != null) {
                $insert .= ' (' . $rows . ')';
            }

            if ($values != null)
                for ($i = 0; $i < count($values); $i++) {
                    if (is_string($values[$i]))
                        $values[$i] = "'" . $values[$i] . "'";
                }

            //   if($values != null)
            $values = implode(',', $values);
            $insert .= ' VALUES (' . $values . ')';
		
            $ins = @mysql_query($insert);
            return $id = mysql_insert_id();
            /*
              if($id)
              {
              return true;
              }
              else
              {
              return false;
              } */
        }
    }

    /**
     * select() is used to Dalete Data from table in  database 
     * 
     * Date : 04- 11-2012 
     * Author : Md. Mizanur Rahman
     * 
     * 
     * 
     * @param type $table
     * @param type $where
     * @return boolean 
     */
    protected function delete($table, $where = null) {
        if ($this->tableExists($table)) {
            if ($where == null) {
                $delete = 'DELETE ' . $table;
            } else {
                $delete = 'DELETE FROM ' . $table . ' WHERE ' . $where;
            }
            $del = @mysql_query($delete);

            if ($del) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * select() is used to Update Data in table in  database 
     * 
     * Date : 04- 11-2012 
     * Author : Md. Mizanur Rahman    
     *
     * @param type $table
     * @param type $rows
     * @param type $where
     * @return boolean 
     */
    protected function update($table, $rows, $where) {
        if ($this->tableExists($table)) {
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
            for ($i = 0; $i < count($where); $i++) {
                if ($i % 2 != 0) {
                    if (is_string($where[$i])) {
                        // if (($i + 1) != null)
                        //$where[$i] = "'" . $where[$i] . "' AND ";
                        //else
                        $where[$i] = "'" . $where[$i] . "'";
                    }
                }
            }
            $where = implode('=', $where);

            $update = 'UPDATE ' . $table . ' SET ';
            $keys = array_keys($rows);
            for ($i = 0; $i < count($rows); $i++) {
                if (is_string($rows[$keys[$i]])) {
                    $update .= $keys[$i] . "='" . $rows[$keys[$i]] . "'";
                } else {
                    $update .= $keys[$i] . '=' . $rows[$keys[$i]];
                }

                // Parse to add commas
                if ($i != count($rows) - 1) {
                    $update .= ',';
                }
            }
            $update .= ' WHERE ' . $where;
			
            $query = @mysql_query($update);

            if ($query) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private $result = array();

    /**
     * To Check Table in Database
     * @param type $table
     * @return boolean 
     */
    protected function tableExists($table) {
        // $ss ='SHOW TABLES FROM '.$this->db_name.' LIKE "'.$table.'"';

        $tablesInDb = @mysql_query('SHOW TABLES FROM ' . $this->db_name . " LIKE '" . $table . "'");
        if ($tablesInDb) {
            if (mysql_num_rows($tablesInDb) == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * select() is used to select Data from table in  database 
     * 
     * Date : 04- 11-2012 
     * Author : Md. Mizanur Rahman
     * 
     * 
     * @param type $table
     * @param type $rows
     * @param type $where
     * @param type $order
     * @return boolean 
     */
    protected function selectbyquery($q) {

        $query = @mysql_query($q);
        if ($query) {
            $this->numResults = mysql_num_rows($query);
            for ($i = 0; $i < $this->numResults; $i++) {
                $r = mysql_fetch_array($query);
                $key = array_keys($r);
                for ($x = 0; $x < count($key); $x++) {
                    // Sanitizes keys so only alphavalues are allowed  
                    if (!is_int($key[$x])) {
                        $this->rowNumber = mysql_num_rows($query);
                        if (mysql_num_rows($query) > 1)
                            $this->result[$i][$key[$x]] = $r[$key[$x]];
                        else if (mysql_num_rows($query) < 1)
                            $this->result = null;
                        else
                            $this->result[$key[$x]] = $r[$key[$x]];
                    }
                }
            }
            return $this->result;
        }
        else {
            return null;
        }
    }

    public function SelectMaxID($rows, $table) {
        $q = 'SELECT Max(' . $rows . ') FROM ' . $table;

        if ($this->tableExists($table)) {
            $query = @mysql_query($q);
            $r = mysql_fetch_array($query);
            return $r[0];
        }
        else
            return null;
    }
	
	

}

?>