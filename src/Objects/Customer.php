<?php

namespace Dw3nt\ForeUpSdk\Objects;

class Customer extends AbstractObject
{
    private $userFields = [
        'username', 'company_name', 'taxable', 'discount', 'opt_out_email', 'opt_out_text', 'date_created'
    ];
    private $contactInfoFields = [
        'id', 'first_name', 'last_name', 'phone_number', 'cell_phone_number', 'email', 'birthday', 'address_1', 'address_2', 'city', 'state', 'zip', 'country', 'handicap_account_number', 'handicap_score', 'comments'
    ];

    public function create($courseId, $userData, $contactData) 
    {
        $userData = $this->sanitizeUserData($userData);
        $contactData = $this->sanitizeContactData($contactData);

        $userData['contact_info'] = $contactData;

        $url = "courses/{$courseId}/customers";
        $response = $this->client->request('POST', $url, [
            'form_params' => [
                'data' => [
                    'type' => 'customer',
                    'attributes' => $userData
                ]
            ]
        ]);
        return $response;
    }

    private function sanitizeUserData($userData) 
    {
        return $this->sanitizeDataByKeys($this->userFields, $userData);
    }

    private function sanitizeContactData($contactData)
    {
        return $this->sanitizeDataByKeys($this->contactInfoFields, $contactData);
    }

    private function sanitizeDataByKeys($keys, $data)
    {
        return array_filter($data, function($key) use ($keys) {
            return in_array($key, $keys);
        }, ARRAY_FILTER_USE_KEY);
    }
}