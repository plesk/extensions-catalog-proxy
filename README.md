# Smart Proxy Example for ext.plesk.com

Here is the example of smart proxy for extensions catalog for Plesk.
It allows you to filter the extensions or modify metadata attributes (for not installed extensions).

Example utilizes the Docker to simplify the demonstration and/or deployment.
We need a webserver and some scripting tool. Here we use nginx and php official Docker images.

One can clone the repo and start the containers using docker-compose command:
```bash
cd extensions-catalog-proxy ; docker-compose up
```

The last step is to say Plesk to use a proxy instead of original extensions catalog.
Log in to Plesk server via SSH as root and type the following:
```bash
plesk conf panel.ini
```

The default editor will be opened, you need to add the following lines:
```
[extensions]
catalog.url = "http://<proxy-address>:8080"
```
Where <proxy-address> should be replaced with real proxy address (IP of machine, where docker-compose has been launched).

That's all.
To manage a 'while list' filter just edit [site/index.php](site/index.php) and adjust a list of extensions.
To get a full list of extensions you can use https://ext.plesk.com/api/v4/packages
