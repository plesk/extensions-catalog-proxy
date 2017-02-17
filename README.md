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

That's all. To improve custom logic of filtering you can modify [site/index.php](site/index.php) file.
