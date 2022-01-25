<?php

namespace Dw3nt\ForeUpSdk\Objects;

class Customer extends AbstractObject
{
    private $customerFields = [
        'username', 'company_name', 'taxable', 'discount', 'opt_out_email', 'opt_out_text', 'date_created'
    ];
    private $contactFields = [
        'id', 'first_name', 'last_name', 'phone_number', 'cell_phone_number', 'email', 'birthday', 'address_1', 'address_2', 'city', 'state', 'zip', 'country', 'handicap_account_number', 'handicap_score', 'comments'
    ];

    public function create($courseId, $customerData, $contactData) 
    {
        $customerData = $this->sanitizeCustomerData($customerData);
        $contactData = $this->sanitizeContactData($contactData);

        $customerData['contact_info'] = $contactData;

        $url = "courses/{$courseId}/customers";
        $response = $this->client->request('POST', $url, [
            'form_params' => [
                'data' => [
                    'type' => 'customer',
                    'attributes' => $customerData
                ]
            ]
        ]);
        return $response;
    }

    private function sanitizeCustomerData($customerData) 
    {
        return $this->sanitizeDataByKeys($this->customerFields, $customerData);
    }

    private function sanitizeContactData($contactData)
    {
        return $this->sanitizeDataByKeys($this->contactFields, $contactData);
    }

    private function sanitizeDataByKeys($keys, $data)
    {
        return array_filter($data, function($key) use ($keys) {
            return in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }
}