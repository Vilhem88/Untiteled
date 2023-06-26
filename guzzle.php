  public function certificate()
    {

        $base_uri = 'https://digital.inter-cert.net';
        $action = 'checkCertificate';
        $certificate_id = '551386';

        $params = [
            'action' => $action,
            'certificate_id' => $certificate_id
        ];
        try {

            $stack = HandlerStack::create();
            $maxRetry = 3;

            $stack->push($this->getRetryMiddleware($maxRetry));

            $client = new Client(
                [
                    'base_uri' => $base_uri,
                    'handler' => $stack
                ]
            );
            $response = $client->get('/wp-admin/admin-ajax.php?' . http_build_query($params));
            $response = json_decode($response->getBody()->getContents(), true);

            return view('certificate.show', compact('response'));
        } catch (Throwable $e) {
            report($e);

            return false;
        }
    }


    private function getRetryMiddleware($maxRetry)
    {
        return Middleware::retry(
            function (
                $retries,
                RequestInterface $request,
                ?ResponseInterface $response = null,
                ?\RuntimeException $exception = null
            ) use ($maxRetry) {
                if ($retries >= $maxRetry) {
                    return false;
                }

                if ($response && in_array($response->getStatusCode(), [249, 429, 503, 404])) {
                    echo 'Retrying [' . $retries . '], Status: ' . $response->getStatusCode() . '</br>';
                    return true;
                }

                if ($exception instanceof ConnectionException) {
                    echo 'Retrying [' . $retries . '], Connection Error </br> ';

                    return true;
                }

                return false;
            }
        );
    }

