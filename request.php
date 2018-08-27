
<?php

class Json {

    public $contract;
    public $obj;
    public $obj_id;

    public function __construct($contract,  $checkboxRequest = "") {
        $this->contract = $contract;
       
        $this->checkboxRequest = $checkboxRequest;
    }

    public function returnJson() {
        $connection = mysqli_connect('localhost', 'root', '', 'wnet');
        mysqli_set_charset($connection, 'utf8');
        if (mysqli_connect_errno())
            echo mysqli_connect_error();
        $query = '(SELECT *  FROM obj_contracts INNER JOIN id_customers ON obj_cont'
                . 'racts.id_customer = id_customers.id_customer INNER JOIN obj_servi'
                . 'ces ON obj_services.id_contract = obj_contracts.id_contract WHERE (obj_contracts.number='
                . "'" . $this->contract . "'" . ' OR obj_contracts.id_contract='. "'" . $this->contract . "') " . $this->checkboxRequest . " );";

        $result = mysqli_query($connection, $query);


        $rows = array();
        while ($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        if (count($rows) == 0)
            return false;
        else
            print json_encode($rows);
    }

}

if (isset($_POST[contractNumber])) {
     $checkboxRequest = " AND (obj_services.status=" . "'" . $_POST[work] . "'" . " OR obj_services.status=" . "'" . $_POST[connecting] . "'" . " OR obj_services.status=" . "'" . $_POST[disconnected] . "')";
    $returnContract = new Json($_POST[contractNumber],  $checkboxRequest);
    $returnContract->returnJson();
} 

?>
  
