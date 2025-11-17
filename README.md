
# WebAccess PHP Client

A lightweight PHP client for interacting with the **Web Access REST API**, which exposes programmatic access to AccessLogParser models and services.
This client simplifies authenticated requests and provides convenient helpers for common Web Access endpoints.

## Features

* Easy API initialization with an existing OAuth2 access token
* Simple helper methods for common resources:

  * Hosts
  * Requests
* Automatic error detection with exceptions on API-reported errors
* Small footprint, minimal dependencies (pure cURL)

---

## Installation

Because this is a simple class, you can include it directly in your project:

```
/path/to/WebAccessClient.php
```

Or place it in your autoloader.

---

## Requirements

* PHP **7.4+**
* cURL extension enabled
* A valid **OAuth2 access token** issued for the audience
  `https://webaccess.outlawdesigns.io`

---

## Obtaining an Access Token

The Web Access REST API is protected and requires clients to authenticate using OAuth2 client credentials.

Example token request:

```bash
curl --location --request POST 'https://auth.outlawdesigns.io/oauth2/token' \
  --form 'grant_type="client_credentials"' \
  --form 'client_id="$CLIENT_ID"' \
  --form 'client_secret="$CLIENT_SECRET"' \
  --form 'audience="https://webaccess.outlawdesigns.io"' \
  --form 'scope="openid, profile, email, roles"'
```

Use the returned `access_token` when constructing `WebAccessClient`.

---

## Usage

### Initializing the Client

```php
require_once 'WebAccessClient.php';

$client = new WebAccessClient(
    'https://webaccess.outlawdesigns.io',
    $accessToken
);
```

---

## API Methods

### `apiGet($uri)`

Low-level request wrapper for direct endpoint access.

Returns decoded JSON or throws an exception if the API returns an error.

---

### Host Methods

#### `getHost($id = null)`

Fetch a host by ID or fetch all hosts if `$id` is omitted.

```php
$host = $client->getHost(123);
$allHosts = $client->getHost();
```

---

### Request Methods

#### `getRequest($id = null)`

Fetch a request by ID or fetch all requests.

```php
$request = $client->getRequest(5001);
$allRequests = $client->getRequest();
```

#### `getDailyRequests($date = null)`

Returns all requests for a given date.
If `$date` is omitted, the API's default will be used.

```php
$daily = $client->getDailyRequests('2024-06-10');
```

#### `getDocTypeCounts($extension)`

Returns document-type frequency counts for the given file extension.

```php
$counts = $client->getDocTypeCounts('pdf');
```

---

### Searching

#### `search($endpoint, $key, $value)`

Generic search utility for any searchable endpoint.

```php
$results = $client->search('request', 'ip', '192.168.0.1');
```

---

## Error Handling

All API responses are checked for an `error` property.
If present, an `Exception` is thrown:

```php
try {
    $host = $client->getHost(10);
} catch (Exception $e) {
    echo "API error: " . $e->getMessage();
}
```

---

## Related API Documentation

Full API reference and per-endpoint documentation:

* Requests

  * GetRequest
  * GetAllRequests
  * GroupRequests
  * RecentRequests
  * SearchRequests

* Hosts

  * GetHost
  * GetAllHosts
  * CreateHost
  * UpdateHost
  * GroupHosts
  * RecentHosts
  * SearchHosts

* Clients

  * GetClient
  * GetAllClients
  * GroupClients
  * RecentClients
  * SearchClients

* LogMonitorRuns

  * GetLogMonitorRun
  * GetAllLogMonitorRuns
  * GroupLogMonitorRuns
  * RecentLogMonitorRuns
  * SearchLogMonitorRuns

---

## Reporting Issues

* **API bugs / feature requests:**
  [https://github.com/outlawdesigns-io/WebAccessService/issues](https://github.com/outlawdesigns-io/WebAccessService/issues)

* **Performance or availability:**
  mailto:[j.watson@outlawdesigns.io](mailto:.watson@outlawdesigns.io)
