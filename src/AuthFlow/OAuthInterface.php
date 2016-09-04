<?php

namespace ContactsGrabber\AuthFlow;

interface OAuthInterface
{
    public function getAuthorizationRequestUrl($clientId = null, $redirectUrl = null, $scope = null, $responseType = null) : string;
    public function setAuthorizationGrantCode($code);
    public function getAuthorizationGrantCode();

    public function fetchAccessToken($code = null, $clientId = null, $clientSecret = null, $redirectUrl = null);
    public function setAccessToken($accessToken);
    public function getAccessToken();
}