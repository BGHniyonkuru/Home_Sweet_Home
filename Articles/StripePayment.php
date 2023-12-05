<?php
    require_once "vendor:autoload.php";

    use Stripe\Stripe;
    use Stripe\Checkout\Session;

    class StripePayment{
        private $clientSecret;
    }

    public function __construct(readonly private $clientSecret){
        $this->clientSecret= $clientSecret;
        Stripe:: setApikey($this->clientSecret);
        Stripe:: setApiVersion("2022-10-16");
    }
    public function start($_SESSION['panier']){
        $cartId= $cart->getId();
        $session = Session:: create([
            "line_items"=>[

            ]
            "mode"=> "payment",
            "success_url"=>"http://localhost/Home_Sweet_Home/success.php",
            "cancel_url"=>"http://localhost/Home_Sweet_Home/",
            "billing_address_collection"=>"required",
            "shipping_adress_collection"=>[
                "allowed_countries"=>["FR"]
            ],
            "metadata"=>[
                "cart_id"=>$cartId,
            ]
            ]);

            $cart-> setSessionId($session->id);
            header("HTTP/1.1 303 See Other");
            header("Location:". $session->url);
    }
?>