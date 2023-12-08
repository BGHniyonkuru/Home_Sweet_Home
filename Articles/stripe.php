<?php

    require_once '../vendor/autoload.php';

    $publicApiKey = "pk_test_51OFx5kDnXf4Zm3Y352wOQD3z2oFMfv76FOO5bVJFKjW2jeHAy2jOPtg36Y7awSLvzwdlYFha11zdXApN64VxiuGV00NvGnP65n";
    $secretApiKey ="sk_test_51OFx5kDnXf4Zm3Y3Tq5LmOklxtf5YYtQ8rjjLBEDEJyzJMEgwLZVe9hghvwYCAWR09F1I1NWfijf4Vc5yuYqCQTj007uzLnmQB";

    \Stripe\Stripe::setApiKey($publicApiKey);
    $stripe = new \Stripe\StripeClient($secretApiKey);
?>