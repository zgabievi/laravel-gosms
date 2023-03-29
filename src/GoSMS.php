<?php

namespace Zorb\GoSMS;

use Illuminate\Support\Facades\Log;

class GoSMS
{
    /**
     * Send message to recipient
     *
     * @param string $mobile
     * @param string $message
     * @param string|null $from
     * @param boolean $urgent
     * @return mixed
     */
    public function send(string $mobile, string $message, string $from = null, $urgent = false)
    {
        $from = $from ?: config('gosms.brand_name');

        return $this->request([
            'api_key' => config('gosms.api_key'),
            'to' => $mobile,
            'text' => $message,
            'from' => $from,
            'urgent' => $urgent
        ], 'sendsms');
    }

    /**
     * Send post request of requested method
     *
     * @param array $params
     * @param string $method
     * @return mixed
     */
    protected function request(array $params, string $method)
    {
        $query_params = http_build_query($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, config('gosms.api_url') . '/' . $method);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $query_params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        if (config('gosms.debug')) {
            Log::debug($result);
            Log::debug($info);
        }

        curl_close($ch);

        return json_decode($result);
    }

    /**
     * Check message status by message id
     *
     * @param int $message_id
     * @return mixed
     */
    public function status(int $message_id)
    {
        return $this->request([
            'api_key' => config('gosms.api_key'),
            'messageId' => $message_id,
        ], 'checksms');
    }

    /**
     * Send OTP message to recipient
     *
     * @param string $mobile
     * @return mixed
     */
    public function sendOTP(string $mobile)
    {
        return $this->request([
            'api_key' => config('gosms.api_key'),
            'phone' => $mobile,
        ], 'otp/send');
    }

    /**
     * Verify OTP code
     *
     * @param string $mobile
     * @param string $hash
     * @param string $code
     * @return mixed
     */
    public function verifyOTP(string $mobile, string $hash, string $code)
    {
        return $this->request([
            'api_key' => config('gosms.api_key'),
            'phone' => $mobile,
            'hash' => $hash,
            'code' => $code,
        ], 'otp/verify');
    }

    /**
     * Check SMS balance
     *
     * @return mixed
     */
    public function balance()
    {
        return $this->request([
            'api_key' => config('gosms.api_key'),
        ], 'sms-balance');
    }
    }

    /**
     * Request Sender name
     *
     * @param string $name
     * @return mixed
     */
    public function senderRequest($name)
    {
        return $this->request([
            'api_key' => config('gosms.api_key'),
            'name' => $name
        ], 'sender');
    }
}
