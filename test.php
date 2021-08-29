<?php
public function orderConfirmation($order)
{
    $tax = $this->getTax($order);
    $taxKey = array_keys($tax);
    $parameters = [
        "email" => $order->getCustomerEmail(),
        "ctx" => [
            "Totals_Total_before_tax"=> $this->getPriceBeforeTax($order),
//                "Totals_Tax_Label1"=> "TPS",
//                "Totals_Tax_Label2"=> "TVQ",
//                "Totals_Tax1_Amt"=> 1234.12,
//                "Totals_Tax2_Amt"=> 1234.12,
            "Totals_Shipping_cost"=> $order->getShippingAmount(),
            $taxKey[0] => $tax[$taxKey[0]],
            $taxKey[1] => $tax[$taxKey[1]],
//                "Store_pick_up"=> "100",
            "Shipping_Method"=> $order->getShippingMethod(),
            "Shipping_Details_Name_Street"=> $order->getShippingAddress()->getData('street'),
            "Shipping_Details_Name_Region" => $order->getShippingAddress()->getRegion(),
            "Shipping_Details_Name_Postcode_County" => $order->getShippingAddress()->getCountryId(),
            "Shipping_Details_Name_Postcode" => $order->getShippingAddress()->getPostcode(),
            "Shipping_Details_Name_Phone"=> $order->getShippingAddress()->getName(),
            "Shipping_Details_Name_City" => $order->getShippingAddress()->getCity(),
            "Shipping_Details_Name" => $order->getShippingAddress()->getName(),
//                "Payment_number"=>$order->getPayment()->getData('additional_information')['order_tra_id'],
            "Payment_method"=> $order->getPayment()->getMethodInstance()->getTitle(),  // Credit card
            "Order_Number"=> $order->getIncrementId(),
            "Order_Date"=> date('Y-m-d', strtotime($order->getCreatedAt())), // 2021-05-28
            "Grand_total"=> $order->getGrandTotal(),
//                "Gift_Card"=> null,
//                "Client_Type"=> null,
            "Client_Last_Name" => $order->getCustomerLastname(),
            "Client_First_Name" => $order->getCustomerFirstname(),
            "Billing_Street"=> $order->getBillingAddress()->getData('street'),
            "Billing_Region"=> $order->getBillingAddress()->getRegion(),
            "Billing_Postcode"=> $order->getBillingAddress()->getPostcode(),
            "Billing_Name"=> $order->getBillingAddress()->getName(),
            "Billing_Country"=> $order->getBillingAddress()->getCountryId(),
            "Billing_City"=> $order->getBillingAddress()->getCity(),
            "Order_items" => $this->getOrderItems($order)
        ],
    ];

    return $parameters;
}



