# Zendesk-Scheduler

A simple method of scheduling reoccuring tickets within Zendesk, something the system doesn't natively do.

## Installation
### Configure Zendesk
- Log into Zendesk as the user you would like as your control (the system needs an API connector from a specific user)
- Go to Settings > Channels > API
- Create a new API Token for the website, it can be named anything
- Take down the Token received, this is required later on

- Go to Settings > People
- If one doesn't exist already, create a new End user to use as the requester
- Go into that user profile
- Take the User ID from the URL, eg: https://mycompany.zendesk.com/agent/users/302149092/tickets
- Take down the User ID, this is required later on

### Import the Zendesk PHP API with Composer

``
composer require zendesk/zendesk_api_client_php
``

### Configure the website
This can be done however you see fit, it's just a standard PHP site with MySQL backend

