<?php
    namespace App\Delegate;
    use App\DAO\ShopDao;
    use App\Utils\Response;

    class UserDelegate{
        private $shop;
        private $response;

        public function __construct(){
            $this->shop     = new ShopDao();
            $this->response = new Response();
        }

        public function registerShop($user,$newShop){
            $token =$user->getToken();
            $token = explode(" ",$token)[1];
            $user->setToken($token);
            
            $this->shop->setName($newShop->getName());
            $this->shop->setOwnerId($newShop->getOwnerId());
            $this->shop->setDescription($newShop->getDescription());
            $this->shop->setPhone($newShop->getPhone());
            $this->shop->setOwnerId($newShop->getOwnerId());
            $this->shop->setBlock($newShop->getBlock());
            $this->shop->setStreet($newShop->getStreet());
            $this->shop->setArea($newShop->getArea());
            $this->shop->setPincode($newShop->getPincode());
            $response=$this->shop->AddShop($user);
            return $response;
        }

        public function fetch($owner_id){
            $this->shop->setOwnerId($owner_id);
            $response = $this->shop->fetchshops();
            $this->response->setResponse($response['response']);
            $this->response->setMessage($response['message']);
            $this->response->setData($response['data']);
            return $this->response->getResponse();
        }

        public function deleteShop($user,$shopId){
            $token = $user->getToken();
            $token = explode(" ",$token)[1];
            $user->setToken($token);
            $this->shop->setOwnerId($user->getUserId());
            $this->shop->setShopId($shopId);
            $response = $this->shop->deleteUserShop($user);
            $this->response->setResponse($response['response']);
            $this->response->setMessage($response['message']);
            $this->response->setData($response['data']);
            return $this->response->getResponse();

        }
        
    }
?>