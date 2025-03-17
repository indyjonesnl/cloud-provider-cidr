# Cloud Provider CIDR

A simple Symfony application that downloads IPv4 CIDR addresses from Cloud Providers to compile a simple list of public cloud CIDR's.
A CIDR list can be used to block/throttle incoming web requests, so crawlers/scrapers/spiders/bots can be more easily recognised and/or prevented.

### Commands

Download all CIDR ranges from all providers:
```shell
  bin/console app:download
```

Run a single provider (for testing purposes), passing the provider name:
```shell
  bin/console app:single hetzner
```

Note: add `-vvv` to the command for verbose mode:
```shell
  bin/console app:single aws -vvv
```

### Cloud providers:

- [Akamai Cloud (including Linode)](./data/akamai.txt)

- [Alibaba Cloud](./data/alibaba.txt)

- [Amazon Web Services (AWS)](./data/aws.txt)

- [Cloudflare](./data/cloudflare.txt)

- [Google Cloud Platform (CGP)](./data/gcp.txt)

- [Hetzner Cloud](./data/hetzner.txt)

- [IBM Cloud](./data/ibm.txt)

- [Microsoft Azure](./data/azure.txt)

- [Oracle Cloud](./data/oracle.txt)

- [Strato](./data/strato.txt)