<?php
    class Database extends PDO {
        public function __construct() {
            parent::__construct(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS);
        }

        public function sql($sql, $where='', $sort='', $limit=''){
            $sql .= $where.$sort.$limit;
            $sth = $this->prepare($sql);
            $sth->execute();
            $res = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        public function select($tbl, $fields, $params=array()){
            $where = '';
            $prepare = array();            
            if(!empty($params)){
                $where = "WHERE ";
                $delim = '';
                foreach ($params as $key => $val) {
                    $where .= $delim . '`' . $key . '` = :' . $key;
                    $prepare[':'.$key] = $val;
                    $delim = ' AND ';
                }
            }
            $sql = "SELECT {$fields} FROM {$tbl} {$where}";
            $sth = $this->prepare($sql);
            $sth->execute($prepare);
            $res = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        public function insert($tbl, $params=array()){
            if(empty($params)) return false;
            $fields = array();
            $values = array();
            $prepare = array();
            foreach ($params as $key => $val) {
                $fields[] = '`' . $key . '`';
                $values[] = ':'.$key;
                $val = strip_tags($val);
                $val = htmlentities($val, ENT_QUOTES, "UTF-8");
                $val = htmlspecialchars($val, ENT_QUOTES);
                $prepare[":{$key}"] = $val;
            }
            $fields = implode(',', $fields);
            $values = implode(',', $values);
            $sql="INSERT INTO `{$tbl}`({$fields}) VALUES ({$values})";
            $sth = $this->prepare($sql);            
            $result= $sth->execute($prepare);
            return $result;
        }

        public function update($tbl, $params=array(), $where_arr=array()){
            if(empty($params)) return false;
            $sets = '';
            $where = '';
            $prepare = array();
            $delim = '';
            foreach ($params as $key => $val) {
                $sets .= $delim . '`' . $key . '` = :' . $key;
                $val = strip_tags($val);
                $val = htmlentities($val, ENT_QUOTES, "UTF-8");
                $val = htmlspecialchars($val, ENT_QUOTES);
                $prepare[":{$key}"] = $val;
                $delim = ', ';
            }
            $delim = '';
            if(!empty($where_arr)){
                $where = ' WHERE ';
                foreach ($where_arr as $key => $val) {
                    $where .= $delim . '`' . $key . '` = :' . $key;
                    $prepare[":{$key}"] = $val;
                    $delim = ' AND ';
                }
            }
            $sql="UPDATE {$tbl} SET {$sets}{$where}";
            $sth = $this->prepare($sql);            
            $result= $sth->execute($prepare);
            return $result;
        }

        public function delete($tbl, $params=array()){
            if(empty($params)) return false;
            $where = '';
            $delim = '';
            foreach ($params as $key => $val) {
                $where .= $delim . '`' . $key . '` = :' . $key;
                $prepare[":{$key}"] = $val;
                $delim = ' AND ';
            }
            $sql = "DELETE FROM {$tbl} WHERE {$where}";
            $sth = $this->prepare($sql);            
            $result= $sth->execute($prepare);
            return $result;
        }
    }
?>