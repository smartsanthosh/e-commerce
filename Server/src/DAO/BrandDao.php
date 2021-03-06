<?php
    namespace App\DAO;
    use App\Utils\SqlConn;
    use App\Models\Brand;

    class BrandDao extends Brand 
    {
        public $db_connect;
	
        public function __construct(){
            $this->db_connect = new SqlConn();		
        }

        public function addBrand()
        {
            $object = array(
                "tablename" => Brand::TABLENAME,
                "fields"    => array(Brand::BRANDNAME
                                ),
                "values"    => array( $this->getBrandName()
                                ),
                "duplicateFlag" => 1,
                "getlastId" => Brand::BRANDID

            );
           
            $response = $this->db_connect->addTableData($object);
            return $response;
        }

        public function getAllBrandNames()
        {
            $object = array(
                "tablename" => Brand::TABLENAME,
                "fields"    => array(Brand::BRANDNAME
                                )
            );
            $response = $this->db_connect->query($object,0);
            return $response;
        }

        public function removeBrand(){
            $object = array(
                "tablename" => Brand::TABLENAME,
                "where"     => array(
                  "simple"  => array(
                      Brand::BRANDNAME => $this->getBrandName()
                  )
                ),
                
            );
            $response = $this->db_connect->deleteRecord($object);
            return $response;
        }

 
    }
    
?>