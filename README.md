# Webhook Receiver Lab (PHP)

Minimal yet production-style **webhook receiver built in PHP** with:

-   HMAC signature validation (SHA-256)
-   JSON payload persistence
-   Structured logging
-   Proper HTTP status handling
-   Local testing example

> Designed to demonstrate secure webhook handling in real-world backend
> systems.

------------------------------------------------------------------------

## ✨ Features

-   ✅ `POST /` webhook endpoint
-   ✅ HMAC SHA-256 signature validation (`X-Signature` header)
-   ✅ JSON payload validation
-   ✅ File persistence (`storage/payloads`)
-   ✅ Structured JSON logging
-   ✅ Example signed sender script

------------------------------------------------------------------------

## 🧭 Architecture (High Level)

~~~mermaid
flowchart LR
  A["External Service"] -->|POST Webhook| B["public/index.php"]
  B --> C["Signature Validation (HMAC)"]
  C --> D["JSON Validation"]
  D --> E["Storage (payloads/)"]
  D --> F["Logger (logs/app.log)"]
~~~

------------------------------------------------------------------------

## 🚀 Quick Start

### 1) Requirements

-   PHP 8.0+

------------------------------------------------------------------------

### 2) Setup environment

``` bash
cp .env.example .env
```

Edit `.env` if needed:

-   `WEBHOOK_SECRET`
-   `LOG_PATH`
-   `PAYLOAD_STORAGE_PATH`

------------------------------------------------------------------------

### 3) Run local server

``` bash
php -S 127.0.0.1:8000 -t public
```

------------------------------------------------------------------------

## 🧪 Test the Webhook

In another terminal:

``` bash
php examples/send-signed-webhook.php
```

If the signature matches, you should receive:

``` json
{
  "status": "ok"
}
```

------------------------------------------------------------------------

## 🔐 Signature Validation

The webhook validates requests using:

    hash_hmac('sha256', payload, WEBHOOK_SECRET)

The sender must include:

    X-Signature: <computed_hash>

If the signature is invalid:

-   HTTP 401 is returned
-   Error is logged

------------------------------------------------------------------------

## 📁 Project Structure

    webhook-receiver-lab/
    ├─ public/
    │  └─ index.php
    ├─ src/
    │  ├─ Config.php
    │  ├─ Logger.php
    │  └─ Webhook/
    │     ├─ Signature.php
    │     └─ Storage.php
    ├─ storage/
    │  ├─ logs/
    │  └─ payloads/
    ├─ examples/
    │  ├─ send-signed-webhook.php
    │  └─ sample-payload.json
    ├─ .env.example
    └─ README.md

------------------------------------------------------------------------

## 🪵 Logging

Logs are written in JSON format to:

`storage/logs/app.log`

Example:

``` json
{
  "timestamp": "2026-02-15T00:00:00Z",
  "level": "INFO",
  "message": "Webhook received",
  "context": {
    "file": "storage/payloads/1700000000_ab12cd34.json"
  }
}
```

------------------------------------------------------------------------

## 🔒 Security Notes

-   `.env` is not committed
-   No real secrets in repository
-   Uses constant-time comparison (`hash_equals`)
-   Clean separation between validation, storage, and logging

------------------------------------------------------------------------

## 🗺️ Roadmap

-   [ ] Add replay attack protection (timestamp window)
-   [ ] Add request ID correlation
-   [ ] Add webhook retry simulation script
-   [ ] Add queue processing example

------------------------------------------------------------------------

## 📬 Author

**Rober Lopez**\
Backend & API Integration Specialist · Payments · Automation ·
UX/UI-minded Engineer

-   🌐 Website: https://roberlopez.com
-   💻 GitHub: https://github.com/kirito18
-   🔗 LinkedIn: https://www.linkedin.com/in/web-rober-lopez/
