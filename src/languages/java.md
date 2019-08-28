# Java

Java is a general-purpose programming language, and one of the most popular in the world today. Platform.sh supports Java runtimes that can be used with build management tools such as Gradle, Maven, and Ant.


## Supported versions

### OpenJDK versions:

* 8
* 11
* 12
* 13

To select a Java version, specify a `type` such as `java:13`:

```yaml
# .platform.app.yaml
type: "java:13"
```

## Support libraries

While it is possible to read the environment directly from your application, it is generally easier and more robust to use the [`platformsh/config-reader`](https://github.com/platformsh/config-reader-java) which handles decoding of service credential information for you.

## Support build automation

Platform.sh supports the most common project management tools in the Java ecosystem, including:

* [Gradle](https://gradle.org/)
* [Maven](https://maven.apache.org/)
* [Ant](https://ant.apache.org/)

The [configuration reader library](https://github.com/platformsh/config-reader-java) for Java makes the integration much smoother between Platform.sh and your Java code. Be sure to check out the [latest version](https://mvnrepository.com/artifact/sh.platform/config) before getting started.

### Maven

```xml
<dependency>
    <groupId>sh.platform</groupId>
    <artifactId>config</artifactId>
    <version>version</version>
</dependency>
```

### Gradle

```
compile group: 'sh.platform', name: 'config', version: '2.2.1'
```

## Accessing services

To access various [services](/configuration/services.md) with Java, see the following examples.  The individual service pages have more information on configuring each service.


{% codetabs name="Elasticsearch", type="java", url="https://examples.docs.platform.sh/java/elasticsearch" -%}

{%- language name="Kafka", type="java", url="https://examples.docs.platform.sh/java/kafka" -%}

{%- language name="Memcached", type="java", url="https://examples.docs.platform.sh/java/memcached" -%}

{%- language name="MongoDB", type="java", url="https://examples.docs.platform.sh/java/mongodb" -%}

{% language name="MySQL", type="java", url="https://examples.docs.platform.sh/java/mysql" -%}

{% language name="PostgreSQL", type="java", url="https://examples.docs.platform.sh/java/postgresql" -%}

{%- language name="RabbitMQ", type="java", url="https://examples.docs.platform.sh/java/rabbitmq" -%}

{% language name="Redis", type="java", url="https://examples.docs.platform.sh/java/redis" -%}

{%- language name="Solr", type="java", url="https://examples.docs.platform.sh/java/solr" -%}

{%- endcodetabs %}

## Project templates

A number of project templates for major Java applications are available on GitHub. Not all of them are proactively maintained but all can be used as a starting point or reference for building your own website or web application.

### Applications

#### Spring

* [Spring Boot MySQL](https://github.com/platformsh/template-spring-boot-maven-mysql)
* [Spring Boot MongoDB](https://github.com/platformsh/template-spring-mvc-maven-mongodb)

#### Jakarta EE/ Eclipse MicroProfile

* [Apache Tomee](https://github.com/platformsh/template-microprofile-tomee)
* [Thorntail](https://github.com/platformsh/template-microprofile-thorntail)
* [Payara Micro](https://github.com/platformsh/template-microprofile-payara)
* [KumuluzEE](https://github.com/platformsh/template-microprofile-kumuluzee)
* [Helidon](https://github.com/platformsh/template-microprofile-helidon)
* [Open Liberty](https://github.com/platformsh/template-microprofile-openliberty)