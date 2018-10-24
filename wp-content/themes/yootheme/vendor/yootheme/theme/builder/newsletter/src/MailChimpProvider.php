<?php

namespace YOOtheme\Builder\Newsletter;

class MailChimpProvider extends Provider
{
    /**
     * @param string $apiKey
     * @throws \Exception
     */
    public function __construct($apiKey)
    {
        if (strpos($apiKey, '-') === false) {
            throw new \Exception("Invalid API key.");
        }

        list(, $dataCenter) = explode('-', $apiKey);

        $this->apiKey = $apiKey;
        $this->apiEndpoint = "https://{$dataCenter}.api.mailchimp.com/3.0";
    }

    /**
     * @param array $provider
     * @return array
     * @throws \Exception
     */
    public function lists($provider)
    {
        $clients = [];

        if ($result = $this->get('lists?count=100') and $result['success']) {
            $lists = array_map(function ($list) {
                return ['value' => $list['id'], 'text' => $list['name']];
            }, $result['data']['lists']);
        } else {
            throw new \Exception($result['data']);
        }

        return compact('lists', 'clients');
    }

    /**
     * @param array $email
     * @param array $data
     * @param array $provider
     * @return bool
     * @throws \Exception
     */
    public function subscribe($email, $data, $provider)
    {
        if (isset($provider['list_id']) && $provider['list_id']) {

            $mergeFields = [];
            if (isset($data['first_name'])) {
                $mergeFields['FNAME'] = $data['first_name'];
            }
            if (isset($data['last_name'])) {
                $mergeFields['LNAME'] = $data['last_name'];
            }

            // Deprecated
            if (!isset($provider['double_optin'])) {
                $provider['double_optin'] = true;
            }

            $result = $this->post("lists/{$provider['list_id']}/members", [
                'email_address' => $email,
                'status' => $provider['double_optin'] ? 'pending' : 'subscribed',
                'merge_fields' => $mergeFields,
            ]);

            if (!$result['success']) {
                if (stripos($result['data'], 'already a list member') !== false) {
                    throw new \Exception(htmlspecialchars($email) . ' is already a list member.');
                } else {
                    throw new \Exception($result['data']);
                }
            }

            return true;
        } else {
            throw new \Exception('No list selected.');
        }
    }

    /**
     * Insert headers
     * @return array
     */
    protected function getHeaders()
    {
        return [
            'Authorization' => 'apikey ' . $this->apiKey
        ];
    }
}